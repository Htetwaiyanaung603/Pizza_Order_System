<?php

namespace App\Http\Controllers\Admin;

use auth;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    //create contact
    public function createContact (Request $request) {

        // validation
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required' ,
            'message' => 'required' ,
        ]);
 
        if ($validator->fails()) {
            return back()
                    ->withErrors($validator)
                    ->withInput();
        }
        //end validation

        $data = $this->requestUserData($request);

        Contact::create($data);

        return back()->with(['success' => 'Message Success...']);
        
    }

    //contact list
    public function contactList () {
        if(Session::has('CONTACT_SEARCH')){
            Session::forget('CONTACT_SEARCH');
        }
        $data = Contact::paginate(5);

        return view('admin.Contact.list')->with(['contact' => $data, 'status' => count($data) == 0 ? 0 : 1]);
    }

    //contact search
    public function contactSearch (Request $request) {
        $data = Contact::orWhere('name','like','%'.$request->searchData.'%')
                        ->orWhere('email','like','%'.$request->searchData.'%')
                        ->orWhere('message','like','%'.$request->searchData.'%')
                        ->paginate(5);
        Session::put('CONTACT_SEARCH', $request->searchData);
        $data->appends($request->all());
        return view('admin.Contact.list')->with(['contact' => $data, 'status' => count($data) == 0 ? 0 : 1 ]);
    }

    //contact download csv
    public function contactDownload() {
        
        if(Session::has('CONTACT_SEARCH')){
            $searchKey = Session::get('CONTACT_SEARCH');
            $data = Contact::orWhere('name','like','%'.$searchKey.'%')
                    ->orWhere('email','like','%'.$searchKey.'%')
                    ->orWhere('message','like','%'.$searchKey.'%')
                    ->get();
        }else{
            $data = Contact::get();
            
        }

        

        $csvExporter = new \Laracsv\Export();

        // $csvExporter->beforeEach(function ($user) {
        //     $user->created_at = $user->created_at->format('Y-m-d');
        // });

        $csvExporter->build($data, [
            'contacy_id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'message' => 'Message',
        ]);

        $csvReader = $csvExporter->getReader();

        $csvReader->setOutputBOM(\League\Csv\Reader::BOM_UTF8);

        $filename = 'contactList.csv';

        return response((string) $csvReader)
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="'.$filename.'"');
    }

    private function requestUserData ($request) {
        return [
            'name' => $request->name , 
            'email' => $request->email ,
            'message' => $request->message ,
            'user_id' => auth()->user()->id ,
        ];
    }
}
