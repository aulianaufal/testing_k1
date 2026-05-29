<div class="card shadow-sm border-bottom-secondary">
    <div class="card-header bg-dark py-3">
        <div class="row">
            <div class="col">
                <h4 class="h5 align-middle m-0 font-weight-bold text-white">
                    Data Barang
                </h4>
            </div>
            <div class="col-auto">
                <a href="<?= base_url('barang/add') ?>" class="btn btn-sm btn-secondary btn-icon-split">
                    <span class="icon">
                        <i class="fa fa-plus"></i>
                    </span>
                    <span class="text">
                        Tambah Barang
                    </span>
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped w-100 dt-responsive nowrap" id="dataTable">
                <thead>

                    <th style="background: greenyellow;">NO.</th>
                    <th style="background: greenyellow;">NAMA BARANG</th>
                    <th style="background: greenyellow;">KELOMPOK BARANG</th>
                    <th style="background: greenyellow;">SATUAN</th>
                    <th style="background: greenyellow;">SUPPLIER</th>
                    <th style="background: #36b9cc;">HARGA BELI</th>
                    <th style="background: #36b9cc;">POT1 (%)</th>
                    <th style="background: #36b9cc;">POT2 (%)</th>
                    <th style="background: #36b9cc;">POT3 (%)</th>
                    <th style="background: #36b9cc;">PPN (%)</th>
                    <th style="background: #36b9cc;">NETTO</th>
                    <th style="background: #36b9cc;">HARGA JUAL</th>
                    <th style="background: #36b9cc;">SELISIH</th>
                    <th style="background: #36b9cc;">MARGIN (%)</th>
                    <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    if (!empty($barang)):
                        foreach ($barang as $b):
                            $detail_barang = htmlspecialchars($b['detail_barang']);
                            $nama_jenis = htmlspecialchars($b['nama_jenis']);
                            $nama_satuan = htmlspecialchars($b['nama_satuan']);
                            $nama_supplier = htmlspecialchars($b['nama_supplier']);

                            $harga_beli = isset($b['harga_beli']) ? (float) $b['harga_beli'] : 0;
                            $potongan1 = isset($b['potongan1']) ? (float) $b['potongan1'] : 0;
                            $potongan2 = isset($b['potongan2']) ? (float) $b['potongan2'] : 0;
                            $potongan3 = isset($b['potongan3']) ? (float) $b['potongan3'] : 0;
                            $ppn = isset($b['ppn']) ? (float) $b['ppn'] : 0;
                            $harga_jual = isset($b['harga_jual']) ? (float) $b['harga_jual'] : 0;

                            // Calculate total discount
                            $harga_setelah_potongan = $harga_beli;
                            $harga_setelah_potongan -= $harga_setelah_potongan * $potongan1 / 100;
                            $harga_setelah_potongan -= $harga_setelah_potongan * $potongan2 / 100;
                            $harga_setelah_potongan -= $harga_setelah_potongan * $potongan3 / 100;

                            // Add PPN
                            $harga_setelah_potongan_ppn = $harga_setelah_potongan + ($harga_setelah_potongan * $ppn / 100);

                            // Calculate difference and margin
                            $selisih = $harga_jual - $harga_setelah_potongan_ppn;
                            $margin = ($harga_setelah_potongan_ppn > 0) ? ($selisih / $harga_setelah_potongan_ppn) * 100 : 0;
                            ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= htmlspecialchars($b['nama_barang']); ?></td>
                                <td><?= $nama_jenis; ?></td>
                                <td><?= $nama_satuan; ?></td>
                                <td><?= $nama_supplier; ?></td>
                                <td>Rp <?= number_format($harga_beli, 0, ',', '.'); ?></td>
                                <td><?= $potongan1; ?>%</td>
                                <td><?= $potongan2; ?>%</td>
                                <td><?= $potongan3; ?>%</td>
                                <td><?= $ppn; ?>%</td>
                                <td>Rp <?= number_format($harga_setelah_potongan_ppn, 0, ',', '.'); ?></td>
                                <td>Rp <?= number_format($harga_jual, 0, ',', '.'); ?></td>
                                <td>Rp <?= number_format($selisih, 0, ',', '.'); ?></td>
                                <td><?= round($margin, 2); ?>%</td>
                                <td>
                                    <a href="<?= base_url('barang/edit/' . $b['id_barang']); ?>"
                                        class="btn btn-warning btn-circle btn-sm" title="Edit"><i class="fa fa-edit"></i></a>
                                    <a href="<?= base_url('barang/delete/' . $b['id_barang']); ?>"
                                        onclick="return confirm('Yakin ingin hapus?')" class="btn btn-danger btn-circle btn-sm"
                                        title="Hapus"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="14" class="text-center">Data Kosong</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>