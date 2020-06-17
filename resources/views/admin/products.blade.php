@extends('layouts.admin')

@section('content')
    <h1>Hey im a {{ Request::segment(2) }}</h1>
@endsection