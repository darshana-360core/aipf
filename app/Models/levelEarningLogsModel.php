<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class levelEarningLogsModel extends Model
{
    use HasFactory;

    protected $table = "level_earning_logs";

    public $timestamps = false;
}
