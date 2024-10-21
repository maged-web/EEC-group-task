<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = $this->productService->getAll($request);
        return response()->json([
            'message' => 'Products retrieved successfully',
            'data' => $products,
        ], 200); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
        ]);

        $imagePath = $request->file('image')->store('images', 'public');

        $product = $this->productService->create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'image' => $imagePath,
            'price' => $validatedData['price'],
            'quantity' => $validatedData['quantity'],
        ]);

        return response()->json([
            'message' => 'Product created successfully',
            'data' => $product,
        ], 201); 
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return response()->json([
            'message' => 'Product retrieved successfully',
            'data' => $product,
        ], 200); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
        ]);
        $oldImage = $product->image; 
        
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $validatedData['image'] = $imagePath; 

            if ($oldImage) {
                $oldImagePath = public_path("storage/{$oldImage}");
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
        }

        $updatedProduct = $this->productService->update($product, $validatedData);

        return response()->json([
            'message' => 'Product updated successfully',
            'data' => $updatedProduct,
        ], 200); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $this->productService->delete($product);

        if($product->image)
        {
            Storage::disk('public')->delete($product->image);

        }

        return response()->json([
            'message' => 'Product deleted successfully',
        ], 200); 
    }
}
