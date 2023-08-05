<?php

namespace Pedrazadixon\LaravelSimplePermissions\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Pedrazadixon\LaravelSimplePermissions\Models\User;

class Permissions
{
    public function handle(Request $request, Closure $next): Response
    {
        // find authenticated user from custom user model
        $authenticated_user = User::find(auth()->user()->id);

        // allow admin to do anything
        if ($authenticated_user->role_id == 1)
            return $next($request);

        // validate permissions for current user
        $user_permissions = $authenticated_user->rol->permissions->pluck('action')->toArray();

        if (str_contains($request->route()->getActionName(), 'Controller@')) {
            $requested_action = $request->route()->getAction()['controller'];
        }

        if ($request->route()->getActionName() === 'Closure') {
            $requested_action = implode('|', $request->route()->methods()) . '@' . $request->route()->uri;
        }

        if (!in_array($requested_action, $user_permissions))
            abort(403, 'No access permission.');

        return $next($request);
    }
}
