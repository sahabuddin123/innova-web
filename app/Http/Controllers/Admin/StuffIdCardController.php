<?php

namespace App\Http\Controllers\Admin;

use App\Models\Teachers;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use DB;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

use PDF;


class StuffIdCardController extends BaseController
{
 
    public function show($id)
    {
        $targetStuff = Teachers::find($id);
        $teachers = Teachers::where('deleted_at',null)->orderBy('id','desc')->get();
        $this->setPageTitle('Stuff', 'View Stuff : ');
        return view('admin.stuffidcard.show', compact('teachers', 'targetStuff'));
    }
    
    
    public function iddownload($id)
{
    try {
        $targetStuff = Teachers::findOrFail($id); // Ensures valid ID
        $teachers = Teachers::whereNull('deleted_at')->orderBy('id', 'desc')->get();

        // $pdf = PDF::loadView('admin.stuffidcard.cards', compact('teachers', 'targetStuff'))
        //     ->setPaper('a4', 'portrait') // Set paper size and orientation
        //     ->setOptions([
        //         'isHtml5ParserEnabled' => true, // Ensures proper HTML parsing
        //         'isRemoteEnabled' => true,     // Allows loading external assets
        //         'dpi' => 200,                  // Set a higher DPI for better rendering
        //         'imageDPI' => 600,             // Ensures images retain high resolution
        //         'defaultFont' => 'Montserrat', // Set the default font
        //         'isPhpEnabled' => true,        // Allow PHP code execution for dynamic content
        //         'isFontSubsettingEnabled' => true, // Ensures only used fonts are embedded
        //     ])
        //     ->setWarnings(false); // Disable warnings to avoid clutter

        // return $pdf->download('idCard.pdf'); // Download the generated PDF
         return view('admin.stuffidcard.cards', compact('teachers', 'targetStuff'));

    } catch (ModelNotFoundException $e) {
        return redirect()->back()->with('error', 'Teacher not found.');
    } catch (Exception $e) {
        return redirect()->back()->with('error', 'An error occurred while generating the PDF.');
    }
}


    // public function iddownload($id)
    // {
    //     try {
    //         $targetStuff = Teachers::findOrFail($id); // Ensures valid ID
    //         $teachers = Teachers::whereNull('deleted_at')->orderBy('id', 'desc')->get();
    
    //         $pdf = PDF::loadView('admin.stuffidcard.cards', compact('teachers', 'targetStuff'))
    //             ->setPaper('a4', 'portrait')
    //             ->setOptions([
    //                 'isHtml5ParserEnabled' => true,
    //                 'isRemoteEnabled' => true,
    //                 'dpi' => 600,
    //                 'imageDPI' => 300,
    //                 'defaultFont' => 'Montserrat',
    //             ]);
    
    //         return $pdf->download('idCard.pdf');
    //         // return view('admin.stuffidcard.cards', compact('teachers', 'targetStuff'));
    
    //     } catch (ModelNotFoundException $e) {
    //         return redirect()->back()->with('error', 'Teacher not found.');
    //     } catch (Exception $e) {
    //         return redirect()->back()->with('error', 'An error occurred while generating the PDF.');
    //     }
    // }
    
//     public function idDownload($id)
// {
//     $targetStuff = Teachers::findOrFail($id);
//     $blood = $this->getBloodGroup($targetStuff->bloodgroup);
//     $joiningdate = date('d-M-Y', strtotime($targetStuff->joiningdate));

//     $pdf = PDF::loadView('admin.stuffidcard.show', compact('targetStuff', 'blood', 'joiningdate'))
//         ->setPaper('a4', 'portrait');
//     $this->setPageTitle('Stuff', 'View Stuff : ');
//     return $pdf->download('ID_Card_' . $targetStuff->stuffid . '.pdf');
// }

// private function getBloodGroup($bloodGroupCode)
// {
//     $groups = [
//         1 => 'A(+ve)', 2 => 'O(+ve)', 3 => 'B(+ve)', 4 => 'AB(+ve)',
//         5 => 'A(-ve)', 6 => 'O(-ve)', 7 => 'B(-ve)', 8 => 'AB(-ve)'
//     ];
//     return $groups[$bloodGroupCode] ?? 'Unknown';
// }

    

}
