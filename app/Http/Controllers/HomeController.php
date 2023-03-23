<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Owner;

class HomeController extends Controller
{
    public function index() {

        return view('home');
    }

    public function index_cars() {

        return view('cars');
    }

    public function index_revisions() {

        return view('revisions');
    }

    public function index_car($owner_id) {
        
        return view('car-register', ['owner_id' => $owner_id]);
    }

    public function index_revision($vehicle_id) {
        
        return view('revision-register', ['vehicle_id' => $vehicle_id]);
    }
}
