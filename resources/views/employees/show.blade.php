@extends('layouts.app')

@section('content')
<h3>Employee Details</h3>

<table class="table table-bordered">
    <tr>
        <th>Name</th>
        <td>{{ $employee->name }}</td>
    </tr>
    <tr>
        <th>Designation</th>
        <td>{{ $employee->designation }}</td>
    </tr>
    <tr>
        <th>Phone</th>
        <td>{{ $employee->phone }}</td>
    </tr>

    @if(auth()->user()->role === 'super_admin')
    <tr>
        <th>Organization</th>
        <td>{{ $employee->organization->name }}</td>
    </tr>
    @endif
</table>

<a href="{{ route('employees.index') }}" class="btn btn-secondary">Back</a>
@endsection