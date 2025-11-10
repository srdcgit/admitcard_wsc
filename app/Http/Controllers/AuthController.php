<?php

namespace App\Http\Controllers;

use App\Models\Download;
use App\Models\Query;
use App\Models\Student;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request){
        $creds = [
            'email' => $request->email,
            'password' => $request->password
        ];
        //Checking User Registeration Code Start
        $user = User::where('email',$request->email)->first();
        if(!$user)
        {
            toastr()->error('User is Not Registered.');
            return redirect()->back();
        }
        //Checking User Registeration Code End
        //User Authentication Code Start
        if(Auth::guard('user')->attempt($creds))
        {
            if($user->role->name == 'Admin')
            {
                toastr()->success('You Login Successfully');
                return redirect()->intended(route('admin.dashboard.index'));
            }
            else{
                Auth::logout();
                toastr()->error('Unauthorized.');
                return redirect()->back();

            }
        } else {
            toastr()->error('Wrong Password.');
            return redirect()->back();
        }
        //User Authentication Code End
    }
    
    public function logout()
    {        
        Auth::logout();
        toastr()->success('You Logout Successfully');
        return redirect('/');
    }
    public function queryStore(Request $request)
    {        
        try{
            Query::create($request->all());
            toastr()->success('Query Send Successfully!');
            return redirect()->to(route('home'));
        }catch(Exception $e)
        {
            toastr()->error($e->getMessage());
            return redirect()->back();
        }
    }
    public function home(Request $request)
    {        
        if($request->roll_number && $request->dob)
        {
            // Parse the input date - try DD-MM-YYYY first, then other formats
            $inputDob = null;
            try {
                // Try DD-MM-YYYY format first (most common input format)
                $inputDob = Carbon::createFromFormat('d-m-Y', $request->dob);
            } catch (\Exception $e) {
                try {
                    // Try YYYY-MM-DD format
                    $inputDob = Carbon::createFromFormat('Y-m-d', $request->dob);
                } catch (\Exception $e2) {
                    try {
                        // Try generic parse
                        $inputDob = Carbon::parse($request->dob);
                    } catch (\Exception $e3) {
                        toastr()->error('Invalid date format. Please use DD-MM-YYYY format (e.g., 25-06-1999).');
                        return back();
                    }
                }
            }
            
            // Format the date to YYYY-MM-DD for database comparison (DATE columns store in this format)
            $dobForQuery = $inputDob->format('Y-m-d');
            
            // Also prepare formats in case dob is stored as VARCHAR
            $dobFormat1 = $inputDob->format('d-m-Y');  // DD-MM-YYYY
            $dobFormat2 = $inputDob->format('Y-m-d');  // YYYY-MM-DD
            
            // Search for student - check roll_number AND dob (try multiple date formats)
            $student = Student::where('roll_number', trim($request->roll_number))
                        ->where(function($query) use ($dobForQuery, $dobFormat1, $dobFormat2, $inputDob) {
                            // Try multiple date formats to handle different storage types
                            $query->where(function($q) use ($dobForQuery, $dobFormat1, $dobFormat2, $inputDob) {
                                // If dob is DATE type (MySQL stores as YYYY-MM-DD internally)
                                $q->whereDate('dob', $dobForQuery)
                                  // If dob is VARCHAR with DD-MM-YYYY format (as shown in DB)
                                  ->orWhere('dob', $dobFormat1)
                                  // If dob is VARCHAR with YYYY-MM-DD format  
                                  ->orWhere('dob', $dobFormat2)
                                  // Handle string date conversion: if stored as DD-MM-YYYY string, convert and compare
                                  ->orWhereRaw("STR_TO_DATE(dob, '%d-%m-%Y') = STR_TO_DATE(?, '%Y-%m-%d')", [$dobForQuery])
                                  ->orWhereRaw("DATE(dob) = ?", [$dobForQuery]);
                            });
                        })
                        ->first();
            
            if($student)
            {
                // Update student's is_download status
                $student->update(['is_download' => 1]);
                return view('front.student.card', compact('student'));
            } else {
                toastr()->error('Student not found. Please check your Roll Number and Date of Birth.');
                return back();
            }
        }
        return view('front.home.index');
    }
}
