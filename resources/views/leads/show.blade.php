@extends('layouts.app')

@section('content')
<h3>Lead Details</h3>

<table class="table table-bordered">
    <tr>
        <th>Lead Name</th>
        <td>{{ $lead->lead_name }}</td>
    </tr>
    <tr>
        <th>Company</th>
        <td>{{ $lead->company }}</td>
    </tr>
    <tr>
        <th>Phone</th>
        <td>{{ $lead->phone }}</td>
    </tr>
    <tr>
        <th>Status</th>
        <td>{{ ucfirst($lead->status) }}</td>
    </tr>

    @if(auth()->user()->role === 'super_admin')
    <tr>
        <th>Organization</th>
        <td>{{ $lead->organization->name }}</td>
    </tr>
    @endif
</table>

<a href="{{ route('leads.index') }}" class="btn btn-secondary">Back</a>
@endsection