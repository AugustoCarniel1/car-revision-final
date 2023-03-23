@extends('layouts.app')

@section('content')
    <user-register-component token="{{ @csrf_token() }}"></user-register-component>
@endsection
