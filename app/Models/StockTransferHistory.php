<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockTransferHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_name',
        'transfer_type',
        'quantity',
        'is_success',
        'error_message',
    ];
}
