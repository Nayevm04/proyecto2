@extends('layouts.app')

@section('content')
    <h1>Dashboard Superadmin</h1>
    <p>Bienvenido {{ auth()->user()->nombre }}.</p>
@endsection
