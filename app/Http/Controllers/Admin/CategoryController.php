<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Pizza;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    

    //direct category page
    public function category() {
        if(Session::has('CATEGORY_SEARCH')){
            Session::forget('CATEGORY_SEARCH');
        }
        $data = Category::select('categories.*',DB::raw('COUNT(pizzas.category_id) as count'))
                        ->leftJoin('pizzas','pizzas.category_id','categories.category_id')
                        ->groupBy('categories.category_id')
                        ->paginate(5);
        
        return view('admin.Category.list')->with(['category' => $data]);
    }

    //add category page
    public function addCategory() {
        return view('admin.Category.addCategory');
    }

    //create categoyr page
    public function createCategory (Request $request) {

        // validation
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
 
        if ($validator->fails()) {
            return back()
                    ->withErrors($validator)
                    ->withInput();
        }
        //end validation

        $data = [
            'category_name' => $request->name ,
        ];
        Category::create($data);
        return redirect()->route('admin#category')->with(['success' => 'Category Added...']);
    }

    //edit category page
    public function editCategory ($id) {
        $data = Category::where('category_id', $id)->first();
        return view('admin.Category.editCategory')->with(['category' => $data]);
    }

    //update Category
    public function updateCategory (Request $request) {
        // validation
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
 
        if ($validator->fails()) {
            return back()
                    ->withErrors($validator)
                    ->withInput();
        }
        //end validation

        $data = [
            'category_name' => $request->name ,
        ];

        Category::where('category_id', $request->id)->update($data);

        return redirect()->route('admin#category')->with(['success' => 'Category Updated...']);
    }

    //delete category
    public function deleteCategory ($id) {
        Category::where('category_id', $id)->delete();
        return back()->with(['success' => 'Category Deleted...']);
    }

    //search category
    public function searchCategory (Request $request) {
        $data = Category::select('categories.*',DB::raw('COUNT(pizzas.category_id) as count'))
                        ->leftJoin('pizzas','pizzas.category_id','categories.category_id')
                        ->groupBy('categories.category_id')
                        ->where('category_name','like','%'.$request->searchData.'%')
                        ->paginate(5);
        Session::put('CATEGORY_SEARCH', $request->searchData);
        // Session::put('CATEGORY_SEARCH', $data->toArray()['data']);
        // dd($data->toArray()['data']);
        // $ha = count($data->items());
        // $ho =[];
        // for($i=0; $i < $ha; $i++){
        //     array_push($ho, $data->items()[$i]->getOriginal());
        // }
        // Session::put('CATEGORY_SEARCH', $ho);
        // Session::put('CATEGORY_SEARCH', $data);
        $data->appends($request->all());
        return view('admin.Category.list')->with(['category' => $data]);
    }

    //category item
    public function categoryItem ($id) {
        $data = Pizza::select('pizzas.*', 'categories.category_name as categoryName')
                        ->join('categories','pizzas.category_id','categories.category_id')
                        ->where('categories.category_id', $id)
                        ->paginate(5);      
        return view('admin.Category.item')->with(['pizza' => $data ]);
    }

    //category download csv
    public function categoryDownload() {
        if(Session::has('CATEGORY_SEARCH')){
            $data = Category::select('categories.*',DB::raw('COUNT(pizzas.category_id) as count'))
                        ->leftJoin('pizzas','pizzas.category_id','categories.category_id')
                        ->groupBy('categories.category_id')
                        ->where('category_name','like','%'.Session::get('CATEGORY_SEARCH').'%')
                        ->get(f);
        }else{
            $data = Category::select('categories.*',DB::raw('COUNT(pizzas.category_id) as count'))
                        ->leftJoin('pizzas','pizzas.category_id','categories.category_id')
                        ->groupBy('categories.category_id')
                        ->get();
            
        }
        // $data = Category::get();

        

        $csvExporter = new \Laracsv\Export();

        // $csvExporter->beforeEach(function ($user) {
        //     $user->created_at = $user->created_at->format('Y-m-d');
        // });

        $csvExporter->build($data, [
            'category_id' => 'ID',
            'category_name' => 'Name',
            'count' => 'Pizza Count',
            'created_at' => 'Created_Date',
            'updated_at' => 'Updated_Date', 
        ]);

        $csvReader = $csvExporter->getReader();

        $csvReader->setOutputBOM(\League\Csv\Reader::BOM_UTF8);

        $filename = 'categoryList.csv';

        return response((string) $csvReader)
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="'.$filename.'"');
    }
}
