@extends('layouts.app')

@section('content')
    <revision-register-component token="{{ @csrf_token() }}" vehicle_id="{{ $vehicle_id }}"></revision-register-component>
@endsection
