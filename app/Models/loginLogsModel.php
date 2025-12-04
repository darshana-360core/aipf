<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class loginLogsModel extends Model
{
    use HasFactory;

    protected $table = "login_logs";

    public $timestamps = false;
}
