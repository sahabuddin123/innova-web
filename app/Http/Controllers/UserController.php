<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\User;
use App\Models\Admin;
use App\Models\Students;
use App\Models\Batchs;
use App\Models\Courses;
// use App\Models\Session;
use App\Models\FeesTransections;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Registration;
// use Illuminate\Support\Facades\Auth;

class UserController extends BaseController
{
    
    public $user;

    public function __construct()
    {
    //    $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if($this->user == null){
            return $this->responseRedirect('login', 'Please Login' ,'error',false, false);
        }
        else{
        // $students = User::where();
        // $allNotics =  count(Notics::select('id')->where('isActive',1)->get());
        // $allSubject =  count(Subjects::select('id')->where('isActive',1)->where('semester',$this->user->semester_id)->get());
        // $allJobs =  count(Jobs::select('id')->where('isActive',1)->where('categories',$this->user->recharce_id)->get());
        // $allcourse =  count(Course::select('id')->where('isActive',1)->where('courseCategoris',$this->user->recharce_id)->get());
        // $allassistant =  count(RecharceAssistant::select('id')->where('carrer',$this->user->recharce_id)->where('isActive',1)->get());
        // $allpaper =  count(ResearchPapers::select('id')->where('carrer',$this->user->recharce_id)->where('isActive',1)->get());
         $students = $this->user;
        return view('users.dashboard.index', compact(
            'students'
        ));
    }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        return view('frontend.users.create',compact('roles'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);


        $input = $request->all();
        $input['password'] = Hash::make($input['password']);


        $user = User::create($input);
        $user->assignRole($request->input('roles'));


        return redirect()->route('users.index')
                        ->with('success','User created successfully');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('users.show',compact('user'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();


        return view('users.edit',compact('user','roles','userRole'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);


        $input = $request->all();
        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = array_except($input,array('password'));    
        }


        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();


        $user->assignRole($request->input('roles'));


        return redirect()->route('users.index')
                        ->with('success','User updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('users.index')
                        ->with('success','User deleted successfully');
    }

    
    public function profile()
    {
        if($this->user == null){
            return $this->responseRedirect('login', 'Please Login' ,'error',false, false);
        }
        else{
        $targetStudents = Students::where('user_id', $this->user->id)->where('deleted_at', null)->first();
        $batchs = DB::table('batchs')->where('deleted_at', null)->get();
        $courses = DB::table('courses')->where('deleted_at', null)->get();
        // dd($targetStudents);
        $this->setPageTitle('Students', 'View Students : '.$targetStudents->sname);
        return view('users.profile.index', compact('targetStudents', 'batchs', 'courses'));
    }
    }

    public function paymentHistory(){
        if($this->user == null){
            return $this->responseRedirect('login', 'Please Login' ,'error',false, false);
        }
        else{
        $user = $this->user->id;
        // $id = 
        $students = Students::where('user_id',  $user)->first();
        $fees = FeesTransections::where('student_id',$students->id)->where('paymentType',1)->where('status', 0)->get();
        $paid = FeesTransections::where('student_id',$students->id)->where('paymentType',1)->where('status', 0)->sum('paidamount');
        //$regfeespaid = FeesTransections::where('student_id',$id)->where('paymentType',2)->sum('paidamount');
        $paid = $paid;
        // $request->session()->forget('key');
        Session::forget('due_amount');
        Session::forget('student_id');
        Session::forget('payment_type');
        Session::put('student_id', $students->id);
        Session::put('due_amount', $students->balance - $paid);
        Session::put('payment_type', 1);
        // dd(Session::get('student_id'));
        // dd($students->id);
        $this->setPageTitle('Payments Details', 'Payments Details');
        return view('users.profile.payments-history', compact('students', 'fees', 'paid'));
        }
    }
    public function RegPayment(){
        if($this->user == null){
            return $this->responseRedirect('login', 'Please Login' ,'error',false, false);
        }
        else{
        $user = $this->user->id;
        // $id = 
        
        $students = Students::where('user_id',  $user)->first();
        $reg = DB::table('registrations')->where('student_id',$students->id)->first();
        $fees = FeesTransections::where('student_id',$students->id)->where('paymentType', '!=', 1)->where('status', 0)->get();
        $paid = FeesTransections::where('student_id',$students->id)->where('paymentType', '!=', 1)->where('status', 0)->sum('paidamount');
        //$regfeespaid = FeesTransections::where('student_id',$id)->where('paymentType',2)->sum('paidamount');
        $paid = $paid;
        // $request->session()->forget('key');
        Session::forget('due_amount');
        Session::forget('student_id');
        Session::forget('payment_type');
        Session::put('student_id', $students->id);
        Session::put('due_amount', $reg->balance - $paid);
        Session::put('payment_type', 2);
        // dd(Session::get('student_id'));
        // dd($students->id);
        $this->setPageTitle('Payments Details', 'Registration Fees');
        return view('users.registration.reg-history', compact('students', 'fees', 'paid'));
        }
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function RegistrationCreate($id)
    {
        if($this->user == null){
            return $this->responseRedirect('login', 'Please Login' ,'error',false, false);
        }
        else{
        $registration = Registration::where('deleted_at', null)->get();
        $session = DB::table('sessions')->where('deleted_at', null)->where('IsActive',1)->get();
        $students = Students::where('deleted_at', null)->where('id', $id)->first();
        
        $this->setPageTitle('Create Your Registration', 'BTEB Registration for <b class="text-success">'.$students->sname."</b>");
        return view('users.registration.create', compact('registration','session','students'));
        }
    }
        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function RegistrationStore(Request $request)
    {
        if($this->user == null){
            return $this->responseRedirect('login', 'Please Login' ,'error',false, false);
        }
        else{
        $this->validate($request, [
            'student_id'    =>  'required',
            'session_id'    =>  'required',
            'ExamName'      =>  'required',
            'ExamBoard'     =>  'required',
            'ExamSession'   =>  'required',
            'ExamRoll'      =>  'required',
            'ExamReg'      =>  'required',
            'PassYear'      =>  'required',
            // 'balance'       =>  'required',
            // 'IsActive'      =>  'required',
            'regDate'       =>  'required',
        ]);

        $registration = new Registration;
        $registration->student_id = $request->student_id ;
        $registration->session_id = $request->session_id ;
        $registration->ExamName = $request->ExamName ;
        $registration->ExamBoard = $request->ExamBoard ;
        $registration->ExamSession = $request->ExamSession ;
        $registration->ExamRoll = $request->ExamRoll ;
        $registration->ExamReg = $request->ExamReg ;
        $registration->PassYear = $request->PassYear ;
        $registration->balance = "2036" ;
        $registration->IsActive = "2";
        $registration->regDate = $request->regDate;
        $data = $registration->save();

        if (!$data) {
            return $this->responseRedirectBack('Error occurred while creating Registrations.', 'error', true, true);
        }
        Students::where('id', $request->student_id)->update(['IsRegister' => 2]);
        
        return $this->responseRedirect('user.reg.payment', 'Registrations added successfully' ,'success',false, false);
    }
}

}