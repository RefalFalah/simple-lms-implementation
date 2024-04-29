@extends('layouts.master')
@section('title', 'List All Courses')
@section('content')
    <div class="row mt-5">
        <div class="col-md-12 mt-5 text-center">
            <h2>List All Courses</h2>
        </div>
    </div>

    <div class="container justify-content-center mt-3 data-all">
        <div class="row">
            <div class="col-md-6 mb-4">
                <select id="categoryFilter" class="form-select" aria-label="Default select example">
                    <option value="allCategories" selected>All Categories</option>
                    @foreach ($categories as $categorie)
                        <option value="{{ $categorie }}">{{ $categorie }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mb-4">
                <form class="d-flex" role="search">
                    <input id="searchInput" class="form-control me-2" type="search" placeholder="Search" aria-label="Search" autocomplete="off">
                </form>
            </div>
        </div>

        <div id="courseList">
            @foreach ($paginatedData as $data)
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card shadow">
                            <div class="row">
                                <div class="col-md-4">
                                    <img src="https://via.placeholder.com/400x200" alt="Image" class="img-fluid">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h6>{{ $data["category_name"] }}</h6>
                                        <h5 class="card-title"><a href="#" class="link-underline link-underline-opacity-0">{{ $data["displayname"] }}</a></h5>
                                        <p class="card-text">{{ $data["summary"] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="row">
                <div class="col-md-12">
                    {{ $paginatedData->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection
{{-- Custom JS --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('categoryFilter').addEventListener('change', function() {
            var category = this.value;
            // Jika pengguna memilih "All Categories", kembalikan semua data tanpa filter (Load aja biar cepet wkwkw buru-buru)
            if (category === 'allCategories') {
                window.location.reload();
            } else {
                // Jika pengguna memilih kategori tertentu, kirim permintaan AJAX untuk filter
                fetch('/filter-by-category?category=' + encodeURIComponent(category))
                    .then(response => response.json())
                    .then(data => {
                        updateCourseList(data);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }
        });

        const searchInput = document.getElementById('searchInput');

        searchInput.addEventListener('input', function() {
            const keyword = this.value.trim();

            // Jika keyword kosong, tampilkan semua kursus
            if (keyword !== '') {
                searchCourses(keyword);
            } else {
                window.location.reload();
            }
        });
    });

    function updateCourseList(data) {
        // Menghapus konten yang ada sebelumnya
        document.getElementById('courseList').innerHTML = '';

        var card = '';

        if (data.length !== 0) {
            // Memperbarui isi konten dengan data yang diterima
            data.forEach(course => {
                card = `
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card shadow">
                                <div class="row">
                                    <div class="col-md-4">
                                        <img src="https://via.placeholder.com/400x200" alt="Image" class="img-fluid">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h6>${course.category_name}</h6>
                                            <h5 class="card-title"><a href="#" class="link-underline link-underline-opacity-0">${course.displayname}</a></h5>
                                            <p class="card-text">${course.summary}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                document.getElementById('courseList').insertAdjacentHTML('beforeend', card);
            });
        } else {
            card = `
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card shadow">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card-body">
                                        <h6 class="text-center">Data not found</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            document.getElementById('courseList').insertAdjacentHTML('beforeend', card);
        }

        var marginBottom = '';
        if (data.length === 0) {
            marginBottom = '553';
        } else if (data.length === 1) {
            marginBottom = '415px';
        } else if (data.length === 2) {
            marginBottom = '187px';
        }

        // Mengatur margin-bottom untuk div dengan class 'data-all'
        document.querySelector('.data-all').style.marginBottom = marginBottom;
    }

    function searchCourses(keyword) {
        fetch('/search-courses?keyword=' + encodeURIComponent(keyword))
            .then(response => response.json())
            .then(data => {
                updateCourseList(data);
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
</script>
