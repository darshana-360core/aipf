<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class withdrawModel extends Model
{
    use HasFactory;

    protected $table = "withdraw";

    public $timestamps = false;
}
