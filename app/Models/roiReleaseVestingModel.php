<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class roiReleaseVestingModel extends Model
{
    use HasFactory;

    protected $table = "roi_release_history";

    public $timestamps = false;

    protected $fillable = [
            'wallet_address',
            'amount',
            'transaction_hash',
            'start_datetime',
            'end_datetime',
            'created_on'
        ];
}
