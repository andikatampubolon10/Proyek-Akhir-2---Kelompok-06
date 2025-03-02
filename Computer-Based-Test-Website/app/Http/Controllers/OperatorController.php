<?php

namespace App\Http\Controllers;

use App\Models\Operator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class OperatorController extends Controller
{
    public function index()
    {
        $operators = Operator::all();
        return view('admin.listOperator', compact('operators'));
    }

    public function create()
    {
        return view('admin.createOperator');
    }

    public function store(Request $request)
    {
        $request->validate([
            'sekolah' => 'required|string|max:255',
            'username' => 'required|string|unique:operators,username',
            'password' => 'required|string|min:8|confirmed',
            'duration' => 'required|integer|min:12',
        ]);

        $duration = (int) $request->duration;
        $expiryDate = Carbon::now()->addYears($duration);

        Operator::create([
            'sekolah' => $request->sekolah,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'duration' => $duration,
            'expiry_date' => $expiryDate,
            'status' => 'aktif',
        ]);

        return redirect()->route('admin.listOperator')->with('success', 'Operator created successfully!');
    }
    public function edit($id)
    {
        $operator = Operator::findOrFail($id);
        return view('admin.editOperator', compact('operator'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'sekolah' => 'required|string|max:255',
            'username' => 'required|string|unique:operators,username,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'duration' => 'required|integer|min:12',
        ]);

        $duration = (int) $request->duration;
        $expiryDate = Carbon::now()->addYears($duration);

        $operator = Operator::findOrFail($id);

        $operator->sekolah = $request->sekolah;
        $operator->username = $request->username;

        if ($request->password) {
            $operator->password = Hash::make($request->password);
        }

        $operator->duration = $duration;
        $operator->expiry_date = $expiryDate;

        $operator->save();

        return redirect()->route('admin.listOperator')->with('success', 'Operator updated successfully!');
    }
    public function destroy($id)
    {
        $operator = Operator::findOrFail($id);
        $operator->delete();
    
        return response()->json(['success' => true], 200);
    }
    
}
