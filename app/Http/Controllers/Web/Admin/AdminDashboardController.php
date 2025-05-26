<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\DataPadi;
use App\Models\Ricesales\Order;
use App\Models\Ricesales\OrderItem;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    //
    function index()
    { 
        $users = User::where('role', 'petani')->count();

        $dataPadi = DataPadi::latest()->paginate(10)->withQueryString();

        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;

        $totalPadi = DataPadi::whereMonth('created_at', $bulanIni)
                    ->whereYear('created_at', $tahunIni)
                    ->sum('jumlah_padi');

        // Group by tanggal, hitung total order (is_paid = true) per hari bulan ini
        $totalPenjualan = Order::where('is_paid', true)->whereMonth('created_at', $bulanIni)
                        ->whereYear('created_at', $tahunIni)
                        ->count();
        $penjualan = Order::select(
                            DB::raw('DATE(created_at) as tanggal'),
                            DB::raw('COUNT(*) as total')
                        )
                        ->where('is_paid', true)
                        ->whereMonth('created_at', $bulanIni)
                        ->whereYear('created_at', $tahunIni)
                        ->groupBy('tanggal')
                        ->orderBy('tanggal')
                        ->get();

        $labelsPenjualan = $penjualan->pluck('tanggal')->toArray();
        $dataPenjualan = $penjualan->pluck('total')->toArray();

        // Join products & order_items, sum quantity, ambil 5 produk terlaris
        $produkTerlaris = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_terjual'))
            ->with('product')
            ->whereHas('order', function($q) {
                $q->where('is_paid', true);
            })
            ->groupBy('product_id')
            ->orderByDesc('total_terjual')
            ->take(5)
            ->get();

        $labelsProduk = $produkTerlaris->map(function ($item) {
            return $item->product ? $item->product->name : 'Unknown';
        })->toArray();

        // Data total terjual
        $dataProduk = $produkTerlaris->pluck('total_terjual')->toArray();
        
        $data = [
            'title' => 'Halaman Dashboard',
            'users' => $users,
            'totalPadi' => $totalPadi,
            'totalPenjualan' => $totalPenjualan,
            'dataPadi' => $dataPadi,
            'labelsPenjualan' => $labelsPenjualan,
            'dataPenjualan' => $dataPenjualan,
            'labelsProduk' => $labelsProduk,
            'dataProduk' => $dataProduk,
        ];
        return view('admin.dashboard.index', $data);
    }
}
