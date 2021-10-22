<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\User;

class UserController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    
    public function index($search = null) {
        
        // Buscar Usuarios
        
        if (!empty($search)) {
            
            $users = User::where('nick','LIKE', '%'.$search.'%')
                            -> orWhere('name','LIKE', '%'.$search.'%')
                            -> orWhere('surname','LIKE', '%'.$search.'%')
                            -> orderBy('id','desc')->paginate(5);

        }else {
            
            $users = User::orderBy('id','desc')->paginate(5);
        
        }
        
        return view('user.index',[
            'users' => $users
        ]);
    }

    public function config() {
        return view('user.config',);
    }

    public function update(Request $request) {
       
        // Conseguir el usuario identificado
        $user = \Auth::user();
        $id = $user->id;

        // Validar formulario:
        
        $validate = $this->validate($request,[
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'nick' => 'required|string|max:255|unique:users,nick,'.$id,
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
        ]);

        // Rellenar formulario con los datos del usuario

        $name    =  $request->input('name');
        $surname =  $request->input('surname');
        $nick    =  $request->input('nick');
        $email   =  $request->input('email');

        // Asignar nuevos valores al objeto usuario
        $user->name = $name;
        $user->surname = $surname;
        $user->nick = $nick;
        $user->email = $email;

        // Subir la imágen
        // Comprobamos si me llega o no la imágen
        $image_path = $request->file('image_path');
        
        if($image_path) {

            // Poner nombre unico con time, le concatenamos el nombre de la imágen y accedemos al nombre de la imágen
            $image_path_name = time().$image_path->getClientOriginalName();

            // Guardar en la carpeta storage (storage/app/users)
            Storage::disk('users')->put($image_path_name,File::get($image_path));   

            // Seteo el nombre de la imagen en el objeto
            $user->image = $image_path_name;
        }

        // Ejecutar consulta y cambios en la base de datos
        $user->update();

        return redirect()->route('config')->with(['message'=>'Sus datos se actualizaron correctamente.']);
    }

    public function getImage($filename) {

        $file = Storage::disk('users')->get($filename);
        
        return new Response($file,200);
    }

    public function profile($id) {
        // Obtengo el id del usuario que me llega por la url
        $user = User::find($id);

        return view('user.profile',[
            'user' => $user
        ]);
    }

}
