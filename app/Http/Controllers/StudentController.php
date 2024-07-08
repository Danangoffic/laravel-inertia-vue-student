<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClassesResource;
use App\Http\Resources\SectionResource;
use App\Http\Resources\StudentResource;
use App\Models\Classes;
use App\Models\Section;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $student = Student::query();
        $name = null;
        if($request->has('name')){
            $name = '%'.$request->get('name').'%';
            $student->where('name', 'like', $name);
        }
        $student = $student->orderBy("id", 'DESC');
        $students = StudentResource::collection($student->paginate(15));
        return Inertia::render('student/index', [
            'students' => $students,
            'name' => $request->get('name')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render("student/Create", [
            'classes' => ClassesResource::collection(Classes::all()),
            'sections' => SectionResource::collection(Section::all())
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $student_credentials = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:students,email|max:255',
            'section_id' => 'required|exists:sections,id',
            'class_id' => 'required|exists:classes,id'
        ]);
        if (Student::create($student_credentials)) {
            return to_route('student.index')->with('success', 'Success create a student data');
        } else {
            return back()->withErrors($student_credentials)->with('error', "Failed to create a student data");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $student = Student::findOrFail($id);
            return Inertia::render("student/Edit", [
                'student' => $student,
                'classes' => ClassesResource::collection(Classes::all()),
                'sections' => SectionResource::collection(Section::all()),
                'submit_edit' => route('student.update', $id)
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            Log::error("Failed to read edit caused with : " . $th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $student_credentials = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'section_id' => 'required|exists:sections,id',
            'class_id' => 'required|exists:classes,id'
        ]);

        $student = Student::find($id);
        if (!$student) {
            return back()->withErrors(['message' => 'Student not found']);
        }
        $unique_email = Student::where('id', '<>', $id)->where('email', $request->input('email'))->get();
        if($unique_email){
            return back()->withErrors(['message' => 'Email has been taken']);
        }

        $student->update($student_credentials);

        return to_route('student.index')->with('success', 'Student updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
