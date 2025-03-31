<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CourseController extends Controller
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'http://localhost:8080/', 
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response = $this->client->get('courses');
        $courses = json_decode($response->getBody()->getContents(), true)['data'];
        return view('Role.Guru.Course.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Role.Guru.Course.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "nama_course" => 'required|string|max:20|unique:courses',
            "password" => 'required|string|min:8|confirmed',
            "user_id" => 'required|exists:users,id',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $response = $this->client->post('courses', [
            'json' => $validated
        ]);

        return redirect()->route('Guru.Course.index')->with('success', 'Course created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $response = $this->client->get("courses/{$id}");
        $course = json_decode($response->getBody()->getContents(), true)['data'];
        return view('Role.Guru.Course.show', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $response = $this->client->get("courses/{$id}");
        $course = json_decode($response->getBody()->getContents(), true)['data'];
        return view('Role.Guru.Course.edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            "nama_course" => 'required|string|max:20|unique:courses,nama_course,' . $id,
            "password" => 'nullable|string|min:8|confirmed',
            "user_id" => 'required|exists:users,id',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $response = $this->client->put("courses/{$id}", [
            'json' => $validated
        ]);

        return redirect()->route('Guru.Course.index')->with('success', 'Course updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = $this->client->delete("courses/{$id}");
        return redirect()->route('Guru.Course.index')->with('success', 'Course deleted successfully.');
    }
}