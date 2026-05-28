<?php
// ──────────────────────────────────────────────────────────
// app/Http/Controllers/Api/SupplyController.php
// ──────────────────────────────────────────────────────────
namespace App\Http\Controllers\Api;
 
use App\Http\Controllers\Controller;
use App\Models\Supply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
 
class SupplyController extends Controller
{
    public function index(Request $request)
    {
        $query = Supply::query();
 
        if ($search = $request->q)        $query->where(fn($q) => $q->where('name','like',"%$search%")->orWhere('sku','like',"%$search%"));
        if ($cat    = $request->category)  $query->where('category', $cat);
        if ($status = $request->status) {
            match ($status) {
                'ok'  => $query->whereRaw('stock > low_stock_threshold'),
                'low' => $query->whereRaw('stock > 0 AND stock <= low_stock_threshold'),
                'out' => $query->where('stock', 0),
                default => null,
            };
        }
 
        return response()->json($query->get()->map(fn($s) => [
            'id'       => $s->id,
            'name'     => $s->name,
            'sku'      => $s->sku,
            'category' => $s->category,
            'stock'    => $s->stock,
            'price'    => $s->price,
            'thresh'   => $s->low_stock_threshold,
            'image'    => $s->image_path ? Storage::url($s->image_path) : null,
            'status'   => $s->stock_status,
        ]));
    }
 
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'                => 'required|string|max:255',
            'sku'                 => 'nullable|string|unique:supplies,sku',
            'category'            => 'required|string',
            'stock'               => 'required|integer|min:0',
            'price'               => 'required|numeric|min:0',
            'low_stock_threshold' => 'required|integer|min:1',
            'image'               => 'nullable|image|max:2048',
        ]);
 
        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('supplies', 'public');
        }
 
        return response()->json(Supply::create($data), 201);
    }
 
    public function update(Request $request, Supply $supply)
    {
        $data = $request->validate([
            'name'                => 'sometimes|string|max:255',
            'sku'                 => 'sometimes|string|unique:supplies,sku,' . $supply->id,
            'category'            => 'sometimes|string',
            'stock'               => 'sometimes|integer|min:0',
            'price'               => 'sometimes|numeric|min:0',
            'low_stock_threshold' => 'sometimes|integer|min:1',
            'image'               => 'nullable|image|max:2048',
        ]);
 
        if ($request->hasFile('image')) {
            if ($supply->image_path) Storage::disk('public')->delete($supply->image_path);
            $data['image_path'] = $request->file('image')->store('supplies', 'public');
        }
 
        $supply->update($data);
        return response()->json($supply);
    }
 
    public function adjustStock(Request $request, Supply $supply)
    {
        $delta = (int) $request->validate(['delta' => 'required|integer'])['delta'];
        $supply->stock = max(0, $supply->stock + $delta);
        $supply->save();
 
        return response()->json(['stock' => $supply->stock, 'status' => $supply->stock_status]);
    }
 
    public function restock(Request $request, Supply $supply)
    {
        $qty = (int) $request->validate(['qty' => 'required|integer|min:1'])['qty'];
        $supply->increment('stock', $qty);
 
        return response()->json(['stock' => $supply->fresh()->stock]);
    }
 
    public function destroy(Supply $supply)
    {
        if ($supply->image_path) Storage::disk('public')->delete($supply->image_path);
        $supply->delete();
 
        return response()->json(['deleted' => true]);
    }
}