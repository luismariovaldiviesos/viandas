<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = ['businame','typeidenti','valueidenti','address','email','phone','notes'];




    //relaciones
    public function  orders()
    {
        return $this->hasMany(Order::class);
    }



}
