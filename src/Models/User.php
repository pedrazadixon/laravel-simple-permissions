<?php

namespace Pedrazadixon\LaravelSimplePermissions\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User as AppUser;

class User extends AppUser
{
    use HasFactory;

    public function rol()
    {
        return $this->belongsTo(Roles::class, 'role_id');
    }

    public function canDo($route_name)
    {
        if (auth()->user()->role_id == 1) return true;

        $user = $this->find(auth()->user()->id);
        $user_permissions = $user->rol->permissions->pluck('action')->toArray();

        $route = app('router')->getRoutes()->getByName($route_name);

        if (str_contains($route->getActionName(), 'Controller@')) 
            $route_action = $route->getAction()['controller'];

        if ($route->getActionName() === 'Closure') 
            $route_action = implode('|', $route->methods()) . '@' . $route->uri;
        
        return in_array($route_action, $user_permissions);
    }
}
