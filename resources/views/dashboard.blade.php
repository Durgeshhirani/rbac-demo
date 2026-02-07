@extends('layouts.app')

@section('content')
<h3>Dashboard</h3>

<p><b>Role:</b> {{ auth()->user()->role }}</p>
<p><b>Organization:</b> {{ auth()->user()->org_id ?? 'Platform Level' }}</p>

<div class="mt-4">
    @if(in_array(auth()->user()->role, ['org_hr','org_admin','super_admin']))
    <a href="/employees" class="btn btn-success">Employee Module</a>
    @endif

    @if(in_array(auth()->user()->role, ['org_sales','org_admin','super_admin']))
    <a href="/leads" class="btn btn-warning">Leads / CRM Module</a>
    @endif
</div>
@endsection