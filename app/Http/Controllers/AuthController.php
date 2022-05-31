<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        //validate data
        $validator = Validator::make(
            $request->all(),
            [
                'email' => ['required'],
                'password' => ['required'],
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Silahkan Isi Bidang Yang Kosong',
                'data'    => $validator->errors()
            ], 401);
        } else {
            $cekUsernamePassword = DB::select('select * from users where email = ? and password = ?', [$request->input('email'), $request->input('password')]);
            // echo json_encode($cekUsernamePassword);
            if (count($cekUsernamePassword) == 1) {
                return response()->json([
                    'success' => true,
                    'message' => 'Data ditemukan !',
                    'data' => $cekUsernamePassword[0],
                    'token' => md5($cekUsernamePassword[0]->name)
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Username / Password Salah!',
                ], 401);
            }
        }
    }
}