@extends('layouts.app')

@section('content')
<h3>Create Employee</h3>

<form method="POST" action="{{ route('employees.store') }}">
    @csrf

    @if(auth()->user()->role === 'super_admin')
    <div class="mb-2">
        <label class="form-label">Organization</label>
        <select name="org_id" class="form-control" required>
            <option value="">-- Select Organization --</option>
            @foreach($orgs as $org)
            <option value="{{ $org->id }}">{{ $org->name }}</option>
            @endforeach
        </select>
    </div>
    @endif

    <input class="form-control mb-2" name="name" placeholder="Name" required>
    <input class="form-control mb-2" name="designation" placeholder="Designation" required>
    <input class="form-control mb-2" name="phone" placeholder="Phone" required>

    <button class="btn btn-success">Save</button>
</form>
@endsection