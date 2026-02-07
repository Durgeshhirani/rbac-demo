<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Organization;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $leads = $user->role === 'super_admin'
            ? Lead::with('organization')->get()
            : Lead::where('org_id', $user->org_id)->get();

        return view('leads.index', compact('leads'));
    }

    public function create()
    {
        $user = auth()->user();

        // super_admin must choose org
        $orgs = $user->role === 'super_admin'
            ? Organization::all()
            : null;

        return view('leads.create', compact('orgs'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        $rules = [
            'lead_name' => 'required|string',
            'company'   => 'required|string',
            'phone'     => 'required|string',
            'status'    => 'required|string',
        ];

        // super_admin must explicitly choose org
        if ($user->role === 'super_admin') {
            $rules['org_id'] = 'required|exists:organizations,id';
        }

        $data = $request->validate($rules);

        // org-level users → force org_id
        if ($user->role !== 'super_admin') {
            $data['org_id'] = $user->org_id;
        }

        Lead::create($data);

        return redirect()
            ->route('leads.index')
            ->with('success', 'Lead created successfully');
    }

    public function show(Lead $lead)
    {
        $user = auth()->user();

        // org isolation
        if ($user->role !== 'super_admin' && $lead->org_id !== $user->org_id) {
            abort(403);
        }

        return view('leads.show', compact('lead'));
    }
}
