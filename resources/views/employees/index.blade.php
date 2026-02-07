@extends('layouts.app')

@section('content')
<h3>Employees</h3>
<a href="{{ route('employees.create') }}" class="btn btn-primary mb-3">Add Employee</a>

<table class="table table-bordered">
    <tr>
        <th>Name</th>
        <th>Designation</th>
        <th>Phone</th>
        <th>Action</th>
    </tr>
    @foreach($employees as $emp)
    <tr>
        <td>{{ $emp->name }}</td>
        <td>{{ $emp->designation }}</td>
        <td>{{ $emp->phone }}</td>
        <td><a href="{{ route('employees.show',$emp) }}" class="btn btn-sm btn-info">View</a></td>
    </tr>
    @endforeach
</table>
@endsection