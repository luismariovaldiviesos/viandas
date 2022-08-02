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
        if ($id <= 0) {
            return [
                'nombre' => 'required|min:3|max:50|unique:cajas',
                'user_id' => 'required',
            ];
        } else {
            return [
                'nombre' => "required|min:3|max:50|unique:cajas,nombre,{$id}",
                'user_id' => 'required',
            ];
        }
    }

    public static $messages = [
        'nombre.required' => 'Nombre requerido',
        'nombre.min' => 'El nombre debe tener al menos 3 caracteres',
        'nombre.max' => 'El nombre debe tener máximo 50 caracteres',
        'nombre.unique' => 'La caja ya existe en sistema',
        'user_id.required' => 'Usuario requerido',

    ];



    public function  user ()
    {
        return $this->hasOne(User::class, 'id');
    }

}
