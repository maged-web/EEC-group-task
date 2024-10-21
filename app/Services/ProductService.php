<?php
namespace App\Services;

use App\Repositories\ProductRepositoryInterface;

class ProductService
{
    protected $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getAll($request)
    {
        return $this->productRepository->all($request);
    }

    public function create($data)
    {
        return $this->productRepository->create($data);
    }

    public function update($product, $data)
    {
        return $this->productRepository->update($product, $data);
    }

    public function delete($product)
    {
        return $this->productRepository->delete($product);
    }

    public function find($id)
    {
        return $this->productRepository->find($id);
    }
}