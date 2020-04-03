<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DomainCheck extends Model
{
   public function domain()
    {
        return $this->belongsTo(__NAMESPACE__ . '\Domain');
    }
}
