@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Pharmacy</h1>

    <form action="{{ route('pharmacies.update', $pharmacy->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Title</label>
            <input type="text" class="form-control" value="{{ $pharmacy->name }}" name="name" required>
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" class="form-control" value="{{ $pharmacy->address }}" name="address" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Pharmacy</button>
    </form>
</div>
@endsection
