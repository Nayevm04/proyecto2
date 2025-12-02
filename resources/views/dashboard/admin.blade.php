@extends('layouts.app')

@section('content')
    <h1>Dashboard Admin</h1>
    <p>Hola {{ auth()->user()->nombre }}.</p>
@endsection
