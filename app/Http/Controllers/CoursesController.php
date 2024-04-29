<?php

namespace App\Http\Controllers;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Pagination\LengthAwarePaginator;

class CoursesController extends Controller
{
    public function allCourses() {
        try {
            // Mendapatkan data kursus dari API
            $response = Http::get('https://demo.diklat.id/lms/webservice/rest/server.php', [
                'wstoken' => 'd203af738612dd97b1e248bfb229ddab',
                'moodlewsrestformat' => 'json',
                'wsfunction' => 'core_course_get_courses',
            ]);

            $data = $response->json();

            // Mendapatkan daftar kategori
            $categoriesResponse = Http::get('https://demo.diklat.id/lms/webservice/rest/server.php', [
                'wstoken' => 'd203af738612dd97b1e248bfb229ddab',
                'moodlewsrestformat' => 'json',
                'wsfunction' => 'core_course_get_categories',
            ]);

            $categoriesData = $categoriesResponse->json();

            // Mengonversi daftar kategori menjadi associative array dengan id sebagai key dan nama sebagai value
            $categories = [];
            foreach ($categoriesData as $category) {
                $categories[$category['id']] = $category['name'];
            }

            // Mengubah ID kategori menjadi nama kategori dalam data kursus
            foreach ($data as &$course) {
                $categoryId = $course['categoryid'];
                if (isset($categories[$categoryId])) {
                    $course['category_name'] = $categories[$categoryId];
                } else {
                    $course['category_name'] = 'Unknown'; // Jika ID kategori tidak ditemukan
                }
            }

            $data = array_reverse($data);

            // Memecah data menjadi halaman-halaman dengan 3 data per halaman
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $perPage = 3;
            $currentItems = array_slice($data, ($currentPage - 1) * $perPage, $perPage);
            $paginatedData = new LengthAwarePaginator($currentItems, count($data), $perPage, $currentPage, [
                'path' => LengthAwarePaginator::resolveCurrentPath(), // Menggunakan path yang benar untuk link pagination
            ]);

            return view('listCoursesPage', compact('paginatedData', 'categories'));
        } catch (Throwable $th) {
            return response()->json([
                'message' => 'Error',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function filterByCategory(Request $request) {
        try {
            $inputCategory = $request->input('category');

            // Mendapatkan data kursus dari API
            $response = Http::get('https://demo.diklat.id/lms/webservice/rest/server.php', [
                'wstoken' => 'd203af738612dd97b1e248bfb229ddab',
                'moodlewsrestformat' => 'json',
                'wsfunction' => 'core_course_get_courses',
            ]);

            $data = $response->json();

            // Mendapatkan daftar kategori
            $categoriesResponse = Http::get('https://demo.diklat.id/lms/webservice/rest/server.php', [
                'wstoken' => 'd203af738612dd97b1e248bfb229ddab',
                'moodlewsrestformat' => 'json',
                'wsfunction' => 'core_course_get_categories',
            ]);

            $categoriesData = $categoriesResponse->json();

            // Mengonversi daftar kategori menjadi associative array dengan id sebagai key dan nama sebagai value
            $categories = [];
            foreach ($categoriesData as $category) {
                $categories[$category['id']] = $category['name'];
            }

            // Mengubah ID kategori menjadi nama kategori dalam data kursus
            foreach ($data as &$course) {
                $categoryId = $course['categoryid'];
                if (isset($categories[$categoryId])) {
                    $course['category_name'] = $categories[$categoryId];
                } else {
                    $course['category_name'] = 'Unknown'; // Jika ID kategori tidak ditemukan
                }
            }

            // Filter data berdasarkan kategori
            $filteredData = [];
            foreach ($data as $course) {
                if ($course['category_name'] == $inputCategory) {
                    $filteredData[] = $course;
                }
            }

            return response()->json($filteredData);
        } catch (Throwable $th) {
            return response()->json([
                'message' => 'Error',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function filterBySearch(Request $request) {
        try {
            $keyword = $request->input('keyword');

            // Mendapatkan data kursus dari API
            $response = Http::get('https://demo.diklat.id/lms/webservice/rest/server.php', [
                'wstoken' => 'd203af738612dd97b1e248bfb229ddab',
                'moodlewsrestformat' => 'json',
                'wsfunction' => 'core_course_get_courses',
            ]);

            $data = $response->json();

            // Mendapatkan daftar kategori
            $categoriesResponse = Http::get('https://demo.diklat.id/lms/webservice/rest/server.php', [
                'wstoken' => 'd203af738612dd97b1e248bfb229ddab',
                'moodlewsrestformat' => 'json',
                'wsfunction' => 'core_course_get_categories',
            ]);

            $categoriesData = $categoriesResponse->json();

            // Mengonversi daftar kategori menjadi associative array dengan id sebagai key dan nama sebagai value
            $categories = [];
            foreach ($categoriesData as $category) {
                $categories[$category['id']] = $category['name'];
            }

            // Mengubah ID kategori menjadi nama kategori dalam data kursus
            foreach ($data as &$course) {
                $categoryId = $course['categoryid'];
                if (isset($categories[$categoryId])) {
                    $course['category_name'] = $categories[$categoryId];
                } else {
                    $course['category_name'] = 'Unknown'; // Jika ID kategori tidak ditemukan
                }
            }

            // Filter data berdasarkan kategori
            $filteredData = [];
            foreach ($data as $course) {
                // Mengecek apakah keyword ada di displayname atau summary
                if (strpos(strtolower($course['displayname']), strtolower($keyword)) !== false || strpos(strtolower($course['summary']), strtolower($keyword)) !== false) {
                    $filteredData[] = $course;
                }
            }

            return response()->json($filteredData);
        } catch (Throwable $th) {
            return response()->json([
                'message' => 'Error',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function createCourse() {
        $categoriesResponse = Http::get('https://demo.diklat.id/lms/webservice/rest/server.php', [
            'wstoken' => 'd203af738612dd97b1e248bfb229ddab',
            'moodlewsrestformat' => 'json',
            'wsfunction' => 'core_course_get_categories',
        ]);

        $categoriesData = $categoriesResponse->json();

        // Mengonversi daftar kategori menjadi associative array dengan id sebagai key dan nama sebagai value
        // $categories = [];
        // foreach ($categoriesData as $category) {
        //     $categories[$category['id']] = $category['name'];
        // }

        return view('createCoursesPage', compact('categoriesData'));
    }

    public function storeCourse(Request $request) {
        $request->validate([
            'fullname' => 'required|string|max:50',
            'shortname' => 'required|max:20',
            'categoryid' => 'required|integer',
            'summary' => 'required|string|max:50',
        ]);

        try {
            /*
                setelah saya menggunakan post ga bisa malah bisa mebggunakan get aga aneh sih dari tadi mencari sumber masalahnya
                tapi setelah saya coba menggunakan get bisa wkwk cukup aneh soalnya di postman menggunakan post tapi yasudah lah
            */
            $response = Http::get('https://demo.diklat.id/lms/webservice/rest/server.php', [
                'wstoken' => 'd203af738612dd97b1e248bfb229ddab',
                'moodlewsrestformat' => 'json',
                'wsfunction' => 'core_course_create_courses',
                'courses' => [
                    [
                        'fullname' => $request->fullname,
                        'shortname' => $request->shortname,
                        'categoryid' => $request->categoryid,
                        'summary' => $request->summary,
                    ],
                ],
            ]);

            Alert::success('Created Course', 'Course created successfully!');

            return redirect()->back();
        } catch (Throwable $th) {
            return response()->json([
                'message' => 'Error',
                'error' => $th->getMessage()
            ], 500);
        }
    }
}
