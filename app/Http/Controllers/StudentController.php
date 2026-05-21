<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();

        $totalStudents = $students->count();
        $activeClearance = $students->where('status', 'active')->count();
        $pendingRequests = $students->where('status', 'pending')->count();
        $completedClearance = $students->where('status', 'completed')->count();

        $editStudent = null;
        if (session('edit_student_id')) {
            $editStudent = Student::find(session('edit_student_id'));
        }

        return view('student.index', compact(
            'students',
            'totalStudents',
            'activeClearance',
            'pendingRequests',
            'completedClearance',
            'editStudent'
        ));
    }

    public function create()
    {
        return redirect()->route('students.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|unique:students,email',
            'age'    => 'required|integer|min:1|max:120',
            'phone'  => 'nullable|string|max:20',
            'status' => 'required|in:active,pending,completed,inactive',
        ]);

        Student::create($validated);

        return redirect('/students')->with('success', 'Student added successfully.');
    }

    public function show(string $id)
    {
        return redirect()
            ->route('students.index')
            ->with('edit_student_id', $id);
    }

    public function edit(string $id)
    {
        return redirect()
            ->route('students.index')
            ->with('edit_student_id', $id);
    }

    public function update(Request $request, string $id)
    {
        $student = Student::findOrFail($id);

        $validated = $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|unique:students,email,' . $id,
            'age'    => 'required|integer|min:1|max:120',
            'phone'  => 'nullable|string|max:20',
            'status' => 'required|in:active,pending,completed,inactive',
        ]);

        $student->update($validated);

        return redirect('/students')->with('success', 'Student updated successfully.');
    }

    public function destroy(string $id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return redirect('/students')->with('success', 'Student deleted successfully.');
    }
}
