<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;
    protected $fillable = ['total','items','descuento','estado','customer_id','user_id']; //fecha del pedido created_at


      //relaciones
      public function detalles()
      {
          return $this->hasMany(DetallePedido::class);

      }

      public function user()
      {
          return $this->belongsTo(User::class);
      }

      public function customer()
      {
          return $this->belongsTo(Customer::class)->withDefault();
      }

}
