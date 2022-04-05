<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment_done extends Model
{
    use HasFactory;
    protected $fillable = [
        'reason',
        'amount',
        'appointment_id',
    ];
}
