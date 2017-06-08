<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Committee extends Model
{
    protected $table = 'committees';

	public function __construct(Array $properties=array()) {
		foreach ($properties as $key => $value) {
			$this->{$key} = $value;
		}
	}
}
