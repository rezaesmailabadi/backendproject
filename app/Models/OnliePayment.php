<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnliePayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'user_id',
        'status',
        'status_bank',
        'transaction_id',
    ];
}
