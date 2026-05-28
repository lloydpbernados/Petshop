<?php
// ──────────────────────────────────────────────────────────
// app/Http/Controllers/Api/ServiceController.php
// ──────────────────────────────────────────────────────────
namespace App\Http\Controllers\Api;
 
use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
 
class ServiceController extends Controller
{
    public function index()
    {
        return response()->json(Service::latest()->get()->map(fn($s) => [
            'id'     => $s->id,
            'name'   => $s->name,
            'icon'   => $s->icon,
            'status' => $s->status,
            'price'  => $s->price,
            'desc'   => $s->description,
        ]));
    }
 
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'icon'        => 'required|string',
            'status'      => 'required|in:Active,Draft',
            'price'       => 'required|numeric|min:0',
            'description' => 'required|string',
        ]);
 
        return response()->json(Service::create($data), 201);
    }
 
    public function update(Request $request, Service $service)
    {
        $data = $request->validate([
            'name'        => 'sometimes|string|max:255',
            'icon'        => 'sometimes|string',
            'status'      => 'sometimes|in:Active,Draft',
            'price'       => 'sometimes|numeric|min:0',
            'description' => 'sometimes|string',
        ]);
 
        $service->update($data);
        return response()->json($service);
    }
 
    public function destroy(Service $service)
    {
        $service->delete();
        return response()->json(['deleted' => true]);
    }
}