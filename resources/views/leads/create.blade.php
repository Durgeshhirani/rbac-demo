@extends('layouts.app')

@section('content')
<h3>Create Lead</h3>

<form method="POST" action="{{ route('leads.store') }}">
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

    <input class="form-control mb-2" name="lead_name" placeholder="Lead Name" required>
    <input class="form-control mb-2" name="company" placeholder="Company" required>
    <input class="form-control mb-2" name="phone" placeholder="Phone" required>

    <select name="status" class="form-control mb-2" required>
        <option value="">-- Status --</option>
        <option value="new">New</option>
        <option value="contacted">Contacted</option>
        <option value="qualified">Qualified</option>
    </select>

    <button class="btn btn-success">Save</button>
</form>
@endsection