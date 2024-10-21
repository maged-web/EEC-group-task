<?php 
namespace   App\Services;

use App\Repositories\PharmacyRepositoryInterface;

class PharmacyService
{
    protected $pharmacyRepository;

    public function __construct(PharmacyRepositoryInterface $pharmacyRepository)
    {
        $this->pharmacyRepository = $pharmacyRepository;
    }
    public function getAll()
    {
        return $this->pharmacyRepository->all();
    }
    public function create($data)
    {
        return $this->pharmacyRepository->create($data);
    }

    public function update($pharmacy, $data)
    {
        return $this->pharmacyRepository->update($pharmacy, $data);
    }

    public function delete($pharmacy)
    {
        return $this->pharmacyRepository->delete($pharmacy);
    }

    public function find($id)
    {
        return $this->pharmacyRepository->find($id);
    }
}