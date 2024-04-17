<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $fillable = ['base','precio','entrada_id', 'pp_id','postre_id' ];

    public static function rules($id)
    {

            return
            [
                'base' => 'required',
                'precio' => 'required|numeric',
                'entrada_id'=> 'required',
                'pp_id'=> 'required',
                'postre_id'=> 'required',
            ];


    }

    public static $messages = [
        'base.required' => 'La base del menú es requerido ',
        'precio.required' => 'El precio del menú es requerido ',
        'precio.numeric' => 'El precio debe ser una cantidad',
        'entrada_id.required' => 'La entrada del menú es requerido ',
        'pp_id.required' => 'El plato principal  del menú es requerido ',
        'postre_id.required' => 'El postre del menú es requerido ',

    ];

    public  function entrada()
    {
        return $this->hasOne(Entrada::class);
    }
    public function pp (){
        return $this->hasOne(Pp::class);
    }
    public function postre (){
        return $this->hasOne(Postre::class);
    }
}
