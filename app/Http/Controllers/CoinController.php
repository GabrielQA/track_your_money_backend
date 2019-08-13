<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Coin;
use Log;
use DB;
use Illuminate\Support\Facades\Cache;
use PDO;

class CoinController extends Controller
{
     /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {


    }

    public function list_coin()
    {
        $user_id = Cache::get('user_id');
        $coin = DB::select('select * from coins  where user_id = ? and available = ?  ORDER BY created_at DESC', [$user_id, 1]);
        return response()->json($coin);

    }

    public function edit_coin($id)
    {
        $user_id = Cache::get('user_id');
        $coin = DB::select('select * from coins  where user_id = ? and id = ? ', [$user_id, $id]);
        return response()->json($coin);

    }

    public function add_coin(Request $request)
    {
        if ($request->input('small_name')=== 'CRC') {
            $symbol = '₡';
        }elseif ($request->input('small_name')=== 'GBP') {
            $symbol = '£';
        } elseif ($request->input('small_name')=== 'JPY') {
            $symbol = '¥';
        } elseif ($request->input('small_name')=== 'CNY') {
            $symbol = '¥';
        } elseif ($request->input('small_name')=== 'EUR') {
            $symbol = '€';
        } elseif ($request->input('small_name')=== 'USD') {
            $symbol = '$';
        } elseif ($request->input('small_name')=== 'NOK') {
            $symbol = 'Kr';
        }elseif ($request->input('small_name')=== 'CHF') {
            $symbol = 'Fr';
        }else {
            $symbol = '₩';
        }

        $user_id = Cache::get('user_id');

        try{
    		$coins = new Coin([
                'user_id'=>$user_id,
                'small_name'=>$request->input('small_name'),
                'symbol'=>$symbol,
                'description'=>$request->input('description'),
                'rate'=>$request->input('rate')
    			]);
    		$coins->save();
    		return response()->json(['status'=>true, 'msg'=>'Se agrego la moneda correctamente','new'=>$coins], 200);
    	} catch (\Exception $e){
    		Log::critical("No se ha podido añadir: {$e->getCode()} , {$e->getLine()} , {$e->getMessage()}");
    		return response('Someting bad', 500 );
    	}


    }

    public function update_coin($id,Request $request)
    {
        if ($request->input('small_name')=== 'CRC') {
            $symbol = '₡';
        }elseif ($request->input('small_name')=== 'GBP') {
            $symbol = '£';
        } elseif ($request->input('small_name')=== 'JPY') {
            $symbol = '¥';
        } elseif ($request->input('small_name')=== 'CNY') {
            $symbol = '¥';
        } elseif ($request->input('small_name')=== 'EUR') {
            $symbol = '€';
        } elseif ($request->input('small_name')=== 'USD') {
            $symbol = '$';
        } elseif ($request->input('small_name')=== 'NOK') {
            $symbol = 'Kr';
        }elseif ($request->input('small_name')=== 'CHF') {
            $symbol = 'Fr';
        }else {
            $symbol = '₩';
        }
        DB::table('coins')
            ->where('id', $id)
            ->update([
            'small_name' => $request->small_name,
            'symbol' => $symbol,
            'description' => $request->description,
            'rate' => $request->rate]);

            return response()->json(['status'=>true, 'msg'=>'Se actualizo la moneda correctamente'], 200);
    }

    public function delete_coin($id){

        Coin::updateOrCreate(array('id' => $id), array('available' => false));

        return response()->json(['status'=>true, 'msg'=>'Se elimino la moneda correctamente'], 200);
    }

}
