<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = \App\Models\Employee::with('user')->get();
        return response()->json($employees);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nip' => 'required|string|unique:employee|unique:users,nip',
            'name' => 'required|string',
            'email' => 'required|email|unique:employee',
            'photo' => 'nullable|image|max:2048',
            'number' => 'nullable|string',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,ceo'
        ]);

        $user = \App\Models\User::create([
            'nip' => $validated['nip'],
            'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('employees', 'public');
        }

        $employee = \App\Models\Employee::create([
            'nip' => $validated['nip'],
            'name' => $validated['name'],
            'email' => $validated['email'],
            'photo' => $validated['photo'] ?? null,
            'number' => $validated['number'] ?? null,
        ]);

        return response()->json($employee->load('user'), 201);
    }

    public function show(\App\Models\Employee $employee)
    {
        return response()->json($employee->load('user'));
    }

    public function update(Request $request, \App\Models\Employee $employee)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string',
            'email' => 'sometimes|email|unique:employee,email,' . $employee->id,
            'photo' => 'nullable|image|max:2048',
            'number' => 'nullable|string',
        ]);

        if ($request->hasFile('photo')) {
            if ($employee->photo) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($employee->photo);
            }
            $validated['photo'] = $request->file('photo')->store('employees', 'public');
        }

        $employee->update($validated);
        return response()->json($employee->load('user'));
    }

    public function destroy(\App\Models\Employee $employee)
    {
        $user = $employee->user;
        if ($employee->photo) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($employee->photo);
        }
        $employee->delete();
        if ($user) {
            $user->delete();
        }
        return response()->json(null, 204);
    }
}
