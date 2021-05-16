@extends('layouts.app')

@section('header')
    @include('partials.header')
@endsection

@section('content')
    @include('partials.left-panel', ['page' => 'home'])
    <div id="middle-container">
        <div>
            <a href="" class="link-path">Board index > </a>
            <a href="" class="link-path">Nutrition > </a> 
            <span class="current-link-path">The side effects of using glutamin</span>
        </div>
    </div>
@endsection