<?php

namespace App\Http\Controllers;

use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Account;
use App\User;

class TransactionController extends Controller {

    public $successStatus = 200;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return response()->json($this->successStatus);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {


        //le obtiene el id al usuario
        date_default_timezone_set("America/Bogota");
        $fechaHoy = date('Y-m-d h:i:s');


        $validator = Validator::make($request->all(), [
                    'tr_tipo' => 'required',
                    'tr_monto' => 'required',
                    'account_id' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $cuenta = Account::findOrFail($request->account_id);
        $usuario = Auth::user();

        $input = $request->all();

        if ($request->tr_tipo == 'Retiro') {
            if ($request->tr_monto > $cuenta->ac_balance) {
                return response()->json(['error' => "MONTO MAYOR"], 401);
            }
            $cuenta->ac_balance = $cuenta->ac_balance - $request->tr_monto;
        } else if ($request->tr_tipo == 'Consignacion') {
            if($cuenta->ac_balance>=100000){
                $cuenta->ac_state='Activa';
            }
            $cuenta->ac_balance = $cuenta->ac_balance + $request->tr_monto;
        }
        $input['tr_fecha_creacion'] = $fechaHoy;
        $input['user_id'] = $usuario->id;
        $input['tr_monto'] = $request->tr_monto;
        $input['tr_descripcion'] = "(".$request->tr_tipo.") Cuenta No. ".$cuenta->ac_number." Cajero ".$usuario->name." Codigo ". $usuario->id;
        $cuenta->save();
        $transaction = Transaction::create($input);
        return response()->json(['success' => $transaction], $this->successStatus);
    }

    public function getCuentasUser(Request $request) {
        $userId = User::select('id')->where('num_documento', '=', $request->num_documento)
                ->where('tipo_doc', '=', $request->tipo_doc)
                ->first();

        if(!isset($userId->id)){
           return response()->json(['error' => "Este cliente no existe"], 401);
        }else{
        $cuentas = Account::select('*')->where('user_id', '=', $userId->id)->get();
        }
        if(!isset($cuentas[0]->id)){
            return response()->json(['error' => "Este cliente no tiene cuentas creadas"], 401);
        }else{
            return response()->json(['data' => $cuentas], $this->successStatus);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction) {
        //
    }

}
