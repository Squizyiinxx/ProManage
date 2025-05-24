<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\RedirectResponse;

class PermissionController extends Controller
{
    public function store(Request $request):RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|unique:permissions,name',
        ]);

        Permission::create(['name' => $validated['name']]);
        return redirect()->back()->with('success', 'Permission created.');
    }

}
