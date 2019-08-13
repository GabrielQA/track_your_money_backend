<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Category;
use App\Account;
use App\Coin;
use App\Transacction;
use Log;
use DB;
use DateTime;

class TransacctionController extends Controller
{

    public function list_transacction()
    {
        $user_id = Cache::get('user_id');
        $transacction = DB::select('select * from transacctions where user_id = ? ORDER BY created_at DESC', [$user_id]);
        return response()->json($transacction);

    }

    public function list_reports()
    {
        $user_id = Cache::get('user_id');
        $reports_income = DB::table('transacctions')->where('user_id', '=', $user_id)->where('type', '=', 'Income')->sum('amount');
        $reports_expense = DB::table('transacctions')->where('user_id', '=', $user_id)->where('type', '=', 'Expense')->sum('amount');
        //$reports_expense = abs($reports_expense);
        //$reports = DB::select('select * from transacctions where user_id = ?', [$user_id]);

        return response()->json(['status'=>true, 'reports_income'=>$reports_income, 'reports_expense'=>$reports_expense],200);

    }
    public function add_transacction(Request $request)
    {
        //return response()->json(['status'=>true, 'msg'=>'Se agrego la categoria correctamente','new'=>$balance], 200);
        try{

            $account = Account::find($request->input('id_account'));
            $category_type = Category::find($request->input('category'));

            if ($category_type->type === 'Expense') {
                $balance = $account->initial_amount - $request->input('amount');
                if($request->input('amount') > $account->initial_amount){
                    return response()->json(['status'=>false, 'msg'=>'El monto ingresado es mayor al de la cuenta'], 500);
                }
                $amount = '-'.$request->input('amount');
                Account::updateOrCreate(array('id' => $request->input('id_account')), array('initial_amount' =>  $balance));
            }else{
                $balance = $account->initial_amount + $request->input('amount');
                Account::updateOrCreate(array('id' => $request->input('id_account')), array('initial_amount' =>  $balance));
                $amount = $request->input('amount');
            }

            $user_id = Cache::get('user_id');

            $transacctions = new Transacction([
                            'user_id'=>$user_id,
                            'type'=>$category_type->type,
                            'acount'=>$account->small_name,
                            'id_account'=>$request->input('id_account'),
                            'category'=>$category_type->category,
                            'detail'=>$request->input('detail'),
                            'amount'=>$amount
                            ]);
            $transacctions->save();

            return response()->json(['status'=>true, 'msg'=>'Se realizo la transacction corectamente','new'=>$transacctions], 200);

    	} catch (\Exception $e){
    		return response('Someting bad', 500 );
    	}

    }

    public function update_transacction(Request $request)
    {

        try{
    		$expense_income = new Category([
                'user_id'=>$request->input('user_id'),
                'small_name'=>$request->input('small_name'),
                'symbol'=>$request->input('symbol'),
                'description'=>$request->input('description'),
                'rate'=>$request->input('rate'),
    			]);
    		$expense_income->save();
    		return response()->json(['status'=>true, 'msg'=>'Se actualizo la transacction correctamente','new'=>$expense_income], 200);
    	} catch (\Exception $e){
    		return response('Someting bad', 500 );
    	}


    }

    public function transfer(Request $request)
    {
        //return response()->json(['status'=>true, 'msg'=>'Se agrego la categoria correctamente','new'=>$balance], 200);
        //try{

            $account_debited = Account::find($request->input('account_debited'));
            $accredited_account = Account::find($request->input('accredited_account'));

            $debited_coin = Coin::find($account_debited->coin);
            $accredited_coin = Coin::find($accredited_account->coin);

            if ($request->input('account_debited') === $request->input('accredited_account')) {

                return response()->json(['status'=>false, 'msg'=>'Las cuentas deben ser diferentes'], 500);
            }

            if($request->input('amount') > $account_debited->initial_amount){
                return response()->json(['status'=>false, 'msg'=>'El monto ingresado es mayor al de la cuenta'], 500);
            }

            if($accredited_coin->small_name == 'CRC'){

                $accredited_balance = $accredited_account->initial_amount + ($request->input('amount') * $debited_coin->rate);
                $balance_debited = $account_debited->initial_amount - $request->input('amount');
                $amount = $request->input('amount') * $debited_coin->rate;

                Account::updateOrCreate(array('id' => $request->input('accredited_account')), array('initial_amount' =>  $accredited_balance));
                Account::updateOrCreate(array('id' => $request->input('account_debited')), array('initial_amount' =>  $balance_debited));
            }else{

                $accredited_balance = $accredited_account->initial_amount + ($request->input('amount') / $accredited_coin->rate);
                $balance_debited =  $account_debited->initial_amount - $request->input('amount');
                $amount = $request->input('amount') / $accredited_coin->rate;

                Account::updateOrCreate(array('id' => $request->input('accredited_account')), array('initial_amount' =>  $accredited_balance));
                Account::updateOrCreate(array('id' => $request->input('account_debited')), array('initial_amount' =>  $balance_debited));
            }


            $user_id = Cache::get('user_id');

            $acredited_transfer = new Transacction([
                            'user_id'=>$user_id,
                            'type'=>'Income',
                            'acount'=>$accredited_account->small_name,
                            'category'=>$request->input('category'),
                            'detail'=>$request->input('detail'),
                            'amount'=>$amount,
                            ]);
            $acredited_transfer->save();

            $debited_transfer = new Transacction([
                'user_id'=>$user_id,
                'type'=>'Expense',
                'acount'=>$account_debited->small_name,
                'category'=>$request->input('category'),
                'detail'=>$request->input('detail'),
                'amount'=>'-'.$request->input('amount'),
                ]);
            $debited_transfer->save();

            return response()->json(['status'=>true, 'msg'=>'Se realizo la transacction corectamente',
            'new_at'=>$acredited_transfer, 'new_dt'=>$debited_transfer ], 200);

    	/*} catch (\Exception $e){
    		return response('Someting bad', 500 );
    	}*/

    }
    public function delete_transacction($id){

        DB::table('transacctions')->where('id', $id)->delete();
        return response()->json(['status'=>true, 'msg'=>'Se elimino la cuenta correctamente'], 200);
    }
}
