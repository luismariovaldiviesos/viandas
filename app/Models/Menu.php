<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $fillable = ['base','precio','activo','entrada_id', 'pp_id','postre_id' ];

    // public static function rules($id)
    // {
    //     if($id <= 0){

    //         return  //crear
    //         [
    //             'base' => 'required',
    //             'precio' => 'required',
    //             'entrada_id'=> 'required',
    //             'pp_id'=> 'required',
    //             'postre_id'=> 'required',
    //         ];

    //     } else{
    //         return
    //         [
    //             'base' => 'required',
    //             'precio' => 'required',
    //             'entrada_id'=> 'required',
    //             'pp_id'=> 'required',
    //             'postre_id'=> 'required',
    //         ];
    //     }




    // }

    // public static $messages = [
    //     'base.required' => 'La base del menú es requerido ',
    //     'precio.required' => 'El precio del menú es requerido ',
    //     'entrada_id.required' => 'La entrada del menú es requerido ',
    //     'pp_id.required' => 'El plato principal  del menú es requerido ',
    //     'postre_id.required' => 'El postre del menú es requerido ',

    // ];


    //menus activos
    public static function activos()
    {
        return self::where('activo',true)->get();
    }



    // unmenu pertenece a  una entrada

    public  function entrada()
    {
        return $this->belongsTo(Entrada::class);
    }

    public function pp (){
        return $this->belongsTo(Pp::class);
    }
    public function postre (){
        return $this->belongsTo(Postre::class);
    }

    public function pedidos()
    {
       return $this->hasMany(DetallePedido::class);
    }


    // una renta pertenece a un inquilino
    // public function tenant()
    // {
    //     return $this->belongsTo(Tenant::class);
    // }


    // un inquilino puede tener varias rentas
    // public function rent()
    // {
    //     return $this->hasMany(Rent::class);
    // }
}
