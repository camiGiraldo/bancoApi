<?php

namespace App\Http\Controllers;

use App\Transaction;
use Illuminate\Http\Request;
use Validator;
use App\Account;

class TransactionController extends Controller
{
    public $successStatus = 200;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json($this->successStatus);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     
    public function create()
    {
        //
    }*/

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        
        date_default_timezone_set("America/Bogota");
        $fechaHoy = date('Y-m-d h:i:s');
        
        
        $validator = Validator::make($request->all(), [
                    'tr_tipo' => 'required',
                    'tr_monto' => 'required',
                    'tr_fecha_creacion' => 'tr_fecha_creacion',
                    'tr_descripcion' => 'required',
                    'user_id' => 'required',
                    'account_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $cuenta=Account::findOrFail($request->account_id);
       
        $input = $request->all();
        
        if($request->tr_tipo=='Retiro'){
            
            if($request->tr_monto > $cuenta->ac_balance){
                return response()->json(['error' => "MONTO MAYOR"], 401);
            }
            $cuenta->ac_balance= $cuenta->ac_balance - $request->tr_monto;
            $cuenta->save();
        } else if($request->tr_tipo=='Consignacion'){
            $cuenta->ac_balance= $cuenta->ac_balance + $request->tr_monto;
            $cuenta->save();
        }
        
        $input['tr_fecha_creacion']=$fechaHoy;
        
        $transaction = Transaction::create($input);
        return response()->json(['success' => $transaction], $this->successStatus);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        //
    }

   
  
}
