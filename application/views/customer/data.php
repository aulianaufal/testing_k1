<div class="card shadow-sm border-bottom-secondary">
    <div class="card-header bg-dark py-3">
        <div class="row">
            <div class="col">
                <h4 class="h5 align-middle m-0 font-weight-bold text-white">
                    Data Customer
                </h4>
            </div>
            <div class="col-auto">
                <a href="<?= base_url('customer/add') ?>" class="btn btn-sm btn-secondary btn-icon-split">
                    <span class="icon">
                        <i class="fa fa-plus"></i>
                    </span>
                    <span class="text">
                        Tambah Customer
                    </span>
                </a>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped w-100 dt-responsive nowrap" id="dataTable">
            <thead class="thead-light">
                <tr>
                    <th style="background: greenyellow;">NO.</th>
                    <th style="background: greenyellow;">NAMA</th>
                    <th style="background: greenyellow;">ALAMAT</th>
                    <th style="background: greenyellow;">Nomor Telepon</th>
                    <th style="background: greenyellow;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($customer) :
                    $no = 1;
                    foreach ($customer as $s) :
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $s['nama_customer']; ?></td>
                            <td><?= $s['alamat_customer']; ?></td>
                            <td><?= $s['telepon_customer']; ?></td>
                            <th>
                                <a href="<?= base_url('customer/edit/') . $s['id_customer'] ?>" class="btn btn-circle btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                                <a onclick="return confirm('Yakin ingin hapus?')" href="<?= base_url('customer/delete/') . $s['id_customer'] ?>" class="btn btn-circle btn-danger btn-sm"><i class="fa fa-trash"></i></a>
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