<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'title',
    ];

  public function permissions(){
    return $this->belongsToMany(Permission::class,'permission_role');
  }
}
