<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallePedido extends Model
{
    use HasFactory;
    protected $fillable = ['pedido_id', 'menu_id', 'cantidad', 'precio'];


     // un detalle pertenece a un pedido (a una venta a una cabecera factura ctm )
     public function pedido()
     {
         return $this->belongsTo(Pedido::class);
     }

      // un detalle pertenece a un menu (a una venta a una cabecera factura ctm )
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

}
