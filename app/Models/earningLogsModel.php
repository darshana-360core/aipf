<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class earningLogsModel extends Model
{
    use HasFactory;

    protected $table = "earning_logs";

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'amount',
        'tag',
        'refrence',
        'refrence_id',
        'status',
        'isCount',
        'isSynced',
        'transaction_hash',
        'flush_amount',
        'created_on',
    ];
}
