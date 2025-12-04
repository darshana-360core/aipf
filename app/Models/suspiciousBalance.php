<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class suspiciousBalance extends Model
{
    use HasFactory;

    protected $table = "suspicious_balance";

    public $timestamps = false;
}
