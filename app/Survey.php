<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    //
    protected $table = "surveys";
    protected $fillable = ["name","description","category"];
    public $timestamps = false;

}
