<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    protected $fillable = ['name'];

    public function checks()
    {
        return $this->hasMany('App\DomainCheck');
    }
}
