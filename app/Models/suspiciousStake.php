<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class suspiciousStake extends Model
{
    use HasFactory;

    protected $table = "suspicious_stake";

    public $timestamps = false;
}
