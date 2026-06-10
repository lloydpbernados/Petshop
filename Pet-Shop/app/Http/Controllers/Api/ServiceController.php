<?php
// ──────────────────────────────────────────────────────────
// app/Http/Controllers/Api/ServiceController.php
// ──────────────────────────────────────────────────────────
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'image'  => $s->image_path ? Storage::url($s->image_path) : null,
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
            'image'       => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('services', 'public');
        }

        $service = Service::create($data);

        return response()->json([
            'id'     => $service->id,
            'name'   => $service->name,
            'icon'   => $service->icon,
            'status' => $service->status,
            'price'  => $service->price,
            'desc'   => $service->description,
            'image'  => $service->image_path ? Storage::url($service->image_path) : null,
        ], 201);
    }

    public function update(Request $request, Service $service)
    {
        $data = $request->validate([
            'name'        => 'sometimes|string|max:255',
            'icon'        => 'sometimes|string',
            'status'      => 'sometimes|in:Active,Draft',
            'price'       => 'sometimes|numeric|min:0',
            'description' => 'sometimes|string',
            'image'       => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($service->image_path) {
                Storage::disk('public')->delete($service->image_path);
            }
            $data['image_path'] = $request->file('image')->store('services', 'public');
        }

        $service->update($data);

        return response()->json([
            'id'     => $service->id,
            'name'   => $service->name,
            'icon'   => $service->icon,
            'status' => $service->status,
            'price'  => $service->price,
            'desc'   => $service->description,
            'image'  => $service->image_path ? Storage::url($service->image_path) : null,
        ]);
    }

    public function destroy(Service $service)
    {
        if ($service->image_path) {
            Storage::disk('public')->delete($service->image_path);
        }
        $service->delete();
        return response()->json(['deleted' => true]);
    }
}