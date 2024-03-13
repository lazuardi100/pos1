<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    public function customers(){
        return $this->belongsTo(Customer::class,'customer_id','customer_id');
    }

    public function offline_customer(){
        return $this->belongsTo(Customer::class,'customer_id','id');
    }
    public function carts(){
        return$this->hasMany(cart::class);
    }

}
