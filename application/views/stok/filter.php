<div class="card shadow-sm border-bottom-primary">
    <div class="card-header bg-primary py-3">
        <div class="row">
            <div class="col">
                <h4 class="h5 align-middle m-0 font-weight-bold text-white">
                    <i class="fas fa-filter"></i> Filter Laporan Stok Inventori
                </h4>
            </div>
            <div class="col-auto">
                <a href="<?= base_url('stok') ?>" class="btn btn-sm btn-secondary btn-icon-split">
                    <span class="icon">
                        <i class="fas fa-arrow-left"></i>
                    </span>
                    <span class="text">
                        Kembali
                    </span>
                </a>
                <?php if (!empty($stok)): ?>
                <button type="button" id="exportBtn" class="btn btn-sm btn-success btn-icon-split">
                    <span class="icon">
                        <i class="fas fa-file-excel"></i>
                    </span>
                    <span class="text">
                        Export Excel
                    </span>
                </button>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="card-body">
        <!-- Filter Form -->
        <form method="post" action="<?= base_url('stok/filter') ?>" id="filterForm">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="bulan">Bulan</label>
                        <input type="month" class="form-control" id="bulan" name="bulan" 
                               value="<?= isset($filter['bulan']) ? $filter['bulan'] : '' ?>" required>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <button type="submit" name="submit_filter" class="btn btn-primary">
                            <i class="fas fa-search"></i> Terapkan Filter
                        </button>
                        <a href="<?= base_url('stok/reset_filter') ?>" class="btn btn-secondary">
                            <i class="fas fa-undo"></i> Reset Filter
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?php if (!empty($stok)): ?>
<!-- Results -->
<div class="card shadow-sm border-bottom-primary mt-4">
    <div class="card-header bg-success py-3">
        <h4 class="h5 align-middle m-0 font-weight-bold text-white">
            <i class="fas fa-list"></i> Hasil Filter (<?= count($stok) ?> data)
        </h4>
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
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= count($stok) ?></div>
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
                                    <?= array_sum(array_column($stok, 'barang_masuk')) ?>
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
                                    <?= array_sum(array_column($stok, 'barang_keluar')) ?>
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
                                    <?= array_sum(array_column($stok, 'persediaan_akhir')) ?>
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
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= date('F Y', strtotime($s['tanggal'])) ?></td>
                            <td><?= htmlspecialchars($s['jenis_barang']) ?></td>
                            <td><?= htmlspecialchars($s['nama_barang']) ?></td>
                            <td><?= htmlspecialchars($s['satuan']) ?></td>
                            <td><?= htmlspecialchars($s['supplier']) ?></td>
                            <td class="text-right"><?= number_format($harga_beli, 2) ?></td>
                            <td class="text-right"><?= number_format($stok_awal, 0) ?></td>
                            <td class="text-right"><?= number_format($harga_total_stok_awal, 2) ?></td>
                            <td class="text-right"><?= number_format($barang_masuk, 0) ?></td>
                            <td class="text-right"><?= number_format($harga_total_barang_masuk, 2) ?></td>
                            <td class="text-right"><?= number_format($stok_tersedia, 0) ?></td>
                            <td class="text-right"><?= number_format($harga_total_stok_tersedia, 2) ?></td>
                            <td class="text-right"><?= number_format($harga_rata_rata, 2) ?></td>
                            <td class="text-right"><?= number_format($barang_keluar, 0) ?></td>
                            <td class="text-right"><?= number_format($harga_total_barang_keluar, 2) ?></td>
                            <td class="text-right"><?= number_format($stok_akhir, 0) ?></td>
                            <td class="text-right"><?= number_format($harga_persediaan_akhir, 2) ?></td>
                        </tr>
                        <?php
                    }
                } else {
                    echo '<tr><td colspan="18" class="text-center">Tidak ada data yang ditemukan</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi DataTable
        $('#dataTable').DataTable({
            responsive: true,
            order: [[1, 'asc']], // Urutkan berdasarkan bulan
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fas fa-file-excel"></i> Export Excel',
                    title: 'Laporan Stok Inventori',
                    className: 'btn btn-success',
                    exportOptions: {
                        columns: ':visible'
                    },
                    customize: function(xlsx) {
                        var sheet = xlsx.xl.worksheets['sheet1.xml'];
                        
                        // Style for header
                        $('row:first c', sheet).attr('s', '2');
                    }
                }
            ],
            language: {
                url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json'
            },
            scrollX: true,
            columnDefs: [
                { targets: [7,8,9,10,11,12,13,14,15,16,17], className: 'text-right' },
                { targets: '_all', className: 'text-center' }
            ]
        });

        // Export button click handler
        $('#exportBtn').click(function() {
            $('#dataTable').DataTable().button('0').trigger();
        });

        // AJAX untuk mendapatkan barang berdasarkan jenis
        $('#jenis_id').change(function() {
            var jenis_id = $(this).val();
            if(jenis_id) {
                $.ajax({
                    url: '<?= base_url('stok/get_barang_by_jenis') ?>',
                    type: 'POST',
                    data: {jenis_id: jenis_id},
                    dataType: 'json',
                    success: function(data) {
                        $('#barang_id').html('<option value="">-- Pilih Barang --</option>');
                        $.each(data, function(key, value) {
                            $('#barang_id').append('<option value="'+ value.id_barang +'">'+ value.nama_barang +'</option>');
                        });
                    }
                });
            } else {
                $('#barang_id').html('<option value="">-- Pilih Barang --</option>');
            }
        });

        // Set nilai barang jika ada filter sebelumnya
        <?php if(isset($filter['jenis_id']) && !empty($filter['jenis_id']) && isset($filter['barang_id']) && !empty($filter['barang_id'])): ?>
            $.ajax({
                url: '<?= base_url('stok/get_barang_by_jenis') ?>',
                type: 'POST',
                data: {jenis_id: '<?= $filter['jenis_id'] ?>'},
                dataType: 'json',
                success: function(data) {
                    $('#barang_id').html('<option value="">-- Pilih Barang --</option>');
                    $.each(data, function(key, value) {
                        var selected = (value.id_barang == '<?= $filter['barang_id'] ?>') ? 'selected' : '';
                        $('#barang_id').append('<option value="'+ value.id_barang +'" '+ selected +'>'+ value.nama_barang +'</option>');
                    });
                }
            });
        <?php endif; ?>

        // Validasi tanggal
        $('#filterForm').submit(function() {
            var tanggal_dari = $('#tanggal_dari').val();
            var tanggal_sampai = $('#tanggal_sampai').val();
            
            if(tanggal_dari && tanggal_sampai) {
                if(new Date(tanggal_dari) > new Date(tanggal_sampai)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Kesalahan',
                        text: 'Tanggal Dari tidak boleh lebih besar dari Tanggal Sampai'
                    });
                    return false;
                }
            }
            return true;
        });
    });
</script>

<?php endif; ?>