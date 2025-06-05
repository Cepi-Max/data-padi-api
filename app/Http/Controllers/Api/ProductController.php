<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ricesales\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user();
        if ($user->role === 'user') {
            
            $productdata = Product::all();

        } else if ($user->role === 'admin') {
            // Ambil order dari semua user yang punya produk + order items-nya
            $productUserIds = Product::pluck('user_id')->unique();
             $productdata = Product::whereIn('user_id', $productUserIds)
                ->get();

        } else {
            return response()->json([
                'status' => false,
                'message' => 'Role tidak dikenali'
            ], 403);
        }
         
        return response()->json([
            'status' => true,
            'message' => 'Data berhasil ditemukan',
            'data' => $productdata
        ], 200);
    }

    public function show(string $id)
    {
        //
        $productdata = Product::findOrFail($id);
        
        return response()->json([
            'status' => 'true',
            'message' => 'Data Detail Berhasil ditemukan',
            'data' => $productdata
        ]);
    }

    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'image' => 'extensions:jpg,png',
            // 'image' => 'required|extensions:jpg,png',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => 'validasi error',
                'errors' => $validator->errors(),
            ], 422);
        }

         if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $file = $request->file('image'); 
            $fileName = now()->format('Y-m-d_H-i-s') . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $path   = 'images/dataproduk/'.$fileName;
            Storage::disk('public')->put($path, file_get_contents($file));
         } else {
             $fileName = 'default.png';
         }

         $user_id = Auth::user()->id;

         $dataproduct = Product::create([
            'user_id' => $user_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $fileName,
        ]);
              

        return response()->json([
            'status' => true,
            'message' => 'data berhasil ditambahkan',
            'data' => $dataproduct
        ], 201);

    }

    public function update(Request $request, string $id)
    {
        //
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'image' => 'extensions:jpg,png',
            // 'image' => 'required|extensions:jpg,png',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => 'validasi error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $dataproduct = Product::findOrFail($id);

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $file = $request->file('image');

            $fileName = now()->format('Y-m-d_H-i-s') . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $path = 'images/dataproduk/'.$fileName;

            if ($dataproduct->image && $dataproduct->image !== 'default.png') {
                Storage::disk('public')->delete('images/dataproduk/'.$dataproduct->image);
            }

            Storage::disk('public')->put($path, file_get_contents($file));

            $dataproduct->image = $fileName;
        } else {
            $dataproduct->image = $dataproduct->image ?? 'default.png';
        }

         $user_id = Auth::user()->id;

         $dataproduct->update([
            'user_id' => $user_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $fileName,
        ]);
              

        return response()->json([
            'status' => true,
            'message' => 'data berhasil diubah',
            'data' => $dataproduct
        ], 201);

    }

    public function destroy(string $id)
    {
        //
        $dataproduct = Product::findOrFail($id);

        if (!empty($dataproduct->image) && $dataproduct->image !== 'default.png') {
            $filePath = 'images/dataproduk/' . $dataproduct->image;
            Storage::disk('public')->delete($filePath);
        }

        $dataproduct->delete();

        return response()->json([
            'status' => true,
            'message' => 'data berhasil dihapus'
        ], 200);
    }
}
