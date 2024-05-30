<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;
    protected $fillable = ['customer_id', 'fechapago', 'totalpago', 'formapago','documentopago','desde','hasta'];


    public  function customer(){
        return $this->belongsTo(Customer::class);
    }



}
