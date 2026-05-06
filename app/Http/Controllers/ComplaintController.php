<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Student;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function index()
    {
        $complaints = Complaint::with('student.room')->get();
        $students = Student::all();

        return view('complaints', compact('complaints', 'students'));
    }

    public function store(Request $request)
    {
        Complaint::create($request->all());
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        Complaint::find($id)->update($request->all());
        return redirect()->back();
    }

    public function destroy($id)
    {
        Complaint::find($id)->delete();
        return redirect()->back();
    }
}
