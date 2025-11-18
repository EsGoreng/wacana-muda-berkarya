@extends('layouts.app')

@section('title', $title)

@section('content')
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ $title }}
    </h2>
@endsection