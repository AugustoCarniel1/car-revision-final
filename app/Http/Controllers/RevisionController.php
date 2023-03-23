<?php

namespace App\Http\Controllers;

use App\Models\CarBrand;
use App\Models\Revision;
use App\Models\Vehicle;
use \Datetime;
use DateTimeZone;
use Illuminate\Http\Request;

class RevisionController extends Controller
{
    public function by_vehicle( Request $request, $vehicle_id) {

        $revisions = Revision::where('vehicle_id', $vehicle_id)->orderBy('revision_date', 'desc')->get();

        $next_date = '';

        $average = '';
        
        if (count($revisions) > 1){

            $total_time = 0;
            
            // Get the total difference between times
            for($count = count($revisions), $total_time = 0, $i = 1; $i < $count; $i++){
                $total_time += strtotime($revisions[$i-1]->revision_date) - strtotime($revisions[$i]->revision_date);
            };

            $seconds  = floor($total_time/(count($revisions)-1));

            // Generate two dates to get the difference
            $DTF = new DateTime("@0");
            $DTT = new DateTime("@$seconds");

            date_timezone_set($DTF, new DateTimeZone('America/Sao_Paulo'));
            date_timezone_set($DTT, new DateTimeZone('America/Sao_Paulo'));

            $average = $DTF->diff($DTT);

            // Get last date of register
            $last_date = new DateTime($revisions[0]->revision_date);

            date_timezone_set($last_date, new DateTimeZone('America/Sao_Paulo'));
            
            // Generate next revision date
            $next_date = date_add($last_date, $average);

            $average = $average->format('%a dias e %h horas e %i minutos');
        
        }

        $vehicle = Vehicle::where('id', $vehicle_id)->first();

        $brand = CarBrand::where('id', $vehicle->brand_id)->first();

        return response()->json([$vehicle, $brand, $revisions, $next_date , $average], 200);

    }

    public function get_info ( Request $request ){

        // Get all revisions with necessary infos
        $revisions = \DB::select(
            'select 
                r.revision_date, 
                r.description,
                v.model,
                cb.description as brand,
                o.name
            from revisions r
                inner join vehicles v on v.id = r.vehicle_id
                inner join car_brands cb on cb.id = v.brand_id
                inner join owners o on o.id = v.owner_id'
        );

        // Get all revision grouped by top brands
        $revisions_brand = \DB::select(
            "select 
                count(inq.id) as counted, 
                inq.description 
            from (
                select 
                    r.id, 
                    r.description as rdescription, 
                    cb.description 
                from revisions r 
                    inner join vehicles v on v.id = r.vehicle_id
                    inner join car_brands cb on v.brand_id = cb.id
                    left join (
                        select 
                            count(id) as counted, 
                            brand_id from vehicles
                        group by brand_id 
                        order by counted desc
                    ) iq on iq.brand_id = v.brand_id) inq 
            group by inq.description order by counted desc LIMIT 5;"
        );

        // Get all revision grouped by top users
        $revisions_people = \DB::select(
            "select 
                count(inq.r_id) as counted, 
                inq.name 
            from (
                select 
                    r.id as r_id, 
                    r.description as rdescription, 
                    o.id as o_id, 
                    o.name 
                from revisions r 
                    inner join vehicles v on v.id = r.vehicle_id
                    inner join car_brands cb on v.brand_id = cb.id
                    inner join owners o on o.id = v.owner_id
            ) inq group by inq.name order by counted desc LIMIT 5;"
        );


        return response()->json([$revisions, $revisions_brand, $revisions_people], 200);
    }

    public function register( Request $request){

        $revision = new Revision();

        $revision->description = $request->description;
        $revision->revision_date = date("Y-m-d H:i:s");

        // Disable created_at and updated_at because i dont use them
        $revision->timestamps = false;

        $revision->vehicle_id = $request->vehicle;

        $revision->save();

        return response()->json($revision, 201);
        
    }
}
