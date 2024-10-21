@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Pharmacy</h1>

    <form action="{{ route('pharmacies.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Title</label>
            <input type="text" class="form-control" name="name" required>
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">address</label>
            <input type="text" class="form-control"  name="address" required>
        </div>

        <button type="submit" class="btn btn-primary">Create Pharmacy</button>
    </form>
</div>
@endsection
