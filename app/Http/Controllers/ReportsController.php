<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Account;
use App\Transacction;
use Log;
use DB;
use Illuminate\Support\Facades\Cache;
use PDO;

class ReportsController extends Controller
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

    public function reports_between(Request $request)
    {
        $user_id = Cache::get('user_id');
        $account = Account::find($request->input('id_account'));

        $reports_income = Transacction::whereBetween('created_at', [$request->input('from'), $request->input('to')])
        ->where('user_id', $user_id)->where('id_account', $request->input('id_account'))->where('type', 'Expense')->sum('amount');

        $reports_expense = Transacction::whereBetween('created_at', [$request->input('from'), $request->input('to')])
        ->where('user_id', $user_id)->where('id_account', $request->input('id_account'))->where('type', 'Income')->sum('amount');

        return response()->json(['status'=>true, 'reports_income'=>$reports_income, 'reports_expense'=>$reports_expense, 'account'=>$account->small_name],200);

    }
}
