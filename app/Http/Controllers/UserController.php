<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;

class UserController extends Controller {

    public $successStatus = 200;

    /**
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function login() {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('MyApp')->accessToken;
            $success['rol'] = $user->rol;
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }
    
    public function index() {
        $usuarios = User::all();
        return response()->json(['data'=>$usuarios],200);
    }
    
    public function show($id) {
        $usuario = User::find($id);
        return response()->json(['data'=>$usuario],200);
    }
    public function update(Request $request ,$id) {
        $usuario = User::findOrFail($id);
        
       
        if($request->has('name')){
            $usuario->name = $request->name ;
        }
        if($request->has('apellido')){
            $usuario->apellido = $request->apellido ;
        }
        if($request->has('direccion')){
            $usuario->direccion = $request->direccion ;
        }
        if($request->has('email')){
            $usuario->email = $request->email ;
        }
        if($request->has('password')){
            $usuario->password = bcrypt($request->password);
        }
        if($request->has('tipo_doc')){
            $usuario->tipo_doc = $request->tipo_doc ;
        }
        if($request->has('num_documento')){
            $usuario->num_documento = $request->num_documento ;
        }
        
        $usuario->save();
        
        return response()->json(['data'=>$usuario],200);
    }

    /**
     * Register api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
                    'name' => 'required',
                    'email' => 'required|email',
                    'password' => 'required',
                    'c_password' => 'required|same:password',
                    'tipo_doc' => 'required',
                    'num_documento' => 'required',
                    'direccion' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken('MyApp')->accessToken;
        $success['name'] = $user->name;
        return response()->json(['success' => $success], $this->successStatus);
    }

    /**
     * details api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function details() {
        $user = Auth::user();
        return response()->json(['success' => $user], $this->successStatus);
    }
    
    public function logout(Request $request) {
        $request->user()->token()->revoke();
        return response()->json(['message' => 
            'Successfully logged out']);
    }

}
