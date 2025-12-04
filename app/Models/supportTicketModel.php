<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class supportTicketModel extends Model
{
    use HasFactory;

    protected $table = "support_tickets";

    public $timestamps = false;
}
