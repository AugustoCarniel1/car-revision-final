@extends('layouts.app')

@section('content')
    <car-register-component token="{{ @csrf_token() }}" owner_id="{{ $owner_id }}"></car-register-component>
@endsection
