<?php 
namespace App\Repositories;

use App\Models\Pharmacy;
use Illuminate\Http\Request;

interface PharmacyRepositoryInterface
{
    public function all();
    public function create(array $data);
    public function update(Pharmacy $pharmacy, array $data);
    public function delete(Pharmacy $pharmacy);
    public function find($id);
}