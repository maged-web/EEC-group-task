<?php

namespace App\Repositories;

use App\Models\Pharmacy;

class PharmacyRepository implements PharmacyRepositoryInterface
{
    public function all()
    {
        return Pharmacy::paginate(10);
    }

    public function create(array $data)
    {
        return Pharmacy::create($data);
    }

    public function update(Pharmacy $pharmacy, array $data)
    {
        return $pharmacy->update($data);
    }

    public function delete(Pharmacy $pharmacy)
    {
        return $pharmacy->delete();
    }

    public function find($id)
    {
        return Pharmacy::findOrFail($id);
    }
}
