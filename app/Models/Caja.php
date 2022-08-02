<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    use HasFactory;

    protected $fillable = ['nombre','status','user_id'];

    public static function rules($id)
    {
        if($id <=0){
            return
            [
                'nombre' => 'required|min:3|max:50|unique:cajas',
                'status' => 'required|not_in:elegir',
                'user_id'=> 'required|not_in:elegir'
            ];
        }
        else
        {
            return
            [
                'nombre' => "required|min:3|max:50|unique:cajas,nombre,{$id}",
                'status' => "required|not_in:elegir",
                'user_id'=> 'required|not_in:elegir'
            ];
        }
    }

    public static $messages =[
        'nombre.required' => 'nombre requerido',
        'nombre.min' => 'nombre debe tener al menos 3 caracteres',
        'nombre.max' => 'nombre debe tener maximo 50 caracteres',
        'nombre.unique' => 'nombre caja ya existe en la bada de datos',
        'status.required' => 'status es requerido',
        'status.not_in' => 'Seleccione un usuario válido',
        'user_id.required' => 'usuario de caja requerido',
        'user_id.not_in' => 'Seleccione un usuario válido'
    ];



    public function user()
    {
        return $this->belongsTo(User::class);
    }



}
