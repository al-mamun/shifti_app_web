<?php

namespace App\Http\Controllers\API\Backend\Email;

use App\Http\Controllers\Controller;
use App\Models\Emailhistory;
use Illuminate\Http\Request;

class EmailHistoryController extends Controller
{
    public function emailHistory(){
        $emailhistory = Emailhistory::latest()->paginate(5);
        return view('emails.index',compact('emailhistory'));
    }
    public function Delete($id){
        
        $emailhistoryDelete = Emailhistory::first();
        $emailhistoryDelete->delete();
        dd($emailhistoryDelete);
        return redirect()->back()->with(['success' => 'Data Deleted Successfully.']);
    }
}
