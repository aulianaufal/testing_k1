<div class="card shadow-sm border-bottom-secondary">
    <div class="card-header bg-dark py-3">
        <div class="row">
            <div class="col">
                <h4 class="h5 align-middle m-0 font-weight-bold text-white">
                    Riwayat Data Barang Masuk
                </h4>
            </div>
            <div class="col-auto">
                <a href="<?= base_url('barangmasuk/add') ?>" class="btn btn-sm btn-secondary btn-icon-split">
                    <span class="icon">
                        <i class="fa fa-plus"></i>
                    </span>
                    <span class="text">
                        Input Barang Masuk
                    </span>
                </a>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped w-100 dt-responsive nowrap" id="dataTable">
            <thead>
                <tr>
                    <th style="background: greenyellow;">No.</th>
                    <th style="background: greenyellow;">Tanggal</th>
                    <th style="background: greenyellow;">Supplier</th>
                    <th style="background: greenyellow;">Nota</th>
                    <th style="background: greenyellow;">Kelompok Barang</th>
                    <th style="background: greenyellow;">Nama Barang</th>
                    <th style="background: greenyellow;">Satuan</th>
                    <th style="background: greenyellow;">Jumlah</th>
                    <th style="background: greenyellow;">Harga Beli</th>
                    <th style="background: greenyellow;">Total</th>
                    <th style="background: greenyellow;">Tunai</th>
                    <th style="background: greenyellow;">Kredit</th>
                    <th style="background: greenyellow;">Keterangan</th>
                    <th style="background: greenyellow;">Aksi</th>
                </tr>
            </thead>

            <tbody>
                <?php if ($barangmasuk): ?>
                    <?php $no = 1;
                    foreach ($barangmasuk as $bm): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= date('d-m-Y', strtotime($bm['tanggal'])); ?></td>
                            <td><?= $bm['nama_supplier']; ?></td>
                            <td><?= $bm['nota']; ?></td>
                            <td><?= $bm['nama_jenis']; ?></td>
                            <td><?= $bm['nama_barang']; ?></td>
                            <td><?= $bm['nama_satuan']; ?></td>
                            <td><?= $bm['jumlah_masuk']; ?></td>
                            <td><?= "Rp. " . number_format($bm['harga_setelah_potongan'], 0, ',', '.'); ?></td>
                            <td><?= number_format($bm['total'], 0, ',', '.'); ?></td>
                            <td><?= "Rp. " . $bm['tunai']; ?></td>
                            <td><?= "Rp. " . $bm['kredit']; ?></td>
                            <td><?= $bm['keterangan']; ?></td>
                            <td>
                                <a href="<?= base_url('barangmasuk/delete/' . $bm['transaksi_id']); ?>"
                                    class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin hapus?')">
                                    <i class="fa fa-trash"></i>
                                </a>

                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="11" class="text-center">Data Kosong</td>
                    </tr>
                <?php endif; ?>
            </tbody>

        </table>
    </div>
</div>
<script>

    
   
    $('.btn-delete').on('click', function (e) {
        if (!confirm('Yakin ingin hapus?')) {
            e.preventDefault();
        }
    });
</script>