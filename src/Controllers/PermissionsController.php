<?php

namespace Pedrazadixon\LaravelSimplePermissions\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Pedrazadixon\LaravelSimplePermissions\Models\Roles;

class PermissionsController
{
    public function index(Roles $rol)
    {
        $routeCollection = Route::getRoutes();
        foreach ($routeCollection as $route) {
            if (in_array('permissions', $route->middleware())) {


                if (str_contains($route->getActionName(), 'Controller@')) {
                    $controller = explode('@', $route->getAction()['controller'])[0];
                    $method = explode('@', $route->getAction()['controller'])[1];
                    $controller = str_replace('App\Http\Controllers\\', '', $controller);
                    $controllers[$controller][] = [
                        'name' => $method,
                        'action' => $route->getAction()['controller'],
                    ];
                }

                if ($route->getActionName() === 'Closure') {
                    $controllers['Closures'][] = [
                        'name' => $route->uri,
                        'action' => implode('|', $route->methods()) . '@' . $route->uri,
                    ];
                }
            }
        }

        $roles = Roles::all()->where('id', '!=', 1);

        $rol_permisions = $rol->permissions->pluck('action')->toArray();

        return view('laravel-simple-permissions::permissions.index', compact('controllers', 'roles', 'rol_permisions', 'rol'));
    }

    public function store(Request $request)
    {
        $rol = Roles::find($request->rol_id);

        if ($rol->id == 1) {
            session()->flash('status', 'You can not edit this role');
            return redirect()->route('roles.index');
        }

        $current_permisions = $rol->permissions->pluck('action')->toArray();
        $new_permisions = $request->permissions ?? [];
        $to_add = array_diff($new_permisions, $current_permisions);
        $to_remove = array_diff($current_permisions, $new_permisions);

        if (empty($to_add) && empty($to_remove)) {
            session()->flash('status', 'No changes were made');
            return redirect()->route('permissions.index', $rol);
        }

        foreach ($to_add as $action) {
            $rol->permissions()->create([
                'action' => $action,
            ]);
        }

        foreach ($to_remove as $action) {
            $rol->permissions()->where('action', $action)->delete();
        }

        session()->flash('status', 'Permissions updated successfully');

        return redirect()->route('permissions.index', $rol);
    }
}
