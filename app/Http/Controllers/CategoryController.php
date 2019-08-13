<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Category;
use App\Account;
use Log;
use DB;


class CategoryController extends Controller
{
    public function list_category()
    {
        $user_id = Cache::get('user_id');
        $category = DB::select('select * from categories where user_id = ? and available = ?  ORDER BY created_at DESC', [$user_id, 1]);
        return response()->json($category);

    }
    public function edit_category($id)
    {
        $user_id = Cache::get('user_id');
        $category = DB::select('select * from categories where user_id = ? and id = ?', [$user_id, $id]);
        return response()->json($category);

    }

    public function add_category(Request $request)
    {
        //return response()->json(['status'=>true, 'msg'=>'Se agrego la categoria correctamente','new'=>$balance], 200);
        try{
        if($request->father_cat="null"){
        $request->father_cat=0;
        }
        

            $user_id = Cache::get('user_id');


            $verify_category = DB::select('select * from categories where user_id = ? and id = ? and type = ?',
            [$user_id,$request->input('father_cat'), $request->input('type')]);


            if (!$verify_category && $request->input('father_cat')!== 'N/A') {
                return response()->json(['status'=>true, 'msg'=>'El tipo de la categoria padre debe ser igual a la nueva categoria'], 500);
            }

            $verify_category2 = DB::select('select * from categories where user_id = ? and father_cat = ? and category = ? and type = ? and available = ?',
            [$user_id, $request->input('father_cat'), $request->input('category'), $request->input('type'), 1]);

            if ($verify_category2) {
               return response()->json(['status'=>true, 'msg'=>'La categoria ya existe'], 500);
            }

            $category = Category::updateOrCreate(
                array('user_id'=>$user_id, 'father_cat' => $request->input('father_cat'),
                'category' => $request->input('category'),
                'type' => $request->input('type'),
                'available' => 0),
                array( 'user_id'=>$user_id,
                'father_cat'=>$request->input('father_cat'),
                'category'=>$request->input('category'),
                'type'=>$request->input('type'),
                'description'=>$request->input('description'),
                'available'=> 1));

            return response()->json(['status'=>true, 'msg'=>'Se actualizo la categoria correctamente','new'=>$category], 200);

    	} catch (\Exception $e){
    		return response('Someting bad', 500 );
    	}

    }

    public function update_category($id,Request $request)
    {
        //dd($request);
        DB::table('categories')
        ->where('id', $id)
        ->update([
        'father_cat' => $request->father_cat,
        'category' => $request->category,
        'type' => $request->type,
        'description' => $request->description]);
        return response()->json(['status'=>true, 'msg'=>'Se actualizo la cuenta correctamente'], 200);

    }
    public function delete_category($id){

        Category::updateOrCreate(array('id' => $id), array('available' => false));

        return response()->json(['status'=>true, 'msg'=>'Se elimino la cuenta correctamente'], 200);
    }
}
