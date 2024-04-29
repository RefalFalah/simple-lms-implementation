<?php

namespace App\Http\Controllers;

use Throwable;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function index() {
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

            // Mengambil 4 data terakhir sebagai data yang akan ditampilkan di halaman utama
            $lastFourData = array_slice($data, 0, 4);

            return view('homePage', compact('lastFourData'));
        } catch (Throwable $th) {
            return response()->json([
                'message' => 'Error',
                'error' => $th->getMessage()
            ], 500);
        }
    }
}
