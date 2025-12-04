<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class myTeamModel extends Model
{
    use HasFactory;

    protected $table = "my_team";

    public $timestamps = false;
}
