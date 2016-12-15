@extends('argon::layout.master')

@section('body-class', 'dashboard media media-all')

@section('content')

    <div class="main">
        <h1 class="page-header">Media :: Folders</h1>

        @if (session('message'))
            <div class="alert alert-success" role="alert">
                {{ session('message') }}
            </div>
        @endif

        <div class="actions-top">

            <a href="{{ route("cms:media:upload") }}" class="btn btn-primary btn-upload">Upload</a>
            <a href="{{ route("cms:media:all") }}" class="btn btn-primary-outline">Back to All</a>

            <form action="{{ route("cms:media:search") }}" method="get" class="form-inline">
                <input type="text" name="keywords" value="" class="form-control">
                <button type="submit" class="btn btn-primary-outline">Search</button>
            </form>

        </div>


    </div>

@stop

@section('styles')
@stop

@section('footer')
@stop
