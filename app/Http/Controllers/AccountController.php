<?php

namespace App\Http\Controllers;

use App\Account;
use Illuminate\Http\Request;
use Validator;

class AccountController extends Controller
{
    public $successStatus = 200;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cuentas = Account::all();
        return response()->json(['data'=>$cuentas],200);
    }

    public function getAccountsByIdUser(Request $request){
        $cuentas= Account::select('*')->where('user_id','=',$request->user_id)->get();
        return response()->json(['data'=>$cuentas],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        date_default_timezone_set("America/Bogota");
        $fechaHoy = date('d-m-Y h:i:s A');
        $numberAccount = strtotime($fechaHoy);
        
        
        $validator = Validator::make($request->all(), [
                    'ac_password' => 'required',
                    'user_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        
        $input = $request->all();
        $input['ac_balance']=0;
        $input['ac_number']=$numberAccount;
        
        $account = Account::create($input);
        
        return response()->json(['success' => $account], $this->successStatus);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cuenta = Account::find($id);
        return response()->json(['data'=>$cuenta],200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $cuenta = Account::findOrFail($id);
        
       
        
        if($request->has('ac_password')){
            $cuenta->ac_password = $request->ac_password ;
        }
        
        if($request->has('ac_state')){
            $cuenta->ac_state = $request->ac_state ;
        }
                
        $cuenta->save();
        
        return response()->json(['data'=>$cuenta],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function destroy(Account $account)
    {
        //
    }
}
