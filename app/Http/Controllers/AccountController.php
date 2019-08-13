<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Account;
use Log;
use DB;
use Illuminate\Support\Facades\Cache;
use PDO;
class AccountController extends Controller
{
    public function __construct()
    {


    }
    public function list_account()
    {
        $user_id = Cache::get('user_id');
        $account = DB::select('select * from accounts where user_id = ? and available = ?  ORDER BY created_at DESC', [$user_id, 1]);
        return response()->json($account);

    }

    public function add_account(Request $request)
    {
        $user_id = Cache::get('user_id');
        try{

            $accounts = Account::updateOrCreate(
            array('user_id'=>$user_id, 'small_name' => $request->input('small_name'), 'coin' => $request->input('coin'), 'available' => 0),
            array( 'user_id'=>$user_id,
            'coin'=>$request->input('coin'),
            'small_name'=>$request->input('small_name'),
            'description'=>$request->input('description'),
            'initial_amount'=>$request->input('initial_amount'),
            'available'=> 1));

    		return response()->json(['status'=>true, 'msg'=>'Se agrego la cuenta correctamente','new'=>$accounts], 200);
    	} catch (\Exception $e){
    		Log::critical("No se ha podido añadir: {$e->getCode()} , {$e->getLine()} , {$e->getMessage()}");
    		return response('Someting bad', 500 );
    	}

    }
    public function  edit_account($id){

        $user_id = Cache::get('user_id');
        $account = DB::select('select * from accounts where user_id = ? and id = ?', [$user_id, $id]);
        return response()->json($account);
    }

    public function update_account($id, Request $request)
    {
        $user_id = Cache::get('user_id');
        //dd($request);
        DB::table('accounts')
            ->where('id', $id)
            ->update([
            'coin' => $request->coin,
            'small_name' => $request->small_name,
            'description' => $request->description,
            'initial_amount' => $request->initial_amount]);

        return response()->json(['status'=>true, 'msg'=>'Se actualizo la cuenta correctamente'], 200);
    }
    public function delete_account($id){

        Account::updateOrCreate(array('id' => $id), array('available' => false));

        return response()->json(['status'=>true, 'msg'=>'Se elimino la cuenta correctamente'], 200);
    }


}
