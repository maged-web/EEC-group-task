<?php

namespace App\Http\Controllers;

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
        //$search = $request->input('search');
        
        if ($request->ajax()) {
            return view('products.partials.products-table', compact('products'))->render();
        }
    

        return view('products.index', compact('products' /* 'search' */));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
        ]);

        $imagePath = $request->file('image')->store('images', 'public');

        $this->productService->create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imagePath,
            'price' => $request->price,
            'quantity' => $request->quantity,
        ]);
        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
      $pharmacies = $product->pharmacies; 
      return view('products.show', compact('product', 'pharmacies'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
        ]);
    
        $data = $request->all();
        $oldImage = $product->image; 
    
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $data['image'] = $imagePath; 
    
            if ($oldImage) {
                $oldImagePath = public_path("storage/{$oldImage}");
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
        }
            $this->productService->update($product, $data);
    
        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
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
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
