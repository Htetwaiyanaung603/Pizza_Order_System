<?php

namespace App\Http\Controllers\API;

use Response;
use Carbon\Carbon;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use Illuminate\Support\Facades\Response;

class ApiController extends Controller
{
    //category list
    public function categoryList() {
        
        $category = Category::get();
        $response = [
            'status' => 200,
            'message' => 'success',
            'data' => $category,
        ];
        return Response::json($response);
    }

    //category create
    public function categoryCreate(Request $request) {
        $data = [
            'category_name' => $request->name , 
            'created_at' => Carbon::now() ,
            'updated_at' => Carbon::now() ,
        ];

        Category::create($data);

        return Response::json([
            'status' => 200, 
            'message' => 'Success',
        ]);
    }

    //details category
    public function categoryDetails($id) {
        

        $data = Category::where('category_id', $id)->first();

        if(!empty($data)){
            return Response::json([
                'status' => 200 , 
                'message' => 'Success' ,
                'data' => $data ,
            ]);
        }else {
            return Response::json([
                'status' => 200 ,
                'message' => 'Fail' ,
                'data' => $data , 
            ]);
        }
    }

    //delete category
    public function categoryDelete($id) {

        
        $data = Category::where('category_id', $id)->first();

        if(empty($data)){
            return Response::json([
                'status' => 200 , 
                'message' => 'There is no data for delete' ,
            ]);
        }

        Category::where('category_id', $id)->delete();
        
        return Response::json([
            'status' => 200 , 
            'message' => 'Delete Success' ,
        ]);
    }

    //update category
    public function categoryUpdate(Request $request) {
        $updateData = [
            'category_id' => $request->id ,
            'category_name' => $request->name ,
        ];

        $checkData = Category::where('category_id' , $request->id)->first();

        if(!empty($checkData)){
            Category::where('category_id', $request->id)->update($updateData);

            return Response::json([
                'status' => 200 ,
                'message' => 'success update' ,
            ]);
        }

        return Response::json([
            'status' => 200 ,
            'message' => 'There is no data for update' ,
        ]);
    }
}
