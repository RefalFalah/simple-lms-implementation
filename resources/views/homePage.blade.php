@extends('layouts.master')
@section('title', 'Home Page')
<div class="row mt-5">
    <div class="col-md-12">
        <img src="https://via.placeholder.com/1920x500" alt="Image" class="img-fluid">
    </div>
</div>
@section('content')
    <div class="row my-5">
        <div class="col-md-12 text-center">
            <h3>Available Courses</h3>
        </div>
    </div>

    <div class="row">
        @foreach ($lastFourData as $data)
            <div class="col-md-3 mb-4">
                <div class="card">
                    <img src="https://via.placeholder.com/400x200" alt="Image" class="img-fluid">
                    <div class="card-body">
                        <h6>{{ $data["category_name"] }}</h6>
                        <h5 class="card-title"><a href="#" class="link-underline link-underline-opacity-0">{{ $data["displayname"] }}</a></h5>
                        <p class="card-text">{{ $data["summary"] }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
