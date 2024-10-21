@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $product->title }}</h1>
    
    <div class="product-details">
        <p><strong>Description:</strong> {{ $product->description }}</p>
    </div>
    <h2>Available in the following pharmacies:</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Pharmacy Name</th>
                <th>Address</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pharmacies as $pharmacy)
                <tr>
                    <td>{{ $pharmacy->name }}</td>
                    <td>{{ $pharmacy->address }}</td>
                    <td>${{ $pharmacy->pivot->price }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('products.index') }}" class="btn btn-secondary">Back to Products List</a>
</div>
@endsection
