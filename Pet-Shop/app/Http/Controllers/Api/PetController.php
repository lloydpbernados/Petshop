<?php
 
// ──────────────────────────────────────────────────────────
// app/Http/Controllers/Api/PetController.php
// ──────────────────────────────────────────────────────────
namespace App\Http\Controllers\Api;
 
use App\Http\Controllers\Controller;
use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
 
class PetController extends Controller
{
    public function index(Request $request)
    {
        $query = Pet::query();
 
        if ($search = $request->q) {
            $query->where(fn($q) => $q->where('name', 'like', "%$search%")
                                      ->orWhere('sku',  'like', "%$search%"));
        }
        if ($cat = $request->category) {
            $query->where('category', $cat);
        }
        if ($status = $request->status) {
            match ($status) {
                'ok'  => $query->whereRaw('stock > low_stock_threshold'),
                'low' => $query->whereRaw('stock > 0 AND stock <= low_stock_threshold'),
                'out' => $query->where('stock', 0),
                default => null,
            };
        }
 
        return response()->json($query->get()->map(fn($p) => [
            'id'        => $p->id,
            'name'      => $p->name,
            'sku'       => $p->sku,
            'category'  => $p->category,
            'gender'    => $p->gender,
            'stock'     => $p->stock,
            'price'     => $p->price,
            'thresh'    => $p->low_stock_threshold,
            'image'     => $p->image_path ? Storage::url($p->image_path) : null,
            'status'    => $p->stock_status,
        ]));
    }
 
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'                => 'required|string|max:255',
            'sku'                 => 'nullable|string|unique:pets,sku',
            'category'            => 'required|string',
            'gender'              => 'nullable|string',
            'stock'               => 'required|integer|min:0',
            'price'               => 'required|numeric|min:0',
            'low_stock_threshold' => 'required|integer|min:1',
            'image'               => 'nullable|image|max:2048',
        ]);
 
        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('pets', 'public');
        }
 
        $pet = Pet::create($data);
 
        return response()->json($pet, 201);
    }
 
    public function update(Request $request, Pet $pet)
    {
        $data = $request->validate([
            'name'                => 'sometimes|string|max:255',
            'sku'                 => 'sometimes|string|unique:pets,sku,' . $pet->id,
            'category'            => 'sometimes|string',
            'gender'              => 'nullable|string',
            'stock'               => 'sometimes|integer|min:0',
            'price'               => 'sometimes|numeric|min:0',
            'low_stock_threshold' => 'sometimes|integer|min:1',
            'image'               => 'nullable|image|max:2048',
        ]);
 
        if ($request->hasFile('image')) {
            if ($pet->image_path) Storage::disk('public')->delete($pet->image_path);
            $data['image_path'] = $request->file('image')->store('pets', 'public');
        }
 
        $pet->update($data);
 
        return response()->json($pet);
    }
 
    /** Quick stock adjustment (+/-) */
    public function adjustStock(Request $request, Pet $pet)
    {
        $delta = (int) $request->validate(['delta' => 'required|integer'])['delta'];
        $pet->stock = max(0, $pet->stock + $delta);
        $pet->save();
 
        return response()->json(['stock' => $pet->stock, 'status' => $pet->stock_status]);
    }
 
    /** Log an arrival / restock */
    public function restock(Request $request, Pet $pet)
    {
        $qty = (int) $request->validate(['qty' => 'required|integer|min:1'])['qty'];
        $pet->increment('stock', $qty);
 
        return response()->json(['stock' => $pet->fresh()->stock]);
    }
 
    public function destroy(Pet $pet)
    {
        if ($pet->image_path) Storage::disk('public')->delete($pet->image_path);
        $pet->delete();
 
        return response()->json(['deleted' => true]);
    }
}