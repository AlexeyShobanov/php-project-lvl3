<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DomainCheck extends Model
{
    protected $fillable = [
        'status_code',
        'h1',
        'keywords',
        'description'
    ];

    public function domain()
    {
        return $this->belongsTo('App\Domain');
    }
}
