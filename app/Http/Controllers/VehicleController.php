<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Owner;
use App\Models\CarBrand;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function by_owner( Request $request, $owner_id=0 ){
        
        $vehicles = \DB::select('select cb.description, v.id, v.model, v.color, v.license_plate from vehicles v
        join car_brands cb on cb.id = v.brand_id where v.owner_id = ?', [$owner_id]);

        $owner = Owner::where('id', $owner_id)->first();
        
        return response()->json([$owner, $vehicles], 200);
    }

    public function count_info ( Request $request ){

        $female_count = \DB::select("select count(v.id) from vehicles v
        join owners o on o.id = v.owner_id
        join car_brands cb on cb.id = v.brand_id 
        where o.gender = 'Female'");


        return response()->json($female_count, 200);
    }

    public function list( Request $request, $filter='none', $gender='all' ){

        if($filter == 'none' || ($filter == 'brand' && $gender == 'all')){
            $vehicles = \DB::select('select cb.description, v.model, v.color, v.license_plate, o.name, o.gender from vehicles v
            join owners o on o.id = v.owner_id
            join car_brands cb on cb.id = v.brand_id');
        } elseif ($filter == 'person'){
            $vehicles = \DB::select('select cb.description, v.model, v.color, v.license_plate, o.gender, o.name from vehicles v
            join owners o on o.id = v.owner_id
            join car_brands cb on cb.id = v.brand_id 
            order by o.name');
        } elseif ($filter == 'car') {
            $vehicles = \DB::select('select cb.description, v.model, v.color, v.license_plate, o.gender, o.name from vehicles v
            join owners o on o.id = v.owner_id
            join car_brands cb on cb.id = v.brand_id
            left join (
                select count(id) as counted, brand_id from vehicles
                group by brand_id order by counted desc
            ) iq on iq.brand_id = v.brand_id 
            order by iq.counted desc');
        } else {
            if ($gender == 'male') {
                $vehicles = \DB::select("select cb.description, v.model, v.color, v.license_plate, o.name, o.gender from vehicles v
                join owners o on o.id = v.owner_id
                join car_brands cb on cb.id = v.brand_id where o.gender = 'Male'");
            } else {
                $vehicles = \DB::select("select cb.description, v.model, v.color, v.license_plate, o.name, o.gender from vehicles v
                join owners o on o.id = v.owner_id
                join car_brands cb on cb.id = v.brand_id where o.gender = 'Female'");
            }
        }

        


        return response()->json($vehicles, 200);

    }
    
    public function register(Request $request){
        
        $brand = CarBrand::where('description', $request->brand)->first();

        $vehicle = new Vehicle();

        $vehicle->model = $request->model;
        $vehicle->color = $request->color;
        $vehicle->license_plate = $request->license_plate;

        $vehicle->owner_id = $request->owner;
        $vehicle->brand_id = $brand->id;

        $vehicle->save();

        return response()->json($vehicle, 201);
    }
}
