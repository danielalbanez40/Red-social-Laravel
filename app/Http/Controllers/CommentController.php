<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;

class CommentController extends Controller
{
    public function __construct() {

        $this->middleware('auth');

    }

    public function save(Request $request) {
      
        // Validación
        $validate = $this->validate($request, [
    
            'image_id' => 'integer|required',
            'content'  => 'string |required'
    
        ]);
        
        // Obtenemos datos del formulario
        $user_id = \Auth::user();
        $image_id   = $request->input('image_id');
        $content    = $request->input('content');
        
        // Asigno valores a mi nuevo objeto a guardar
        $comment = new Comment();
        $comment->user_id = $user_id->id;
        $comment->image_id = $image_id;
        $comment->content = $content;

        //Guardo en la BD 
        $comment->save();
       
        
        // Redirección
        return redirect()->route('image.detail',['id'=>$image_id])->with(['message'=>'Has publicado tu comentario correctamente']);

    }

    public function delete($id) {
    
        // Conseguir datos del usuario identificado
        $user = \Auth::user();
    
        // Conseguir objeto del comentario
        $comment = Comment::find($id);
        
        // Comprobar si soy el dueño del comentario o de la publicación
        if ($user && ($comment->user_id == $user->id || $comment->image->user_id == $user->id)) {
            
            $comment->delete();

            return redirect()->route('image.detail',['id'=>$comment->image->id])->with(['message'=>'Comentario eliminado correctamente!!']);
            
        }else {
            
            return redirect()->route('image.detail',['id'=>$comment->image->id])->with(['message'=>'Ha ocurido un error! el comentario no ha podido ser eliminado.']);

        }
    
    }
}

