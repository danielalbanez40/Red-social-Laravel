<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    // Le indicamos que tabla se va a modificar en la base de datos
    protected $table = 'images';

    // Relacion one to many o uno a muchos con los comentarios, para sacar todos los comentarios de una imagen
    public function comments() {
        
        return $this->hasMany('App\Comment')->orderBy('id','desc');
    }
    
    // Relacion one to many o uno a muchos con los likes, para sacar todos los likes de una imagen
    public function likes() {
        return $this->hasMany('App\Like');
    }

    // Relacion many to one o muchos a uno ya que un usuario puede crear muchas imágenes
    public function user() {
        return $this->belongsTo('App\User','user_id');
    }

}
