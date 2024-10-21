@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Products</h1>
    <a href="{{ route('products.create') }}" class="btn btn-primary">Create Product</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <input type="text" id="search" value="{{ request('search') }}" class="form-control mb-3" placeholder="Search products..." />

    <div id="products-table">
        @include('products.partials.products-table', ['products' => $products])
    </div>
</div>

@push('scripts')
<script>
  /*   document.getElementById('search').addEventListener('input', function() {
        let query = this.value;

        fetch(`/products?search=${query}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(data => {
            document.getElementById('products-table').innerHTML = data;
        });
    }); */
    $(document).ready(function() {
        $('#search').on('input', function() {
            let query = $(this).val();

            $.ajax({
                url: '/products',
                type: 'GET',
                data: { search: query },
                success: function(data) {
                    $('#products-table').html(data);
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                }
            });
        });
    });

</script>
@endpush
@endsection
