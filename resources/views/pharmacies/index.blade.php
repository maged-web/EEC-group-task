@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Pharmacies</h1>
    <a href="{{ route('pharmacies.create') }}" class="btn btn-primary">Create Pharmacy</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Address</th>
                
            </tr>
        </thead>
        <tbody>
            @foreach($pharmacies as $pharmacy)
                <tr>
                    <td>{{ $pharmacy->id }}</td>
                    <td>{{ $pharmacy->name }}</td>
                    <td>{{ $pharmacy->address }}</td>
                    <td>
                        <a href="{{ route('pharmacies.edit', $pharmacy->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('pharmacies.destroy', $pharmacy->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{$pharmacies->links()}}
</div>

@endsection
