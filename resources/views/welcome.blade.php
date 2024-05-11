@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="text-center fw-bold text-primary">TW Group</h1>
            <h3 class="text-center text-decoration-underline">Prueba técnica</h3>
            <div class="d-flex justify-content-center">
                <img class="w-75" src="{{ asset('images/test.png') }}" alt="{{ 'Imagen para la portada' }}"/>
            </div>
        </div>
    </div>
 @endsection