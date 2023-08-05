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
}
