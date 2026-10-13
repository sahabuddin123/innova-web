<?php

namespace App\Http\Controllers\Admin;

use App\Models\Students;
use App\Models\Courses;
use App\Models\Batchs;
use App\Models\FeesTransections;
use App\Contracts\StudentsContract;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use DB;

use Barryvdh\DomPDF\Facade as PDF;


class IdCardController extends BaseController
{
    /**
     * @var StudentsContract 
     */
    protected $studentsRepository;
    /**
     * CategoryController constructor.
     * @param StudentsContract $studentsRepository
     */
    public function __construct(StudentsContract $studentsRepository)
    {
        $this->studentsRepository = $studentsRepository;
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Students  $students
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $targetStudents = $this->studentsRepository->findStudentsById($id);
        $students = $this->studentsRepository->listStudents();
        $batchs = DB::table('batchs')->where('deleted_at', null)->get();
        $courses = DB::table('courses')->where('deleted_at', null)->get();

        $this->setPageTitle('Students', 'View Students : ' . $targetStudents->sname);
        return view('admin.idcard.show', compact('students', 'targetStudents', 'batchs', 'courses'));
    }

   public function iddownload($id)
{
    $targetStudents = $this->studentsRepository->findStudentsById($id);
    $students = $this->studentsRepository->listStudents();
    $batchs = DB::table('batchs')->where('deleted_at', null)->get();
    $courses = DB::table('courses')->where('deleted_at', null)->get();

    // Load the view and convert it to a PDF
    $pdf = PDF::loadView('admin.idcard.cards', compact('students', 'targetStudents', 'batchs', 'courses'))
        ->setPaper('a4', 'portrait') // Set paper size and orientation
        ->setOptions([
            'isHtml5ParserEnabled' => true,  // Enable the HTML5 parser
            'isRemoteEnabled' => true,       // Enable loading of remote resources (e.g., images)
            'dpi' => 100,                    // Set the DPI (dots per inch) for higher quality
            'imageDPI' => 300,               // Set image DPI for better image quality
            'defaultFont' => 'Montserrat',   // Set the default font to Montserrat
        ]);

    return $pdf->download('idCard.pdf');
}

}
