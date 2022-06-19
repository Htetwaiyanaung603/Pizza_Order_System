<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Pizza;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class PizzaController extends Controller
{
    //direct pizza page
    public function pizza() {
        if(Session::has('PIZZA_SEARCH')){
            Session::forget('PIZZA_SEARCH');
        }
        $data = Pizza::paginate(5);

        // if(count($data) == 0 ){
        //     $emptyStatus = 0;
        // }else{
        //     $emptyStatus = 1;
        // }

        return view('admin.Pizza.list')->with(['pizza' => $data, 'status' => count($data) == 0 ? 0 : 1 ]);
    }

    //add Pizza page
    public function addPizza() {
        $data = Category::get();
        return view('admin.Pizza.addPizza')->with(['category' => $data]);
    }

    //create pizza
    public function createPizza (Request $request) {

       
        // validation
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'image' => 'required',
            'price' => 'required',
            'publish' => 'required',
            'category' => 'required',
            'discount' => 'required',
            'buyOnegetOne' => 'required',
            'waitingTime' => 'required',
            'description' => 'required',
        ]);
 
        if ($validator->fails()) {
            return back()
                    ->withErrors($validator)
                    ->withInput();
        }
        //end validation

        //image file upload
        $file = $request->file('image');
        // $fileName =uniqid().'_myFavorite'.$file->getClientOriginalName();
        $fileName = uniqid().'_'.$file->getClientOriginalName();
        $file->move(public_path().'/images/',$fileName);
        //end image file upload


        $data = $this->getPizzaData($request, $fileName);
        
        Pizza::create($data);
        return redirect()->route('admin#pizza')->with(['success' => 'Pizza Added...']);
    }

    //delete pizza
    public function deletePizza ($id) {
        $photo = Pizza::select('image')->where('pizza_id', $id)->first();
        $fileName = $photo['image'];
        Pizza::where('pizza_id', $id)->delete(); //photo in db delete

        //photo in project delete
        if(File::exists(public_path().'/images/'.$fileName)){
             File::delete(public_path().'/images/'.$fileName);  
        }
            
        
        
        return back()->with(['success' => 'Pizza Deleted...']);
    }

    //edit pizza
    public function editPizza ($id) {
        $category = Category::get();
        $data = Pizza::select('pizzas.*','category_name')
                    ->join('categories','pizzas.category_id','categories.category_id')
                    ->where('pizza_id', $id)
                    ->first();
        
        return view('admin.Pizza.editPizza')->with(['pizza' => $data, 'category' => $category]);
    }

    //update pizza
    public function updatePizza($id,Request $request){
          // validation
        $validator = Validator::make($request->all(), [
            'name' => 'required',
           
            'price' => 'required',
            'publish' => 'required',
            'category' => 'required',
            'discount' => 'required',
            'buyOnegetOne' => 'required',
            'waitingTime' => 'required',
            'description' => 'required',
        ]);
 
        if ($validator->fails()) {
            return back()
                    ->withErrors($validator)
                    ->withInput();
        }
        //end validation

        $updateData = $this->updatePizzaData($request);
        
        if(isset($updateData['image'])){
            //get old photo name
            $odata = Pizza::select('image')->where('pizza_id', $id)->first();
            $ofileName = $odata['image'];
            
            //delete old photo in project
            if(File::exists(public_path().'/images/'.$ofileName)){
                File::delete(public_path().'/images/'.$ofileName);
            }
            
            //add new photo in project
            $nfile = $request->file('image');
            $nfileName = uniqid().'_'.$nfile->getClientOriginalName();
            $nfile->move(public_path().'/images/', $nfileName);
            
            $updateData['image'] = $nfileName;
        }

        Pizza::where('pizza_id', $id)->update($updateData);

        return redirect()->route('admin#pizza')->with(['success' => 'Update Successfully...']);
        
    }

    //pizza infomation
    public function infoPizza ($id) {
        $data = Pizza::where('pizza_id', $id)->first();
        return view('admin.Pizza.infoPizza')->with(['pizza' => $data]);
    }

    //update pizza data function
    private function updatePizzaData ($request) {
        $arr = [
            'pizza_name' => $request->name , 
            
            'price' => $request->price , 
            'publish_status' => $request->publish ,
            'category_id' => $request->category , 
            'discount_price' => $request->discount , 
            'buy_one_get_one_status' => $request->buyOnegetOne , 
            'waiting_time' => $request->waitingTime ,
            'description' => $request->description , 
            'created_at' => Carbon::now() ,
            'updated_at' => Carbon::now() ,
        ];

        if(isset($request->image)){
            $arr['image'] = $request->image ; 
        }

        return $arr;
        
    }

    //SEARCH PIZZA
    Public function searchPizza (Request $request) {
        $searchKey = $request->table_search;
        $data = Pizza::orWhere('pizza_name','like','%'.$searchKey.'%')
                        ->orWhere('price', $searchKey)
                        ->paginate(5);
        Session::put('PIZZA_SEARCH', $searchKey);
        $data->appends($request->all());
        return view('admin.Pizza.list')->with(['pizza' => $data, 'status' => count($data) == 0 ? 0 : 1]);
    }

    //pizza download
    public function pizzaDownload() {
        if(Session::has('PIZZA_SEARCH')){
            $searchKey = Session::get('PIZZA_SEARCH');
            $data = Pizza::orWhere('pizza_name','like','%'.$searchKey.'%')
                        ->orWhere('price', $searchKey)
                        ->get();
        }else{
            $data = Pizza::get();
            
        }
        // $data = Category::get();

        

        $csvExporter = new \Laracsv\Export();

        // $csvExporter->beforeEach(function ($user) {
        //     $user->created_at = $user->created_at->format('Y-m-d');
        // });

        $csvExporter->build($data, [
            'pizza_id' => 'ID',
            'pizza_name' => 'Name',
            'price' => 'Price',
            'publish_status' => 'Publish Status',
            'buy_one_get_one_status' => 'Buy One Get One',
        ]);

        $csvReader = $csvExporter->getReader();

        $csvReader->setOutputBOM(\League\Csv\Reader::BOM_UTF8);

        $filename = 'pizzaList.csv';

        return response((string) $csvReader)
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="'.$filename.'"');
    }

    //get pizza data function
    private function getPizzaData ($request, $fileName) {
        $data = [
            'pizza_name' => $request->name , 
            'image' => $fileName ,
            'price' => $request->price , 
            'publish_status' => $request->publish ,
            'category_id' => $request->category , 
            'discount_price' => $request->discount , 
            'buy_one_get_one_status' => $request->buyOnegetOne , 
            'waiting_time' => $request->waitingTime ,
            'description' => $request->description , 
            'created_at' => Carbon::now() ,
            'updated_at' => Carbon::now() ,
        ];
        return $data;
    }
}
