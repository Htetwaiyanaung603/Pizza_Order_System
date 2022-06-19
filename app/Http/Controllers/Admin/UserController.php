<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    //user list page
    public function userList () {
        if(Session::has('USER_SEARCH')){
            Session::forget('USER_SEARCH');
        }
        $data = User::where('role', 'user')->paginate(5);
        return view('admin.user.userList')->with(['user' => $data]);
    }

    //admin list page
    public function adminList () {
        if(Session::has('ADMIN_SEARCH')){
            Session::forget('ADMIN_SEARCH');
        }
        $data = User::where('role', 'admin')->paginate(5);
        return view('admin.user.adminList')->with(['admin' => $data]);
    }

    //user Search
    public function userSearch (Request $request) {
        $searchData = $this->search($request, 'user');
        Session::put('USER_SEARCH', $request->searchData);  
        return view('admin.user.userList')->with(['user' => $searchData]);
    }

    //admin search
    public function adminSearch (Request $request) {
        $searchData = $this->search($request, 'admin');
        Session::put('ADMIN_SEARCH', $request->searchData);
        return view('admin.user.adminList')->with(['admin' => $searchData]);
    }

    //search function
    private function search ($request, $role) {
        $searchKey = $request->searchData;
        $searchData = User::where('role', $role)
                            ->where(function ($query) use ($searchKey) {
                            $query->orWhere('name','like','%'.$searchKey.'%')
                                ->orWhere('email','like','%'.$searchKey.'%')
                                ->orWhere('phone','like','%'.$searchKey.'%')
                                ->orWhere('address','like','%'.$searchKey.'%');
                            })
                            ->paginate(5);
        
        $searchData->appends($request->all());
        return $searchData;
    }

    //user download csv
    public function userDownload() {
        if(Session::has('USER_SEARCH')){
            $searchKey = Session::get('USER_SEARCH');
            $data =User::where('role', 'user')
                        ->where(function ($query) use ($searchKey) { $query
                            ->orWhere('name','like','%'.$searchKey.'%')
                            ->orWhere('email','like','%'.$searchKey.'%')
                            ->orWhere('phone','like','%'.$searchKey.'%')
                            ->orWhere('address','like','%'.$searchKey.'%');
                            })
                            ->get();
        }else{
            $data = User::where('role', 'user')->get();
            
        }
        $csvExporter = new \Laracsv\Export();
        $csvExporter->build($data, [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'address' => 'Address',
            'role' => 'Role',
        ]);

        $csvReader = $csvExporter->getReader();

        $csvReader->setOutputBOM(\League\Csv\Reader::BOM_UTF8);

        $filename = 'userList.csv';

        return response((string) $csvReader)
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="'.$filename.'"');
    }

    //admin download csv
    public function adminDownload() {
        if(Session::has('ADMIN_SEARCH')){
            $searchKey = Session::get('ADMIN_SEARCH');
            $data =User::where('role', 'admin')
                        ->where(function ($query) use ($searchKey) { $query
                            ->orWhere('name','like','%'.$searchKey.'%')
                            ->orWhere('email','like','%'.$searchKey.'%')
                            ->orWhere('phone','like','%'.$searchKey.'%')
                            ->orWhere('address','like','%'.$searchKey.'%');
                            })
                            ->get();
        }else{
            $data = User::where('role', 'admin')->get();
            
        }
        $csvExporter = new \Laracsv\Export();
        $csvExporter->build($data, [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'address' => 'Address',
            'role' => 'Role',
        ]);

        $csvReader = $csvExporter->getReader();

        $csvReader->setOutputBOM(\League\Csv\Reader::BOM_UTF8);

        $filename = 'adminList.csv';

        return response((string) $csvReader)
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="'.$filename.'"');
    }

    //user delete
    public function userDelete($id) {
        User::where('id', $id)->delete();
        return back()->with(['success' => 'Delete Successfully...']);
    }
}
