<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use Facade\FlareClient\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // orm
        $barangs = Barang::all();

        // query builder raw contoh where
        // $barang = DB::select('select * from barangs where stok = ? and harga = ?', [10, 1000]);

        // // query builder biasa
        // // $barang =  DB::table('barangs')
        // //     ->orderBy('nama_barang', 'asc')
        // //     ->get();

        // array
        // return php
        // return json_encode($responnya);
        // return laravel
        return response()->json([
                    'sukses' => true,
                    'barang' =>$barangs,
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate data
        $validator = Validator::make(
            $request->all(),
            [
                'nama' => ['required'],
                'harga' => ['required'],
                'stok' => ['required'],
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Silahkan Isi Bidang Yang Kosong',
                'data'    => $validator->errors()
            ], 401);
        } else {
            $post = Barang::create($request->all());
            if ($post) {
                return response()->json([
                    'success' => true,
                    'message' => 'Post Berhasil Disimpan!',
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Post Gagal Disimpan!',
                ], 401);
            }
        }
    }
        public function uploadfile(Request $request){
            
            $request->validate([
               'file' => 'required|mimes:jpg,jpeg,png,csv,txt,xlx,xls,pdf|max:2048'
            ]);
    
            $fileUpload = new FileUpload;
    
            if($request->file()) {
                $file_name = time().'_'.$request->file->getClientOriginalName();
                $file_path = $request->file('file')->storeAs('uploads', $file_name, 'public');
    
                $fileUpload->name = time().'_'.$request->file->getClientOriginalName();
                $fileUpload->path = '/storage/' . $file_path;
                $fileUpload->save();
    
                return response()->json(['success'=>'File uploaded successfully.','failed'=>'File Upload Failed']);
            }
       }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $barangs = Barang::findOrFail($id);
        $responnya = array(
            'sukses' => true,
            'barang' => $barangs
        );

        // return php
        // return json_encode($responnya);
        // return laravel
        return response()->json($responnya, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //validate data
        $validator = Validator::make(
            $request->all(),
            [
                'nama' => ['required'],
                'harga' => ['required', 'numeric'],
                'stok' => ['required', 'numeric'],
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Harap lengkapi perintah berikut !',
                'data'    => $validator->errors()
            ], 401);
        } else {
            $post = Barang::whereId($request->input('id'))->update([
                'nama'     => $request->input('nama'),
                'stok'   => $request->input('stok'),
                'harga'   => $request->input('harga'),
            ]);
            if ($post) {
                return response()->json([
                    'success' => true,
                    'message' => 'Post Berhasil Diupdate!',
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Post Gagal Diupdate!',
                ], 401);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Barang::findOrFail($id);
        $post->delete();

        if ($post) {
            return response()->json([
                'success' => true,
                'message' => 'Post Berhasil Dihapus!',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Post Gagal Dihapus!',
            ], 400);
        }
    }
}
