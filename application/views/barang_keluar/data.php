<div class="card shadow-sm border-bottom-secondary">
    <div class="card-header bg-dark py-3">
        <div class="row">
            <div class="col">
                <h4 class="h5 align-middle m-0 font-weight-bold text-white">
                    Riwayat Data Barang Keluar
                </h4>
            </div>
            <div class="col-auto">
                <a href="<?= base_url('barangkeluar/add') ?>" class="btn btn-sm btn-secondary btn-icon-split">
                    <span class="icon">
                        <i class="fa fa-plus"></i>
                    </span>
                    <span class="text">
                        Input Barang Keluar
                    </span>
                </a>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped w-100 dt-responsive nowrap" id="dataTable">
            <thead>
                <tr>
                    <th style="background: greenyellow; ">NO.</th>
                    <th style="background: greenyellow;">TANGGAL KELUAR</th>
                    <th style="background: greenyellow;">COSTUMER</th>
                    <th style="background: greenyellow;">NOTA</th>
                    <th style="background: greenyellow;">JENIS BARANG</th>
                    <th style="background: greenyellow;">NAMA BARANG</th>
                    <th style="background: greenyellow;">SATUAN</th>
                    <th style="background: greenyellow;">JUMLAH</th>
                    <th style="background: greenyellow;">HARGA BELI</th>
                    <th style="background: greenyellow;">TOTAL</th>
                    <th style="background: greenyellow;">TUNAI</th>
                    <th style="background: greenyellow;">KREDIT</th>
                    <th style="background: greenyellow;">KETERANGAN</th>
                    <th style="background: greenyellow;">AKSI</th>
                </tr>
            </thead>

            <tbody>
                <?php if ($barangkeluar): ?>
                    <?php $no = 1;
                    foreach ($barangkeluar as $bk): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= date('d-m-Y', strtotime($bk['tanggal_keluar'])); ?></td>
                            <td><?= $bk['nama_customer']; ?></td>
                            <td><?= $bk['nota']; ?></td>
                            <td><?= $bk['nama_jenis']; ?></td>
                            <td><?= $bk['nama_barang']; ?></td>
                            <td><?= $bk['nama_satuan']; ?></td>
                            <td><?= $bk['jumlah_keluar']; ?></td>
                            <td><?php echo "Rp. " . number_format($bk['harga_setelah_potongan'], 0, ',', '.'); ?></td>
                            <td><?= "Rp. " . number_format($bk['total'], 0, ',', '.'); ?></td>
                            <td><?= "Rp. " . $bk['tunai']; ?></td>
                            <td><?= "Rp. " . $bk['kredit']; ?></td>
                            <td><?= $bk['keterangan']; ?></td>
                            <td>
                                <a href="<?= base_url('barangkeluar/delete/' . $bk['id_barang_keluar']); ?>"
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