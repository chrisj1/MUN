<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable {
	use HasRoles;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'email', 'password', 'school',];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var arrays
	 */
	protected $hidden = ['password', 'remember_token',];

	function isAdmin() {
		return count(Admin::where('user_id', $this->id)->get()) == 1;
	}

	function isChair() {
		foreach(Committee::all() as $committee) {
			if($committee->chair == $this->id) return true;
		}
		return false;
	}
}
