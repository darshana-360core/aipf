<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SingleTokenStakeModel extends Model
{
    use HasFactory;

    // Explicitly set table name (optional if matches Laravel's plural convention)
    protected $table = 'single_token_stake_plan_setting';

    // Allow mass assignment for these fields
    protected $fillable = [
        'planname',
        'daily_bonus_rate',
        'dora_count_for_bonus',
    ];

    // Cast decimals into floats automatically
    protected $casts = [
        'daily_bonus_rate'     => 'float',
    ];
}
