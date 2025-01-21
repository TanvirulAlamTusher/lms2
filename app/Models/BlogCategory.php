<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{

    protected $guarded = [];

    public function blogcat(){
        return $this->hasMany(BlogPost::class);
    }

}
