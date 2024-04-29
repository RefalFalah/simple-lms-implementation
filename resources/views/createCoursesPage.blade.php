@extends('layouts.master')
@section('title', 'Create Course')
@section('content')
@include('sweetalert::alert')
    <div class="row mt-5">
        <div class="col-md-12 mt-5 text-center">
            <h2>Form Create Course</h2>
        </div>
    </div>

    <div class="container" style="margin-bottom: 275px">
        <div class="row justify-content-center mb-5 mt-3">
          <div class="col-md-6">
            <div class="card shadow">
              <div class="card-body">
                <form action="{{ route('store-courses') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="fullname" class="form-label">Course Full Name</label>
                        <input type="text" class="form-control @error('fullname') is-invalid @enderror" id="fullname" name="fullname" autocomplete="off">
                        @error('fullname')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="shortname" class="form-label">Course Short Name</label>
                        <input type="text" class="form-control @error('shortname') is-invalid @enderror" id="shortname" name="shortname" autocomplete="off">
                        @error('shortname')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="categoryid" class="form-label">Category</label>
                        <select id="categoryid" class="form-select @error('categoryid') is-invalid @enderror" aria-label="Default select example" name="categoryid">
                            <option value="" selected disabled>Select Categorie</option>
                            @foreach ($categoriesData as $categorie)
                                <option value="{{ $categorie["id"] }}">{{ $categorie["name"] }}</option>
                            @endforeach
                        </select>
                        @error('categoryid')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="summary" class="form-label">Short Description</label>
                        <input type="text" class="form-control @error('summary') is-invalid @enderror" id="summary" name="summary" autocomplete="off">
                        @error('summary')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-dark">Submit</button>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="{{ route('home') }}" class="btn btn-danger">Back</a>
                        </div>
                    </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
@endsection
