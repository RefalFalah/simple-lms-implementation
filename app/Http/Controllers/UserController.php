<?php

namespace App\Http\Controllers;

use Throwable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function createUser() {
        return view('createUserPage');
    }

    public function storeUser(Request $request) {
        $request->validate([
            'username' => 'required|string|max:50',
            'password' => 'required|min:8',
            'firstname' => 'required|string|max:20',
            'lastname' => 'required|string|max:20',
            'email' => 'required|email',
        ]);

        try {
            /*
                setelah saya menggunakan post ga bisa malah bisa mebggunakan get aga aneh sih dari tadi mencari sumber masalahnya
                tapi setelah saya coba menggunakan get bisa wkwk cukup aneh soalnya di postman menggunakan post tapi yasudah lah
            */
            $response = Http::get('https://demo.diklat.id/lms/webservice/rest/server.php', [
                'wstoken' => 'd203af738612dd97b1e248bfb229ddab',
                'moodlewsrestformat' => 'json',
                'wsfunction' => 'core_user_create_users',
                'users' => [
                    [
                        'username' => $request->username,
                        'password' => $request->password,
                        'firstname' => $request->username,
                        'lastname' => $request->username,
                        'email' => $request->email,
                    ],
                ],
            ]);

            Alert::success('Created User', 'User created successfully!');

            return redirect()->back();
        } catch (Throwable $th) {
            return response()->json([
                'message' => 'Error',
                'error' => $th->getMessage()
            ], 500);
        }
    }
}
