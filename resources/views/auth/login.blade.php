@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-4">
        <h4>Login</h4>

        <form method="POST" action="{{ route('login.post') }}">
            @csrf

            <div class="mb-3">
                <label>Email</label>
                <input class="form-control" name="email">
            </div>

            <div class="mb-3">
                <label>Password</label>
                <input type="password" class="form-control" name="password">
            </div>

            <button class="btn btn-primary w-100">Login</button>
        </form>
    </div>
</div>
@endsection