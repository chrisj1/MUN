<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Money extends Model
{
    private $cents;

    public function __construct($cents)
    {
        $this->$cents = (integer) $cents;
    }

    public static function fromDollars($dollars)
    {
        return new static($dollars * 100);
    }

    public static function fromCents($cents)
    {
        return new static($cents);
    }

    public function inCents()
    {
        return (string) $this->cents;
    }

    public function inDollars()
    {
        return (string) ( $this->cents / 100 );
    }

    public function inDollarsAndCents()
    {
        return number_format( $this->cents / 100, 2 );
    }
}
