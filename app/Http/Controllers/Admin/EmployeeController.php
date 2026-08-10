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
    public function index(Request $request)
    {
        $query = Employee::with(['user', 'position']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('position_id')) {
            $query->where('position_id', $request->position_id);
        }

        $employees = $query->orderBy('name', 'asc')->get();
        $positions = \App\Models\Position::orderBy('name', 'asc')->get();

        return view('admin.employees.index', compact('employees', 'positions'));
    }

    public function create()
    {
        $positions = \App\Models\Position::orderBy('name', 'asc')->get();
        return view('admin.employees.create', compact('positions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nip' => 'required|string|unique:employee|unique:users,nip',
            'name' => 'required|string',
            'email' => 'required|email|unique:employee',
            'position_id' => 'nullable|exists:positions,id',
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
            'position_id' => $validated['position_id'] ?? null,
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
        $positions = \App\Models\Position::orderBy('name', 'asc')->get();
        return view('admin.employees.edit', compact('employee', 'positions'));
    }

    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:employee,email,' . $employee->id,
            'position_id' => 'nullable|exists:positions,id',
            'role' => 'nullable|in:admin,ceo',
            'number' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($request->filled('role') && $employee->user) {
            $employee->user->update(['role' => $request->role]);
        }

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

        $employee->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'position_id' => $validated['position_id'] ?? null,
            'number' => $validated['number'] ?? null,
            'photo' => array_key_exists('photo', $validated) ? $validated['photo'] : $employee->photo,
        ]);

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
