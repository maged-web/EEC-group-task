<?php 
namespace App\Repositories;

use App\Models\Product;
use Illuminate\Http\Request;

interface ProductRepositoryInterface
{
    public function all(Request $request);
    public function create(array $data);
    public function update(Product $product, array $data);
    public function delete(Product $product);
    public function find($id);
}