@extends('layouts.app')

@section('content')
<h3>Leads</h3>

<a href="{{ route('leads.create') }}" class="btn btn-primary mb-2">Add Lead</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Lead Name</th>
            <th>Company</th>
            <th>Status</th>
            @if(auth()->user()->role === 'super_admin')
            <th>Organization</th>
            @endif
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        @foreach($leads as $lead)
        <tr>
            <td>{{ $lead->lead_name }}</td>
            <td>{{ $lead->company }}</td>
            <td>{{ $lead->status }}</td>

            @if(auth()->user()->role === 'super_admin')
            <td>{{ $lead->organization->name }}</td>
            @endif

            <td>
                <a href="{{ route('leads.show', $lead->id) }}" class="btn btn-sm btn-info">
                    View
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection