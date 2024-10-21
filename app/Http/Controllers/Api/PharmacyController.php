<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pharmacy;
use App\Services\PharmacyService;
use Illuminate\Http\Request;

class PharmacyController extends Controller
{
    protected $pharmacyService;

    public function __construct(PharmacyService $pharmacyService)
    {
        $this->pharmacyService = $pharmacyService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index() 
    {
        $pharmacies = $this->pharmacyService->getAll();
        return response()->json([
            'message' => 'Pharmacies retrieved successfully',
            'data' => $pharmacies,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
        ]);

        $pharmacy = $this->pharmacyService->create($validatedData);

        return response()->json([
            'message' => 'Pharmacy created successfully',
            'data' => $pharmacy,
        ], 201); 
    }

    /**
     * Display the specified resource.
     */
    public function show(Pharmacy $pharmacy)
    {
        return response()->json([
            'message' => 'Pharmacy retrieved successfully',
            'data' => $pharmacy,
        ], 200); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pharmacy $pharmacy)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
        ]);

        $updatedPharmacy = $this->pharmacyService->update($pharmacy, $validatedData);

        return response()->json([
            'message' => 'Pharmacy updated successfully',
            'data' => $updatedPharmacy,
        ], 200); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pharmacy $pharmacy)
    {
        $this->pharmacyService->delete($pharmacy);
        return response()->json([
            'message' => 'Pharmacy deleted successfully',
        ], 200); 
    }
}
