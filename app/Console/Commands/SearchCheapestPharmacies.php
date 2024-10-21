<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class SearchCheapestPharmacies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:search-cheapest {productId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Return the cheapest 5 pharmacies for a given product ID';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $productId=$this->argument('productId');

        $product =Product::with(['pharmacies' => function($query)
        {
            $query->select('pharmacies.id', 'pharmacies.name', 'product_pharmacy.price')
            ->orderBy('product_pharmacy.price', 'asc')
            ->take(5);
        
        }])->find($productId);

        if(!$product)
        {
            $this->error("Product with ID {$productId} not found.");
            return;
        }
        $pharmacies = $product->pharmacies->map(function ($pharmacy) {
            return [
                'id' => $pharmacy->id,
                'name' => $pharmacy->name,
                'price' => $pharmacy->pivot->price, 
            ];
        });
        $this->info($pharmacies->toJson());
    }
}
