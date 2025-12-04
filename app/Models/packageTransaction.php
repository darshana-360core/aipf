<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class packageTransaction extends Model
{
    use HasFactory;

    protected $table = "package_transaction";

    public $timestamps = false;
}
