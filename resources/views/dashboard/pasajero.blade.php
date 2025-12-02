@extends('layouts.app')

@section('content')
    <h1>Dashboard Pasajero</h1>
    <p>Hola {{ auth()->user()->nombre }}.</p>

    <p>Aquí verás tus viajes, historial y más.</p>
@endsection
