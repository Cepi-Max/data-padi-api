@extends('layouts.app')

@section('content')

    <!-- Stat Cards -->
        <div class="row">
            <div class="col-md-4">
                <div class="stat-card">
                    <h6>Total Padi Bulan ini</h6>
                    <div class="stat">{{ $totalPadi }} kg</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <h6>Petani Terdaftar</h6>
                    <div class="stat">{{ $users }}</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <h6>Transaksi Bulan Ini</h6>
                    <div class="stat">{{ $totalPenjualan }}</div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-white" style="color:#6baf54;font-weight:600;font-size:1.1rem;">
                        Grafik Penjualan Bulan Ini
                    </div>
                    <div class="card-body">
                        <canvas id="penjualanChart" style="min-height:320px; height:340px; max-height:360px; width:100%;"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-white" style="color:#6baf54;font-weight:600;font-size:1.1rem;">
                        Produk Terlaris
                    </div>
                    <div class="card-body">
                        <canvas id="produkTerlarisChart" style="min-height:320px; height:340px; max-height:360px; width:100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <!-- Table Data Padi -->
        <div class="card mt-4">
            <div class="card-header bg-white" style="color:#6baf54;font-weight:600;font-size:1.1rem;">Tabel Data Padi Terbaru</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-padi table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Padi</th>
                                <th>Jenis</th>
                                <th>Jumlah (Kg)</th>
                                <th>Tanggal Update</th>
                            </tr>
                        </thead>
                        <tbody>
                          @forelse ($dataPadi as $index => $tp)
                            <tr>
                                <td>{{ $dataPadi->firstItem() + $index }}</td>
                                <td>{{ $tp->nama }}</td>
                                <td>{{ $tp->jenis_padi }}</td>
                                <td>{{ $tp->jumlah_padi }}</td>
                                <td>{{ $tp->updated_at->format('d M Y') }}</td>
                            </tr>
                          @empty
                            
                          @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>




@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    var ctx = document.getElementById('penjualanChart').getContext('2d');
    var penjualanChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($labelsPenjualan) !!},
            datasets: [{
                label: 'Jumlah Penjualan',
                data: {!! json_encode($dataPenjualan) !!},
                backgroundColor: 'rgba(107, 175, 84, 0.8)',
                borderColor: 'rgba(76, 141, 61, 1)',
                borderWidth: 2,
                borderRadius: 8,
                maxBarThickness: 40,
            }]
        },
        options: {
            scales: {
                x: { title: { display: true, text: 'Tanggal' }},
                y: { beginAtZero: true, title: { display: true, text: 'Jumlah Transaksi' }, ticks: { stepSize: 1 } }
            },
            plugins: { legend: { display: false }}
        }
    });
});
document.addEventListener("DOMContentLoaded", function() {
    var ctx = document.getElementById('produkTerlarisChart').getContext('2d');
    var produkTerlarisChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($labelsProduk) !!},
            datasets: [{
                label: 'Total Dibeli',
                data: {!! json_encode($dataProduk) !!},
                backgroundColor: 'rgba(107, 175, 84, 0.8)',
                borderColor: 'rgba(76, 141, 61, 1)',
                borderWidth: 2,
                borderRadius: 8,
                maxBarThickness: 40,
            }]
        },
        options: {
            indexAxis: 'y', // bikin horizontal bar chart, bisa hapus kalau mau vertikal
            scales: {
                x: { beginAtZero: true, title: { display: true, text: 'Jumlah Dibeli' }},
                y: { title: { display: true, text: 'Produk' }}
            },
            plugins: {
                legend: { display: false }
            }
        }
    });
});
</script>
@endpush

@endsection