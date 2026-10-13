<?php

namespace App\Http\Controllers\Admin;

use App\Models\AssetRegistration;
use App\Models\AssetCourse;
use App\Models\AssetRegistrationFeedback;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\SMSController;
use App\Http\Controllers\BaseController;

class StudentManagementController extends BaseController
{
    public function index(Request $request)
    {
        $search = $request->input('q');
        $courseId = $request->input('course_id');
        $status = $request->input('registration_status');
        $callType = $request->input('call_type');

        $students = AssetRegistration::query()
            ->when($search, fn($query) => $query->where('full_name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('mobile', 'like', "%{$search}%")
                ->orWhere('whatsapp', 'like', "%{$search}%"))
            ->when($courseId, fn($query) => $query->where('course', $courseId))
            ->when($status, fn($query) => $query->where('registration_status', $status))
            ->when($callType, fn($query) => $query->where('call_type', $callType))
            ->orderBy('id', 'desc')
            ->paginate(25);

        $students->appends($request->only(['q', 'course_id', 'registration_status', 'call_type']));
        $courses = AssetCourse::where('status', 1)->orderBy('name')->get();
        $this->setPageTitle('ASSET Registrations', 'Manage student registrations');
        return view('admin.asset-training.students.index', compact('students', 'courses', 'search', 'courseId', 'status', 'callType'));
    }

    public function show($id)
    {
        $student = AssetRegistration::with('feedbacks')->findOrFail($id);
        $this->setPageTitle('Registration Details', 'Registration details for ' . $student->full_name);
        return view('admin.asset-training.students.show', compact('student'));
    }

    public function storeFeedback(Request $request, $id)
    {
        $request->validate([
            'feedback_step' => 'required|in:1,2,3,4,5',
            'feedback' => 'required|string|max:2000',
        ]);

        $student = AssetRegistration::findOrFail($id);
        AssetRegistrationFeedback::updateOrCreate(
            [
                'asset_registration_id' => $student->id,
                'feedback_step' => $request->feedback_step,
            ],
            [
                'feedback' => $request->feedback,
            ]
        );

        if ($request->input('redirect_to') === 'index') {
            return redirect()->route('admin.asset-training.students.index')
                ->with('success', 'Feedback saved successfully');
        }

        return redirect()->route('admin.asset-training.students.show', $student->id)
            ->with('success', 'Feedback saved successfully');
    }

    public function delete($id)
    {
        $student = AssetRegistration::findOrFail($id);
        $student->delete();
        return $this->responseRedirect('admin.asset-training.students.index', 'Registration deleted successfully', 'success', false, false);
    }

    public function updateStatus(Request $request, $id)
    {
        $allowedStatuses = [
            'Pending',
            'Contacted',
            'Converted',
            'Follow Up',
            'Follow Up Later',
            'Lost',
            'Not Qualified',
            'Qualified',
            'Service',
            'Wrong Number',
            'Not Interested',
            'Canceled',
            'Don\'t Call Again',
        ];

        $request->validate([
            'registration_status' => 'required|in:' . implode(',', $allowedStatuses),
        ]);

        $student = AssetRegistration::findOrFail($id);
        $student->update(['registration_status' => $request->registration_status]);

        if ($student->whatsapp && $request->registration_status === 'Qualified') {
            $message = "আপনাকে সংক্ষিপ্ত তালিকাভুক্ত করা হয়েছে। দয়া করে আপনার WhatsApp চেক করুন।";
            try {
                $smsController = new SMSController();
                $smsController->send_sms($student->whatsapp, $message);
            } catch (\Exception $e) {
                // Logging could be added here if needed
            }
        }

        if ($request->input('redirect_to') === 'index') {
            return redirect()->route('admin.asset-training.students.index')
                ->with('success', 'Registration status updated successfully');
        }

        return redirect()->route('admin.asset-training.students.show', $student->id)
            ->with('success', 'Registration status updated successfully');
    }

    public function updateCallType(Request $request, $id)
    {
        $callTypes = ['1st call','2nd call','3rd call','4th call','5th call'];

        $request->validate([
            'call_type' => 'required|in:' . implode(',', $callTypes),
        ]);

        $student = AssetRegistration::findOrFail($id);
        $student->update(['call_type' => $request->call_type]);

        return redirect()->route('admin.asset-training.students.index')
            ->with('success', 'Call type updated successfully');
    }
}
