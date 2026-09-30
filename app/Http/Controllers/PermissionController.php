<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display all permissions
     */
    public function index()
    {
        $permissions = Permission::latest()
            ->get();

        return view('backend.permission.index', compact('permissions'));
    }
    public function create()
    {
        return view('backend.permission.add');
    }       



    /**
     * Store new permission
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
        ]);

        Permission::create([
            'name'   => $validated['name'],
            // 'guard_name' => 'web',
    
        ]);

        return redirect()->route('permissions.index')
            ->with('success', 'Permission created successfully.');
    }

    /**
     * Edit permission
     */
    public function edit($id)
    {
        $permission = Permission::findOrFail($id);

        return view('admin.permission.edit', compact('permission'));
    }

    /**
     * Update permission
     */
    public function update(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name,' . $id,
        ]);

        $permission->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
        ]);

        return redirect()->route('admin.permission')
            ->with('success', 'Permission updated successfully.');
    }

    /**
     * Soft delete (trash = true)
     */
    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);

        $permission->update([
            'trash' => true
        ]);

        return redirect()->route('admin.permission')
            ->with('success', 'Permission moved to trash.');
    }
}
