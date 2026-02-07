<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\Organization;

class EmployeeController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $employees = $user->role === 'super_admin'
            ? Employee::with('organization')->get()
            : Employee::where('org_id', $user->org_id)->get();

        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        $user = auth()->user();
        $orgs = $user->role === 'super_admin'
            ? Organization::all()
            : null;
        return view('employees.create', compact('orgs'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        $rules = [
            'name'        => 'required|string',
            'designation' => 'required|string',
            'phone'       => 'required|string',
        ];

        // super_admin must choose org
        if ($user->role === 'super_admin') {
            $rules['org_id'] = 'required|exists:organizations,id';
        }

        $data = $request->validate($rules);

        // org users → force their org
        if ($user->role !== 'super_admin') {
            $data['org_id'] = $user->org_id;
        }

        Employee::create($data);

        return redirect()
            ->route('employees.index')
            ->with('success', 'Employee created successfully');
    }

    public function show(Employee $employee)
    {
        $this->authorizeOrg($employee);
        $employee->load('organization');
        return view('employees.show', compact('employee'));
    }

    private function authorizeOrg(Employee $employee)
    {
        $user = auth()->user();

        if ($user->role !== 'super_admin' && $employee->org_id !== $user->org_id) {
            abort(403);
        }
    }
}
