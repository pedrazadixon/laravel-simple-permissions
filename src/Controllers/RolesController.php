<?php

namespace Pedrazadixon\LaravelSimplePermissions\Controllers;

use Illuminate\Http\Request;
use Pedrazadixon\LaravelSimplePermissions\Models\Roles;

class RolesController
{
    public function index()
    {
        $roles = Roles::all();
        return view('laravel-simple-permissions::roles.index', compact('roles'));
    }

    public function create(Request $request)
    {
        return view('laravel-simple-permissions::roles.create');
    }

    public function edit(Roles $rol)
    {
        return view('laravel-simple-permissions::roles.edit', compact('rol'));
    }

    public function update(Request $request, Roles $rol)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $rol->id
        ]);

        $rol->name = $request->name;

        if ($request->description) {
            $rol->description = $request->description;
        }

        $rol->save();

        return redirect()->route('roles.index', $rol->id)->with('status', 'role-updated');
    }

    public function destroy(Roles $rol)
    {
        $rol->permissions()->delete();
        $rol->delete();
        return redirect()->route('roles.index')->with('status', 'role-deleted');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name'
        ]);

        $rol = new Roles();
        $rol->name = $request->name;

        if ($request->description) {
            $rol->description = $request->description;
        }

        $rol->save();

        return redirect()->route('permissions.index', $rol->id)->with('status', 'role-created');
    }
}
