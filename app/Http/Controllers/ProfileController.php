<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Task;
use App\Semester;
use Gate;
class ProfileController extends Controller
{
    public function dashboard(){
        $user = User::class;
        if(Gate::allows('onlyAdmin', $user) || Gate::allows('onlyAdminTeacher', $user)){
            $data['events'] = Task::where('status', 'active')->where('isDeleted', 0)->get();
            $data['sessions'] = Semester::where('status', 'active')->where('isDeleted', 0)->get();
            return view('profile.dashboard')->with('data', $data);
        }
        return view('forbidden');
    }

    public function session_events($id){
        $user = User::class;
        if(Gate::allows('onlyAdmin', $user)  || Gate::allows('onlyAdminTeacher', $user)){
            // $data['events'] = Task::where('status', 'active')->where('isDeleted', 0)->get();
            $data['events'] = Task::where('semester_id', $id)->get();
            $data['session'] = Semester::findOrFail($id);
            $data['id'] = $id;
            return view('profile.events')->with('data', $data);
        }
        return view('forbidden');
    }


    public function user_profile(){
        $user = Auth::user();
        if(Gate::allows('onlyAdmin', $user)  || Gate::allows('onlyAdminTeacher', $user)){
            return view('profile.index', compact('user'));
        }
        return view('forbidden', compact('user'));
        //return "Your profile page is under construction, please check later. Thank You";
    }
    public function user_profile_update(Request $request){
        $id = Auth::user()->id;
        $user = User::findorFail($id);
        $validated = $request->validate([   
            "first_name" => 'required|max:50',
            "last_name" => 'required|max:50',
            "address" => 'required|max:100',
            "phone" => 'required|max:50',
            ]);
        $input = $request->all();
        $user->fill($input)->save();
        Session::flash('message', 'Your Profile Updated Successfully. <script>swal.firePP("success","Updated","Your Profile Updated Successfully.");</script>'); 
        return redirect()->back();
        
    }

    public function report($id){
        $data['events'] = Task::where('semester_id', $id)->get();
        return view('profile.report', compact('data'));
    }
}
