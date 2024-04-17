<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pp extends Model
{
    use HasFactory;
    protected $fillable = ['descripcion'];

    public static function rules($id)
    {
        if ($id <= 0) {
            return [
                'descripcion' => 'required|min:3|max:50|unique:pps'
            ];
        } else {
            return [
                'descripcion' => "required|min:3|max:50|unique:pps,descripcion,{$id}"
            ];
        }
    }

    public static $messages = [
        'descripcion.required' => 'descripcion requerido',
        'descripcion.min' => 'El descripcion debe tener al menos 3 caracteres',
        'descripcion.max' => 'El descripcion debe tener máximo 50 caracteres',
        'descripcion.unique' => 'El plato principal ya existe en sistema'
    ];

    // relationships
    public function image()
    {
        //Este patrón a menudo se denomina patrón de objeto nulo y puede ayudar a eliminar las comprobaciones condicionales en su código.
        return  $this->morphOne(Image::class, 'model')->withDefault();
    }
     // accessors && mutators
     public function getImgAttribute()
     {
         $img = $this->image->file;

         if ($img != null) {
             if (file_exists('storage/pps/' . $img))
                 return 'storage/pps/' . $img;
             else
             return "storage/image-not-found.png";  // si el producto tiene imagen pero fisiscamente no se encuentra
         }

         return 'storage/noimg.png'; // si el producto no  tiene imagen relacionada
     }

}