<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Registration;
use App\Models\Teachers;
use App\Models\Students;
use App\Models\Courses;
use App\Models\Session;
use App\Models\Contact;
use App\Models\Slider;
use App\Models\Admission;
use App\Models\SuccessStory;
use App\Models\cmsAbout;
use App\Models\CourseCategory;
use App\Models\Review;
use App\Models\Blog;
use App\Models\Gallery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use App\Models\blogCategoris;
use Illuminate\Support\Facades\Redirect;
use ReCaptcha;
use App\Models\Seminor;
use App\Models\SeminorRegistration;
use App\Models\Certificate_icbd;
use App\Models\Batchs;
use App\Models\Service;
use App\Models\Product;
use App\Models\Workflow;
use App\Models\Client;
use App\Models\Technology;

class FrontendController extends BaseController
{
    public function index()
    {
        $sessions = Session::where('deleted_at', null)->get();
        $FeaturecourseCategory  = CourseCategory::where('deleted_at', null)->where('isFeature', '!=', 0)->where('IsActive', '!=', 0)->get();
        $courseCategory = CourseCategory::where('deleted_at', null)->where('IsActive', '!=', 0)->get();
        $EnglishCourses = Courses::where('deleted_at', null)->where('category_id', 7)->where('IsActive', '!=', 0)->where('featured', '!=', 0)->get();
        $BasicCourses = Courses::where('deleted_at', null)->where('category_id', 8)->where('IsActive', '!=', 0)->where('featured', '!=', 0)->get();
        $digitalCourses = Courses::where('deleted_at', null)->where('category_id', 2)->where('IsActive', '!=', 0)->where('featured', '!=', 0)->get();
        $GraphicCourses = Courses::where('deleted_at', null)->where('category_id', 10)->where('IsActive', '!=', 0)->where('featured', '!=', 0)->get();
        $Webcourses = Courses::where('deleted_at', null)->where('category_id', 1)->where('IsActive', '!=', 0)->where('featured', '!=', 0)->get();
        $courses = Courses::where('deleted_at', null)->where('IsActive', '!=', 0)->where('featured', '!=', 0)->get();
        $teacher = Teachers::where('deleted_at', null)->where('IsActive', '!=', 3)->where('IsFeatured', '!=', 1)->where('isTeacher', '!=', 1)->orderBy('stuffid', 'asc')->get();
        $blogs = Blog::where('deleted_at', null)->where('IsActive', '!=', 0)->where('featured', '!=', 0)->orderBy('id', 'desc')->get();
        $slider = Slider::where('deleted_at', null)->where('IsActive', '!=', 0)->get();
        $story = SuccessStory::where('deleted_at', null)->where('IsActive', '!=', 0)->orderBy('id', 'asc')->first();
        $cmsAbout = cmsAbout::where('deleted_at', null)->where('IsActive', '!=', 0)->orderBy('id', 'desc')->get();
        $Review = Review::where('deleted_at', null)->where('IsActive', '!=', 0)->orderBy('id', 'desc')->get();
        
        // Fetch dynamic modules for homepage
        $services = Service::where('status', 1)->latest()->get();
        $products = Product::where('status', 1)->latest()->get();
        $workflows = Workflow::where('status', 1)->orderBy('step')->get();
        $clients = Client::where('is_active', 1)->get();
        
        $technologies = Technology::where('is_active', 1)->get();
        
        $this->setPageTitle('Home', 'INNOVA Computers BD');
        return view('frontend.v2.layout.index', compact('sessions', 'teacher', 'courses', 'slider', 'story', 'courseCategory', 'FeaturecourseCategory', 'EnglishCourses', 'BasicCourses', 'digitalCourses', 'GraphicCourses', 'Webcourses', 'Review', 'blogs', 'cmsAbout', 'services', 'products', 'workflows', 'clients', 'technologies'));
    }

    public function Seminors()
    {
        $seminor = Seminor::where('deleted_at', null)->where('IsActive', '!=', 0)->orderBy('id', 'desc')->get();
        $seminorreg = SeminorRegistration::where('deleted_at', null)->where('IsActive', '!=', 0)->orderBy('id', 'desc')->get();
        $this->setPageTitle('Seminar', 'INNOVA Computers BD');
        return view('frontend.v2.layout.seminor', compact('seminorreg', 'seminor'));
    }
    public function seminorsreg($id)
    {
        $seminor  = Seminor::find($id);
        $seminorreg = SeminorRegistration::where('deleted_at', null)->where('IsActive', '!=', 0)->orderBy('id', 'desc')->get();
        $this->setPageTitle('Seminar Registration', 'INNOVA Computers BD');
        return view('frontend.v2.layout.seminorreg', compact('seminorreg', 'seminor'));
    }

    public function SeminorsRegStore(Request $request)
    {

        $this->validate($request, [
            'username'  =>  'required',
            'phone'  =>  'required',
            'email'  =>  'required',
            'profession'  =>  'required',
            'address'  =>  'required'

        ]);

        $params = $request->except('_token');
        $collection = collect($params);
        $data = new SeminorRegistration($collection->all());
        $data->save();

        // dd($data);
        if (!$data) {
            return $this->responseRedirectBack('দুঃখিত! একটি সমস্যা হচ্ছে, আবার চেষ্টা করুন।', 'error', true, true);
        } else {
            return $this->responseRedirect('frontend.home', 'অভিনন্দন! আপনার রেজিস্ট্রেশন সম্পন্ন হয়েছে, আমাদের প্রতিনিধি খুব দ্রুত আপনার সাথে যোগাযোগ করবেন।', 'success', false, false);
        }
    }
    // Blogs
    public function blogs(Request $request)
    {
        // Sorting logic: Default is 'Newest'
        $sort_by = $request->get('sort_by', 'newest'); // Get sort option from request, default to 'newest'

        // Define sorting options
        switch ($sort_by) {
            case 'trending':
                $sortField = 'views'; // Assuming you have a 'views' column for trending
                $sortDirection = 'desc';
                break;
            case 'popular':
                $sortField = 'views'; // Assuming you have a 'comments' column for popular blogs
                $sortDirection = 'desc';
                break;
            default:
                $sortField = 'id';
                $sortDirection = 'desc'; // Default sorting by newest (ID)
        }

        // Fetch blogs with pagination and sorting
        $blogs = Blog::where('deleted_at', null)
            ->where('IsActive', '!=', 0)
            ->orderBy($sortField, $sortDirection)
            ->paginate(9); // 9 blogs per page
        // Fetch blog categories
        $blogscategory = blogCategoris::where('deleted_at', null)
            ->where('IsActive', '!=', 0)
            ->orderBy('id', 'desc')
            ->get();

        // Set page title and return view with pagination data
        $this->setPageTitle('Blogs', 'INNOVA Computers BD');
        return view('frontend.v2.layout.blogs', compact('blogs', 'blogscategory'));
    }

    public function blogsShow($id)
    {
        // Fetch the blog post by ID
        $blogs = Blog::where('id', $id)
            ->where('deleted_at', null)
            ->where('IsActive', '!=', 0)
            ->firstOrFail(); // Use firstOrFail to throw 404 if not found

        // Increment the blog's view count
        $blogs->views = $blogs->views + 1;
        $blogs->save(); // Save the updated views to the database

        // Fetch related blog categories (if needed for the view)
        $blogcategory = blogCategoris::where('id', $blogs->category_id)
            ->whereNull('deleted_at')
            ->where('IsActive', '!=', 0)
            ->orderBy('id', 'desc')
            ->take(10)
            ->get();

        // Set page title based on the blog title
        $this->setPageTitle($blogs->heading, 'INNOVA Computers BD');
        return view('frontend.v2.layout.blogread', compact('blogs', 'blogcategory'));
    }

    public function search(Request $request)
    {
        $searchQuery = $request->id; // Get the search query from the request

        $blogs = Blog::where('deleted_at', null)
            ->where(function ($query) use ($searchQuery) {
                $query->where('id', $searchQuery)
                    ->orWhere('heading', 'LIKE', '%' . $searchQuery . '%');
            })
            ->paginate(9);

        if ($blogs->isEmpty()) {
            $this->setPageTitle('404', 'INNOVA Computers BD ');
            $data = "দুঃখিত! আপনার সার্চকৃত ব্লগটি খুজে পাওয়া যায়নি।";
            return view('frontend.v2.layout.404', compact('data'));
        }

        $this->setPageTitle('Blogs', 'INNOVA Computers BD ');
        return view('frontend.v2.layout.blogsearch', compact('blogs'));
    }

    //faq
    public function faq()
    {
        $review = Review::where('deleted_at', null)->where('IsActive', '!=', 0)->orderBy('id', 'desc')->get();
        $this->setPageTitle('FAQ', 'INNOVA Computers BD');
        return view('frontend.v2.layout.faq', compact('review'));
    }
    //instuctor
    public function instructors()
    {
        $teacher = Teachers::where('deleted_at', null)->where('IsActive', '!=', 3)->where('isTeacher', '!=', 1)->orderBy('stuffid', 'asc')->paginate(9);
        $this->setPageTitle('Instructor', 'INNOVA Computers BD');
        return view('frontend.v2.layout.teacher', compact('teacher'));
    }
    //instructorDetails
    public function instructorDetails($id)
    {
        $teacher = Teachers::find($id);
        $this->setPageTitle('Instructor', 'INNOVA Computers BD');
        return view('frontend.v2.layout.teacherDetails', compact('teacher'));
    }
    public function sessions($id)
    {
        $registration = Registration::where('deleted_at', null)->where('session_id', $id)->get();
        $targetSession = Session::find($id);
        $this->setPageTitle('BTEB Registration', 'INNOVA Computers BD');
        return view('frontend.v2.layout.registration', compact('registration', 'targetSession'));
    }

    public function registerlist($id)
    {
        $targetRegistration = Registration::find($id);
        $this->setPageTitle('Registrations', 'View Registrations : ' . $targetRegistration->StudentsInfo->sname);
        return view('frontend.v2.layout.single-reg', compact('targetRegistration'));
    }

    public function courses(Request $request)
    {
        // Sorting logic: Default is 'Newest'
        $sort_by = $request->get('sort_by', 'newest'); // Get sort option from request, default to 'newest'

        // Define sorting options
        switch ($sort_by) {
            case 'trending':
                $sortField = 'views'; // Assuming you have a 'views' column for trending
                $sortDirection = 'desc';
                break;
            case 'popular':
                $sortField = 'views'; // Assuming you have a 'comments' column for popular blogs
                $sortDirection = 'desc';
                break;
            default:
                $sortField = 'id';
                $sortDirection = 'desc'; // Default sorting by newest (ID)
        }
        $courses = Courses::where('deleted_at', null)
            ->where('IsActive', '!=', 0)
            ->orderBy($sortField, $sortDirection)
            ->paginate(18);

        $this->setPageTitle('Courses', 'INNOVA Computers BD');
        return view('frontend.v2.layout.courses', compact('courses'));
    }



    public function about()
    {
        $teacher = Teachers::where('deleted_at', null)->where('IsActive', '!=', 3)->where('IsFeatured', '!=', 1)->where('isTeacher', '!=', 1)->orderBy('stuffid', 'asc')->get();
        $cmsAbout = cmsAbout::where('deleted_at', null)->where('IsActive', '!=', 0)->orderBy('id', 'desc')->get();
        $Review = Review::where('deleted_at', null)->where('IsActive', '!=', 0)->orderBy('id', 'desc')->get();
        $this->setPageTitle('About', 'INNOVA Computers BD');
        return view('frontend.v2.layout.about', compact('teacher', 'cmsAbout', 'Review'));
    }

    public function team()
    {
        $teams = \App\Models\Team::orderBy('order')->get();
        $this->setPageTitle('আমাদের টিম', 'INNOVA Computers BD');
        return view('frontend.v2.layout.team', compact('teams'));
    }

    public function successStory()
    {
        $FeaturecourseCategory  = CourseCategory::where('deleted_at', null)->where('isFeature', '!=', 0)->where('IsActive', '!=', 0)->get();
        $courseCategory = CourseCategory::where('deleted_at', null)->where('IsActive', '!=', 0)->get();
        $EnglishCourses = Courses::where('deleted_at', null)->where('category_id', 7)->where('IsActive', '!=', 0)->where('featured', '!=', 0)->get();
        $BasicCourses = Courses::where('deleted_at', null)->where('category_id', 8)->where('IsActive', '!=', 0)->where('featured', '!=', 0)->get();
        $digitalCourses = Courses::where('deleted_at', null)->where('category_id', 2)->where('IsActive', '!=', 0)->where('featured', '!=', 0)->get();
        $GraphicCourses = Courses::where('deleted_at', null)->where('category_id', 10)->where('IsActive', '!=', 0)->where('featured', '!=', 0)->get();
        $Webcourses = Courses::where('deleted_at', null)->where('category_id', 1)->where('IsActive', '!=', 0)->where('featured', '!=', 0)->get();
        $courses = Courses::where('deleted_at', null)->where('IsActive', '!=', 0)->where('featured', '!=', 0)->get();
        $story = SuccessStory::where('deleted_at', null)->where('IsActive', '!=', 0)->orderBy('id', 'asc')->paginate(12);
        $this->setPageTitle('Success Story', 'INNOVA Computers BD');
        return view('frontend.v2.layout.story', compact('FeaturecourseCategory', 'courseCategory', 'EnglishCourses', 'BasicCourses', 'digitalCourses', 'GraphicCourses', 'Webcourses', 'courses', 'story'));
    }
    public function frelanching()
    {
        $FeaturecourseCategory  = CourseCategory::where('deleted_at', null)->where('isFeature', '!=', 0)->where('IsActive', '!=', 0)->get();
        $courseCategory  = CourseCategory::where('deleted_at', null)->where('IsActive', '!=', 0)->get();
        $courseCategory = CourseCategory::where('deleted_at', null)->where('IsActive', '!=', 0)->get();
        $EnglishCourses = Courses::where('deleted_at', null)->where('category_id', 7)->where('IsActive', '!=', 0)->where('featured', '!=', 0)->get();
        $BasicCourses = Courses::where('deleted_at', null)->where('category_id', 8)->where('IsActive', '!=', 0)->where('featured', '!=', 0)->get();
        $digitalCourses = Courses::where('deleted_at', null)->where('category_id', 2)->where('IsActive', '!=', 0)->where('featured', '!=', 0)->get();
        $GraphicCourses = Courses::where('deleted_at', null)->where('category_id', 10)->where('IsActive', '!=', 0)->where('featured', '!=', 0)->get();
        $Webcourses = Courses::where('deleted_at', null)->where('category_id', 1)->where('IsActive', '!=', 0)->where('featured', '!=', 0)->get();
        $courses = Courses::where('deleted_at', null)->where('IsActive', '!=', 0)->where('featured', '!=', 0)->get();
        $story = SuccessStory::where('deleted_at', null)->where('IsActive', '!=', 0)->orderBy('id', 'asc')->paginate(12);
        $this->setPageTitle('freelancing', 'INNOVA Computers BD');
        return view('frontend.v2.layout.frelanching', compact('FeaturecourseCategory', 'courseCategory', 'EnglishCourses', 'BasicCourses', 'digitalCourses', 'GraphicCourses', 'Webcourses', 'courses', 'story', 'courseCategory'));
    }
    public function CoursesByCategory($id) {}
    public function contact()
    {
        $courses = Courses::where('deleted_at', null)->where('IsActive', '!=', 0)->get();
        $cmsAbout = cmsAbout::where('deleted_at', null)->where('IsActive', '!=', 0)->orderBy('id', 'desc')->get();
        $this->setPageTitle('Contact', "Inbox your queries");
        return view('frontend.v2.layout.contact', compact('courses', 'cmsAbout'));
    }

    public function gallery()
    {
        $gallery = Gallery::where('deleted_at', null)->where('IsActive', '!=', 0)->orderBy('id', 'desc')->get();
        $this->setPageTitle('Gallery', 'INNOVA Computers BD');
        return view('frontend.v2.layout.gallery', compact('gallery'));
    }

    public function storeContact(Request $request)
    {

        $this->validate($request, [
            'username' => 'required',
            'phone' => 'required|unique:contacts,phone',
            'courseId' => 'required',
            'msg' => 'required',
            'g-recaptcha-response' => 'recaptcha', //recaptcha validation
        ]);
        // if ($this->validate->fails()) {
        //     return redirect()->Back()->withInput()->withErrors($validator);

        //  }
        $contact = $request->except('_token');
        $contact['isActive'] = 0;
        $contacts = Contact::create($contact);

        if (!$contacts) {
            return $this->responseRedirectBack('Oops, Something went wrong! Please try again.', 'error', true, true);
        }

        $courses = Courses::where('deleted_at', null)->where('IsActive', '!=', 0)->get();
        return $this->responseRedirect('frontend.contact', 'Congratulation! Your queries data submitted.', 'success', false, false);
    }

    public function courseDetails($id)
    {
       
        $courses = Courses::where('deleted_at', null)->where('IsActive', '!=', 0)->where('id', $id)->first();
        $story = SuccessStory::where('deleted_at', null)->where('IsActive', '!=', 0)->orderBy('id', 'asc')->get();
        $this->setPageTitle('Courses', $courses->name);
        return view('frontend.v2.layout.courseDetails', compact('courses', 'story'));
    }

    public function courseAdmission($id)
    {
        $SelectedCourse = Courses::where('deleted_at', null)->where('IsActive', '!=', 0)->where('id', $id)->first();
        $courses = Courses::where('deleted_at', null)->where('IsActive', '!=', 0)->get();
        $this->setPageTitle('Admission', $SelectedCourse->name);
        return view('frontend.v2.layout.admission', compact('SelectedCourse', 'courses'));
    }

    public function storeAdmission(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'phone' => 'required',
            'courseId' => 'required',
            'courseType' => 'required'
        ]);

        $admission = $request->except('_token');
        $admission['isActive'] = 0;
        $admissions = Admission::create($admission);

        if (!$admissions) {
            return $this->responseRedirectBack('Oops, Something went wrong! Please try again.', 'error', true, true);
        }
        return Redirect::to( 'course-details/'. $request->courseId)->with('success', 'Congratulation! Your admission data submitted.');
    }

    public function getEmployeeInfo($id)
    {
        $employees = Teachers::where('deleted_at', null)->where('IsActive', '!=', 0)->where('stuffid', $id)->first();
        if (isset($employees)) {
            $this->setPageTitle('Employees Information', $employees->name);
            return view('frontend.layout.employeeinfo', compact('employees'));
        } else {
        }
    }

    public function getStudentInfo($id)
    {
        $student = Students::where('deleted_at', null)->where('IsActive', '!=', 0)->where('id', $id)->first();
        if (isset($student)) {
            $this->setPageTitle('Students Information', $student->sname);
            return view('frontend.layout.studentsinfo', compact('student'));
        } else {
        }
    }
    public function pageNotFound()
    {
        $this->setPageTitle('404', 'INNOVA Computers BD ');
        $data = "দুঃখিত! আপনি যে পেজটি খুজছেন তা খুজে পাওয়া যায়নি।";
        return view('frontend.v2.layout.404', compact('data'));
    }
    public function privacyPolicy()
    {
        $this->setPageTitle('Privacy Policy', 'INNOVA Computers BD');
        return view('frontend.v2.layout.privacy-policy');
    }
    public function termsConditions()
    {
        $this->setPageTitle('Terms & Conditions', 'INNOVA Computers BD');
        return view('frontend.v2.layout.terms-conditions');
    }

    public function certificateVerify($slnum)
    {
        $slnum = trim($slnum);
    
        // Find certificate by serial/certificate number
        $certificate = Certificate_icbd::whereNull('deleted_at')
            ->where('certificate_no', $slnum)
            ->first();
    
        $this->setPageTitle('Certificate Verification', 'INNOVA Computers BD');
    
        if (!$certificate) {
            $message = "দুঃখিত! সার্টিফিকেট খুঁজে পাওয়া যায়নি।";
            return view('frontend.v2.layout.certificate_verify', compact('message'));
        }
    
        // Get related info using relationships (if defined in the model)
        // $student = $certificate->student ?? null;
        // $course = $certificate->course() ?? null;
        // $batch = $certificate->batch() ?? null;
        $student = Students::whereNull('deleted_at')->where('id', $certificate->student->id)->first();
        $batch  = Batchs::whereNull('deleted_at')->get();
        $course  = Courses::whereNull('deleted_at')->get();
        // dd($course);
        return view('frontend.v2.layout.certificate_verify', compact('certificate', 'student', 'course', 'batch'));
    }


}
