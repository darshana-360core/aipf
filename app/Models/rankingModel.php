<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rankingModel extends Model
{
    use HasFactory;

    protected $table = "ranking";

    public $timestamps = false;
}
