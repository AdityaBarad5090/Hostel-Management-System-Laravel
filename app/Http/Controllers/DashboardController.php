<?php
namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Room;
use App\Models\Fee;
use App\Models\Complaint;

class DashboardController extends Controller
{
    public function index()
    {
        $students = Student::count();
        $rooms = Room::count();
        $fees = Fee::count();
        $complaints = Complaint::count();

        return view('dashboard', compact('students', 'rooms', 'fees', 'complaints'));
    }
}
