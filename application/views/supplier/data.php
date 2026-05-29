<div class="card shadow-sm border-bottom-secondary">
    <div class="card-header bg-dark py-3">
        <div class="row">
            <div class="col">
                <h4 class="h5 align-middle m-0 font-weight-bold text-white">
                    Data Supplier
                </h4>
            </div>
            <div class="col-auto">
                <a href="<?= base_url('supplier/add') ?>" class="btn btn-sm btn-secondary btn-icon-split">
                    <span class="icon">
                        <i class="fa fa-plus"></i>
                    </span>
                    <span class="text">
                        Tambah Supplier
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
                    <th style="background: greenyellow;">Nama</th>
                    <th style="background: greenyellow;">Nomor Telepon</th>
                    <th style="background: greenyellow;">Alamat</th>
                    <th style="background: greenyellow;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($supplier) :
                    $no = 1;
                    foreach ($supplier as $s) :
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $s['nama_supplier']; ?></td>
                            <td><?= $s['no_telp']; ?></td>
                            <td><?= $s['alamat']; ?></td>
                            <th>
                                <a href="<?= base_url('supplier/edit/') . $s['id_supplier'] ?>" class="btn btn-circle btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                                <a onclick="return confirm('Yakin ingin hapus?')" href="<?= base_url('supplier/delete/') . $s['id_supplier'] ?>" class="btn btn-circle btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                            </th>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="6" class="text-center">
                            Data Kosong
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>