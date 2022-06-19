<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    //order list
    public function orderList() {
        if(Session::has('ORDER_SEARCH')){
            Session::forget('ORDER_SEARCH');
        }
        $data = Order::select('orders.*','users.name as customer_name','pizzas.pizza_name',DB::raw('COUNT(orders.pizza_id) as count'))
                    ->join('users', 'users.id', 'orders.customer_id')
                    ->join('pizzas', 'pizzas.pizza_id', 'orders.pizza_id')
                    ->groupBy('orders.customer_id', 'orders.pizza_id')
                    ->orderBy('orders.order_id', 'asc')
                    ->paginate(5);
        
        return view('admin.order.list')->with(['order' => $data ]);
    }

    //order Search
    public function orderSearch(Request $request){
        $data = Order::select('orders.*','users.name as customer_name','pizzas.pizza_name',DB::raw('COUNT(orders.pizza_id) as count'))
                    ->join('users', 'users.id', 'orders.customer_id')
                    ->join('pizzas', 'pizzas.pizza_id', 'orders.pizza_id')
                    ->orWhere('users.name','like','%'.$request->searchData.'%')
                    ->orWhere('pizzas.pizza_name','like','%'.$request->searchData.'%')
                    ->groupBy('orders.customer_id', 'orders.pizza_id')
                    ->paginate(5);
        Session::put('ORDER_SEARCH', $request->searchData);
        $data->appends($request->all());
        return view('admin.order.list')->with(['order' => $data ]);
    }

    //order download csv
    public function orderDownload() {
        if(Session::has('ORDER_SEARCH')){
            $searchKey = Session::get('ORDER_SEARCH');
            $data = Order::select('orders.*','users.name as customer_name','pizzas.pizza_name',DB::raw('COUNT(orders.pizza_id) as count'))
                        ->join('users', 'users.id', 'orders.customer_id')
                        ->join('pizzas', 'pizzas.pizza_id', 'orders.pizza_id')
                        ->orWhere('users.name','like','%'.$searchKey.'%')
                        ->orWhere('pizzas.pizza_name','like','%'.$searchKey.'%')
                        ->groupBy('orders.customer_id', 'orders.pizza_id')
                        ->get();
        }else{
            $data = Order::select('orders.*','users.name as customer_name','pizzas.pizza_name',DB::raw('COUNT(orders.pizza_id) as count'))
                        ->join('users', 'users.id', 'orders.customer_id')
                        ->join('pizzas', 'pizzas.pizza_id', 'orders.pizza_id')
                        ->groupBy('orders.customer_id', 'orders.pizza_id')
                        ->orderBy('orders.order_id', 'asc')
                        ->get();
            
        }
        // $data = Category::get();

        

        $csvExporter = new \Laracsv\Export();

        // $csvExporter->beforeEach(function ($user) {
        //     $user->created_at = $user->created_at->format('Y-m-d');
        // });

        $csvExporter->build($data, [
            'order_id' => 'ID',
            'customer_name' => 'Customer Name',
            'pizza_name' => 'Pizza Name',
            'count' => 'Pizza Count',
            'order_time' => 'Order Date',
        ]);

        $csvReader = $csvExporter->getReader();

        $csvReader->setOutputBOM(\League\Csv\Reader::BOM_UTF8);

        $filename = 'orderList.csv';

        return response((string) $csvReader)
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="'.$filename.'"');
    }
}
