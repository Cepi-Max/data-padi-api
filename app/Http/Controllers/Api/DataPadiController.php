<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DataPadi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class DataPadiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $datapadi = DataPadi::all();
         
        return response()->json([
            'status' => true,
            'message' => 'Data berhasil ditemukan',
            'data' => $datapadi
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(),[
            'nama' => 'required',
            'jumlah_padi' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'foto_padi' => 'required|extensions:jpg,png',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => 'validasi error',
                'errors' => $validator->errors(),
            ], 422);
        }

         if ($request->hasFile('foto_padi') && $request->file('foto_padi')->isValid()) {
            $file = $request->file('foto_padi'); 
            $fileName = now()->format('Y-m-d_H-i-s') . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $path   = 'images/petani/datapadi/fotopadi/'.$fileName;
            Storage::disk('public')->put($path, file_get_contents($file));
         } else {
             $fileName = 'default.png';
         }

         $datapadi = DataPadi::create([
            'nama' => $request->nama,
            'jumlah_padi' => $request->jumlah_padi,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'foto_padi' => $fileName,
        ]);
              

        return response()->json([
            'status' => true,
            'message' => 'data berhasil ditambahkan',
            'data' => $datapadi
        ], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $datapadi = DataPadi::findOrFail($id);
        
        return response()->json([
            'status' => 'true',
            'message' => 'Data Detail Berhasil ditemukan',
            'data' => $datapadi
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $validator = Validator::make($request->all(),[
            'nama' => 'required',
            'jumlah_padi' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'foto_padi' => 'nullable|mimes:jpg,png',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => 'validasi error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $datapadi = DataPadi::findOrFail($id);

        if ($request->hasFile('foto_padi') && $request->file('foto_padi')->isValid()) {
            $file = $request->file('foto_padi');

            // Buat nama file unik
            $fileName = now()->format('Y-m-d_H-i-s') . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $path = 'images/petani/datapadi/fotopadi/'.$fileName;

            // Hapus gambar lama jika bukan default.png
            if ($datapadi->foto_padi && $datapadi->foto_padi !== 'default.png') {
                Storage::disk('public')->delete('images/petani/datapadi/fotopadi/'.$datapadi->foto_padi);
            }

            // Simpan gambar baru
            Storage::disk('public')->put($path, file_get_contents($file));

            // Simpan nama file baru ke dalam database
            $datapadi->foto_padi = $fileName;
        } else {
            // Jika tidak ada file baru, gunakan gambar lama atau default.png
            $datapadi->foto_padi = $datapadi->foto_padi ?? 'default.png';
        }

        $datapadi->update([
            'nama' => $request->nama,
            'jumlah_padi' => $request->jumlah_padi,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);
        

        return response()->json([
            'status' => true,
            'message' => 'data berhasil diubah',
            'data' => $datapadi
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $datapadi = DataPadi::findOrFail($id);

        if (!empty($datapadi->foto_padi) && $datapadi->foto_padi !== 'default.png') {
            $filePath = 'images/petani/datapadi/fotopadi/' . $datapadi->foto_padi;
            Storage::disk('public')->delete($filePath);
        }

        $datapadi->delete();

        return response()->json([
            'status' => true,
            'message' => 'data berhasil dihapus'
        ], 200);
    }
}
