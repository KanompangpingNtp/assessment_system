@extends('layout.users_layout')
@section('user_layout')

<div class="d-flex justify-content-center align-items-center">
    <div class="col-md-4">
        <h3 class="text-center">ล็อคอินสำหรับแอดมิน</h3>
        <br>
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Username</label>
                <input type="text" class="form-control" id="name" name="name" required>
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <br>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
                @error('password')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <br>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>
</div>


@endsection
