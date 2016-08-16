<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use App\Admin;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasRoles;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'school',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var arrays
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isAdmin() {
	    if(count(Admin::where('user_id', Auth::id())->get()) == 0) {
		    return false;
	    }
	    return true;
    }

}
