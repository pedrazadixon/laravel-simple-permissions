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

        return redirect()->route('permissions.index', $rol->id)->with('status', 'Role created, please add permissions.');
    }

    public function destroy(Roles $rol)
    {
        // check if role has users
        if ($rol->users()->count() > 0)
            return redirect()->route('roles.index')->with('status', 'Role has users, cannot be deleted.');

        $rol->permissions()->delete();
        $rol->delete();
        return redirect()->route('roles.index')->with('status', 'role-deleted');
    }
}
