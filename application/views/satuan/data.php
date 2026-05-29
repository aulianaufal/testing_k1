<div class="card shadow-sm border-bottom-secondary">
    <div class="card-header bg-dark  py-3">
        <div class="row">
            <div class="col">
                <h4 class="h5 align-middle m-0 font-weight-bold  text-white">
                    Data Satuan
                </h4>
            </div>
            <div class="col-auto">
                <a href="<?= base_url('satuan/add') ?>" class="btn btn-sm btn-secondary btn-icon-split">
                    <span class="icon">
                        <i class="fa fa-plus"></i>
                    </span>
                    <span class="text">
                        Tambah Satuan Barang
                    </span>
                </a>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped" id="dataTable">
            <thead>
                <tr>
                    <th style="background: greenyellow;">No. </th>
                    <th style="background: greenyellow;">Kode Satuan </th>
                    <th style="background: greenyellow;">Nama Satuan</th>
                    <th style="background: greenyellow;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                if ($satuan) :
                    foreach ($satuan as $j) :
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $j['id_satuan']; ?></td>
                            <td><?= $j['nama_satuan']; ?></td>
                            <td>
                                <a href="<?= base_url('satuan/edit/') . $j['id_satuan'] ?>" class="btn btn-warning btn-circle btn-sm"><i class="fa fa-edit"></i></a>
                                <a onclick="return confirm('Yakin ingin hapus?')" href="<?= base_url('satuan/delete/') . $j['id_satuan'] ?>" class="btn btn-danger btn-circle btn-sm"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="3" class="text-center">
                            Data Kosong
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>