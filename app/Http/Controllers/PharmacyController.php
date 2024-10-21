<?php

namespace App\Http\Controllers;

use App\Models\Pharmacy;
use App\Services\PharmacyService;
use Illuminate\Http\Request;

class PharmacyController extends Controller
{
    protected $pharmacyService;
    public function __construct(PharmacyService $pharmacyService)
    {
        $this->pharmacyService=$pharmacyService;

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pharmacies=$this->pharmacyService->getAll();
        return view('pharmacies.index',compact('pharmacies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('pharmacies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|string|max:255',
            'address'=>'required|string'
        ]);
        $this->pharmacyService->create($request->all());
        return redirect()->route('pharmacies.index')->with('success', 'Pharmacy created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pharmacy $pharmacy)
    {
        return view('pharmacies.show', compact('pharmacy'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pharmacy $pharmacy)
    {
        return view('pharmacies.edit', compact('pharmacy'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Pharmacy $pharmacy, Request $request)
    {
        $request->validate([
            'name'=>'required|string|max:255',
            'address'=>'required|string'
        ]);
        $this->pharmacyService->update($pharmacy, $request->all());
        return redirect()->route('pharmacies.index')->with('success', 'Pharmacy updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pharmacy $pharmacy)
    {
        $this->pharmacyService->delete($pharmacy);
        return redirect()->route('pharmacies.index')->with('success', 'Pharmacy deleted successfully.');

        //
    }
}
