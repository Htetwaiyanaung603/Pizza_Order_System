<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Pizza;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //direct user page
    public function index() {
        $pizzaData = Pizza::where('publish_status', 0)->paginate(9);
        $categoryData = Category::get();
        
        return view('user.home')->with(['pizza' => $pizzaData, 'category' => $categoryData, 'status' => count($pizzaData) == 0 ? 0 : 1]);
    }
    
    //details page
    public function details($id) {
        $data = Pizza::where('pizza_id', $id)->first();
        Session::put('PIZZA_INFO',  $data);
        return view('user.details')->with(['pizza' => $data]);
    }

    //category items
    public function category($id) {
        $data = Pizza::where('category_id', $id)->get();
        $cData = Category::get();
         return view('user.home')->with(['pizza' => $data, 'category' => $cData,'status' => count($data) == 0 ? 0 : 1]);
    }

    //search item pizza
    public function searchItem(Request $request) {
        $pizzaData = Pizza::where('pizza_name','like','%'.$request->searchData.'%')->paginate(9);
        
        $categoryData = Category::get();

        $pizzaData->appends($request->all());

        

        return view('user.home')->with(['pizza' => $pizzaData, 'category' => $categoryData,'status' => count($pizzaData) == 0 ? 0 : 1 ]);
    }

    //search price
    public function searchPrice (Request $request) {
        $startDate = $request->startDate ;
        $endDate = $request->endDate ;
        $min = $request->minPrice ;
        $max = $request->maxPrice ;
        
        $query = Pizza::select("*");
        
        //check date
        if(!is_null($startDate) && is_null($endDate)){

            $query = $query->whereDate('created_at', '>=', $startDate);
        }else if(is_null($startDate) && !is_null($endDate))
        {
            $query = $query->whereDate('created_at', '<=', $endDate);
        }else if(!is_null($startDate) && !is_null($endDate)){   
            $query = $query->whereDate('created_at', '>=', $startDate)
                           ->whereDate('created_at', '<=', $endDate);
        }

        //check min and max price
        if(!is_null($min) && is_null($max)){
            $query = $query->where('price','>=',$min);
        }else if(is_null($min) && !is_null($max)){
            $query = $query->where('price','<=',$max);
        }else if(!is_null($min) && !is_null($max)){
            $query = $query->where('price','>=',$min)
                           ->where('price','<=',$max);
        }
        $query = $query->paginate(9);
        $query->appends($request->all());
        $categoryData = Category::get();
        return view('user.home')->with(['pizza' => $query, 'category' => $categoryData,'status' => count($query) == 0 ? 0 : 1 ]);
    
    }

    //order pizza
    public function orderPizza(){
        $pizzaInfo = Session::get('PIZZA_INFO');
        // dd($pizzaInfo->toArray());
        return view('user.order')->with(['pizza' => $pizzaInfo]);
    }

    //place Order
    public function placeOrder (Request $request) {
         // validation
         $validator = Validator::make($request->all(), [
            'countPizza' => 'required',
            'paymentType' => 'required',
        ]);
 
        if ($validator->fails()) {
            return back()
                    ->withErrors($validator)
                    ->withInput();
        }
        //end validation
        $countPizza = $request->countPizza;
        $pizzaInfo = Session::get('PIZZA_INFO'); 
        $pizzaData = $this->requestOrderData($request);
        
        for($i=0; $i<$countPizza; $i++){
            Order::create($pizzaData);
        }
        $waitingTime = $pizzaInfo['waiting_time'] * $countPizza ;
        
        return back()->with(['time' => $waitingTime]);
    }

    private function requestOrderData($request) {
        $pizzaInfo = Session::get('PIZZA_INFO');
        return [
            'customer_id' => auth()->user()->id ,
            'pizza_id' => $pizzaInfo['pizza_id'] ,
            'carrier_id' => 0 ,
            'payment_status' => $request->paymentType ,
            'order_time' => Carbon::now() ,
        ];
    }
}
