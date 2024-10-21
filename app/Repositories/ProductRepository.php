<?php 
namespace App\Repositories;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductRepository implements ProductRepositoryInterface
{
    public function all(Request $request)
    {
        $search=$request->input('search');
        return Product::query()->when($search,function($query, $search)
        {
            $query->where('title', 'like', "%{$search}%")
            ->orWhere('description', 'like', "%{$search}%");
        })->paginate(10);
    }
    public function create(array $data)
    {
        return Product::create($data);
    }

    public function update(Product $product, array $data)
    {
        return $product->update($data);
    }

    public function delete(Product $product)
    {
        return $product->delete();
    }

    public function find($id)
    {
        return Product::findOrFail($id);
    }
}