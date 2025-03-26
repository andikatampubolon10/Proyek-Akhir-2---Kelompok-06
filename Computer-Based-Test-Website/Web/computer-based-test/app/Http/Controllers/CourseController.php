<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $course = course::OrderBy('id', 'DESC')->get();
        return view('Role.Guru.Course.index', [
            'course' => $course,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $course = course::all();
        return view('Role.Guru.Course.create', [
            'course' => $course,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $vallidated = $request->validated([
            "name" => 'require|string|max:20',
            "password" => 'require|string|min:8|confirmed|'
        ]);

        $hashedPassword = Hash::make($validated['password']);

        DB::beginTransaction();

        try {
            $newCourse = course::create($validated);
            
            DB.commit();

            return redirect()->route('Guru.Course.index');
        }
        catch(\Exception $e) {
            DB::rollback;
            $error = ValidateException::withMassages([
                'system_error' => ['System Error' . $e->getMassage()],
            ]);

            throw $error;

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        //
        return view('Role.Guru.Course.edit', [
            'course' => $course,
        ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        //
        $vallidated = $request->validated([
            "name" => 'require|string|max:20',
            "password" => 'require|string|min:8|confirmed|'
        ]);

        $hashedPassword = Hash::make($validated['password']);

        DB::beginTransaction();

        try {
            $newCourse = course::create($validated);

            $course->updated($validated);
            
            DB.commit();

            return redirect()->route('Guru.Course.index');
        }
        catch(\Exception $e) {
            DB::rollback;
            $error = ValidateException::withMassages([
                'system_error' => ['System Error' . $e->getMassage()],
            ]);

            throw $error;

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        //
        DB::transaction(function () use ($course) {
            try {
                $course->delete();
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                throw new ModelNotFoundException('Course not found');
            } catch (\Illuminate\Database\QueryException $e) {
                throw new ValidateException([
                    'system_error' => ['Database error: ' . $e->getMessage()],
                ]);
            }
        });
    
        return redirect()->route('Guru.Course.index');
    }
}
