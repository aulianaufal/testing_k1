<div class="card border-success mb-3 shadow-sm border-bottom-secondary">
    <div class="card-header bg-dark py-3">
        <div class="row">
            <div class="col">
                <h4 class="h5 align-middle m-0 font-weight-bold text-white">
                    Data Jenis
                </h4>
            </div>
            <div class="col-auto">
                <a href="<?= base_url('jenis/add') ?>" class="btn btn-sm btn-secondary btn-icon-split">
                    <span class="icon">
                        <i class="fa fa-plus"></i>
                    </span>
                    <span class="text">
                        Tambah Jenis Barang
                    </span>
                </a>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped" id="dataTable">
            <thead>
                <tr>
                    <th style="background: greenyellow;"><strong>No.</strong></th>
                    <th style="background: greenyellow;">Nama Jenis</th>
                    <th style="background: greenyellow;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                if ($jenis) :
                    foreach ($jenis as $j) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= htmlspecialchars($j['nama_jenis']); ?></td>
                            <td>
                                <a href="<?= base_url('jenis/edit/') . $j['id_jenis'] ?>" class="btn btn-warning btn-circle btn-sm" title="Edit">
                                    <i class="fa fa-edit"></i>
                                </a>

                                <!-- Tombol hapus trigger modal -->
                                <button 
                                    type="button" 
                                    class="btn btn-danger btn-circle btn-sm" 
                                    data-toggle="modal" 
                                    data-target="#deleteModal<?= $j['id_jenis'] ?>"
                                    title="Hapus">
                                    <i class="fa fa-trash"></i>
                                </button>
                                
                                <!-- Modal Delete Confirmation (unique for each row) -->
                                <div class="modal fade" id="deleteModal<?= $j['id_jenis'] ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Apakah Anda yakin ingin menghapus jenis "<?= htmlspecialchars($j['nama_jenis']) ?>"?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                <a href="<?= base_url('jenis/delete/') . $j['id_jenis'] ?>" class="btn btn-danger">Ya, hapus</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; 
                else : ?>
                    <tr>
                        <td colspan="3" class="text-center">Data Kosong</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>