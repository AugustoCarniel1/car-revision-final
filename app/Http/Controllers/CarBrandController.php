<?php

namespace App\Http\Controllers;

use App\Models\CarBrand;
use Illuminate\Http\Request;

class CarBrandController extends Controller
{
    public function index( Request $request )
    {
        $brands = CarBrand::all();

        return response()->json($brands);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(CarBrand $carBrand)
    {
        //
    }

    public function edit(CarBrand $carBrand)
    {
        //
    }

    public function update(Request $request, CarBrand $carBrand)
    {
        //
    }

    public function destroy(CarBrand $carBrand)
    {
        //
    }
}
