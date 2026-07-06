<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::with('user')->get();
        return view('admin.employees.index', compact('employees'));
    }

    public function create()
    {
        return view('admin.employees.create');
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

        $user = User::create([
            'nip' => $validated['nip'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('employees', 'public');
        }

        Employee::create([
            'nip' => $validated['nip'],
            'name' => $validated['name'],
            'email' => $validated['email'],
            'photo' => $validated['photo'] ?? null,
            'number' => $validated['number'] ?? null,
        ]);

        return redirect()->route('employees.index')->with('success', 'Karyawan berhasil ditambahkan.');
    }

    public function show(Employee $employee)
    {
        return view('admin.employees.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        return view('admin.employees.edit', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:employee,email,' . $employee->id,
            'photo' => 'nullable|image|max:2048',
            'number' => 'nullable|string',
        ]);

        if ($request->has('remove_photo') && $request->remove_photo == '1') {
            if ($employee->photo) {
                Storage::disk('public')->delete($employee->photo);
            }
            $validated['photo'] = null;
        } elseif ($request->hasFile('photo')) {
            if ($employee->photo) {
                Storage::disk('public')->delete($employee->photo);
            }
            $validated['photo'] = $request->file('photo')->store('employees', 'public');
        }

        $employee->update($validated);

        return redirect()->route('employees.index')->with('success', 'Karyawan berhasil diperbarui.');
    }

    public function destroy(Employee $employee)
    {
        $user = $employee->user;
        if ($employee->photo) {
            Storage::disk('public')->delete($employee->photo);
        }
        $employee->delete();
        if ($user) {
            $user->delete();
        }

        return redirect()->route('employees.index')->with('success', 'Karyawan berhasil dihapus.');
    }
}
