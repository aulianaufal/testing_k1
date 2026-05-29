<div class="card shadow-sm border-bottom-primary">
    <div class="card-header bg-primary py-3">
        <div class="row">
            <div class="col">
                <h4 class="h5 align-middle m-0 font-weight-bold text-white">
                    <i class="fas fa-warehouse"></i> Laporan Stok Inventori
                </h4>
            </div>
            <div class="col-auto">
                <a href="<?= base_url('stok/filter') ?>" class="btn btn-sm btn-warning btn-icon-split">
                    <span class="icon">
                        <i class="fas fa-filter"></i>
                    </span>
                    <span class="text">
                        Filter Data
                    </span>
                </a>
                <a href="<?= base_url('stok/export_excel') ?>" class="btn btn-sm btn-success btn-icon-split">
                    <span class="icon">
                        <i class="fas fa-file-excel"></i>
                    </span>
                    <span class="text">
                        Export Excel
                    </span>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Info Cards -->
    <div class="card-body pb-2">
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Transaksi</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= isset($stok) ? count($stok) : 0 ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Total Barang Masuk</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    <?= isset($stok) && !empty($stok) ? array_sum(array_column($stok, 'barang_masuk')) : 0 ?>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-arrow-up fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                    Total Barang Keluar</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    <?= isset($stok) && !empty($stok) ? array_sum(array_column($stok, 'barang_keluar')) : 0 ?>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-arrow-down fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Total Persediaan</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    <?= isset($stok) && !empty($stok) ? array_sum(array_column($stok, 'persediaan_akhir')) : 0 ?>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-boxes fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Second Row Cards -->
        <div class="row">
            <div class="col-xl-6 col-md-12 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Total Harga Persediaan Akhir</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    <?php 
                                    $total_harga_persediaan = 0;
                                    if (isset($stok) && !empty($stok)) {
                                        foreach ($stok as $s) {
                                            $total_harga_persediaan += ($s['persediaan_akhir'] ?? 0) * ($s['harga_beli'] ?? 0);
                                        }
                                    }
                                    echo 'Rp. ' . number_format($total_harga_persediaan, 0, ',', '.');
                                    ?>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="table-responsive">
        <table class="table table-striped w-100 dt-responsive nowrap" id="dataTable">
            <thead style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <tr>
                    <th>No.</th>
                    <th>Bulan</th>
                    <th>Jenis Barang</th>
                    <th>Nama Barang</th>
                    <th>Satuan</th>
                    <th>Supplier</th>
                    <th>Harga Beli</th>
                    <th>Stok Awal</th>
                    <th>Harga Stok Awal</th>
                    <th>Barang Masuk</th>
                    <th>Harga Barang Masuk</th>
                    <th>Stok Tersedia</th>
                    <th>Total Stok Tersedia</th>
                    <th>Harga Rata-rata</th>
                    <th>Barang Keluar</th>
                    <th>Harga Barang Keluar</th>
                    <th>Stok Akhir</th>
                    <th>Persediaan Akhir</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($stok) && !empty($stok)) {
                    $no = 1;
                    foreach ($stok as $s) {
                        // Perhitungan untuk setiap baris
                        $stok_awal = $s['stok_awal'] ?? 0;
                        $barang_masuk = $s['barang_masuk'] ?? 0;
                        $barang_keluar = $s['barang_keluar'] ?? 0;
                        $harga_beli = $s['harga_beli'] ?? 0;
                        
                        // Stok tersedia = stok awal + barang masuk (sebelum barang keluar)
                        $stok_tersedia = $stok_awal + $barang_masuk;
                        
                        // Stok akhir = stok tersedia - barang keluar (setelah barang keluar)
                        $stok_akhir = $stok_tersedia - $barang_keluar;
                        
                        // Harga rata-rata = harga beli (untuk kasus sederhana)
                        $harga_rata_rata = $harga_beli;
                        
                        // Perhitungan harga total
                        $harga_total_stok_awal = $stok_awal * $harga_beli;
                        $harga_total_barang_masuk = $barang_masuk * $harga_beli;
                        $harga_total_stok_tersedia = $stok_tersedia * $harga_beli;
                        $harga_total_barang_keluar = $barang_keluar * $harga_rata_rata;
                        $harga_persediaan_akhir = $stok_akhir * $harga_beli;
                        
                        echo '<tr>';
                        echo '<td>' . $no++ . '</td>';
                        echo '<td>' . date('m-Y', strtotime($s['tanggal'])) . '</td>';
                        echo '<td>' . htmlspecialchars($s['nama_jenis'] ?? '-') . '</td>';
                        echo '<td>' . htmlspecialchars($s['nama_barang'] ?? '-') . '</td>';
                        echo '<td>' . htmlspecialchars($s['nama_satuan'] ?? '-') . '</td>';
                        echo '<td>' . htmlspecialchars($s['nama_supplier'] ?? '-') . '</td>';
                        echo '<td>Rp. ' . number_format($harga_beli, 0, ',', '.') . '</td>';
                        echo '<td>' . number_format($stok_awal, 0, ',', '.') . '</td>';
                        echo '<td>Rp. ' . number_format($harga_total_stok_awal, 0, ',', '.') . '</td>';
                        echo '<td>' . number_format($barang_masuk, 0, ',', '.') . '</td>';
                        echo '<td>Rp. ' . number_format($harga_total_barang_masuk, 0, ',', '.') . '</td>';
                        echo '<td>' . number_format($stok_tersedia, 0, ',', '.') . '</td>';
                        echo '<td>Rp. ' . number_format($harga_total_stok_tersedia, 0, ',', '.') . '</td>';
                        echo '<td>Rp. ' . number_format($harga_rata_rata, 0, ',', '.') . '</td>';
                        echo '<td>' . number_format($barang_keluar, 0, ',', '.') . '</td>';
                        echo '<td>Rp. ' . number_format($harga_total_barang_keluar, 0, ',', '.') . '</td>';
                        echo '<td>' . number_format($stok_akhir, 0, ',', '.') . '</td>';
                        echo '<td>Rp. ' . number_format($harga_persediaan_akhir, 0, ',', '.') . '</td>';
                        echo '<td>';
                      
                    }
                } else {
                    echo '<tr>';
                    echo '<td colspan="19" class="text-center">Tidak ada data stok inventori</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<script>
$(document).ready(function() {
    // Method 1: Lebih robust untuk destroy existing DataTable
    if ($.fn.DataTable.isDataTable('#dataTable')) {
        $('#dataTable').DataTable().clear().destroy();
        $('#dataTable').empty(); // Hapus semua konten tabel jika perlu
    }

    // Tunggu sebentar sebelum inisialisasi ulang
    setTimeout(function() {
        try {
            // Inisialisasi DataTable dengan error handling
            var table = $('#dataTable').DataTable({
                "responsive": true,
                "pageLength": 25,
                "order": [[ 1, "desc" ]],
                "columnDefs": [
                    { "orderable": false, "targets": [17] } // Sesuaikan dengan kolom terakhir (index 17 untuk 18 kolom)
                ],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json" // Gunakan versi terbaru dan protocol-relative URL
                },
                "processing": true,
                "serverSide": false,
                "deferRender": true,
                "stateSave": false, // Disable state saving untuk menghindari konflik
                "destroy": true // Tambahkan opsi destroy
            });
        } catch (e) {
            console.error('Error initializing DataTable:', e);
            // Fallback: coba inisialisasi sederhana
            $('#dataTable').DataTable({
                "destroy": true,
                "pageLength": 25
            });
        }
    }, 100);
});

// Alternative method - jika masih ada masalah, gunakan ini
// $(document).ready(function() {
//     // Method 2: Force destroy dan recreate
//     $('#dataTable').DataTable().destroy();
//     $('#dataTable').DataTable({
//         "destroy": true,
//         "responsive": true,
//         "pageLength": 25,
//         "order": [[ 1, "desc" ]],
//         "language": {
//             "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json"
//         }
//     });
// });
</script>