<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <style>
        /* Tambahkan gaya CSS untuk tampilan cetak */
    </style>
</head>
<body>
    <div class="container">
        <h1><?= $title ?></h1>
        <p>Periode: <?= $tanggal ?></p>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Supplier</th>
                    <th>Nota</th>
                    <th>Jenis Barang</th>
                    <th>Nama Barang</th>
                    <th>Satuan</th>
                    <th>Jumlah</th>
                    <th>Harga Beli</th>
                    <th>Total</th>
                    <th>Tunai</th>
                    <th>Kredit</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $key => $row): ?>
                    <tr>
                        <td><?= $key + 1 ?></td>
                        <td><?= date('d/m/Y', strtotime($row['tanggal'])) ?></td>
                        <td><?= $row['nama_supplier'] ?></td>
                        <td><?= $row['nota'] ?></td>
                        <td><?= $row['nama_jenis'] ?></td>
                        <td><?= $row['nama_barang'] ?></td>
                        <td><?= $row['nama_satuan'] ?></td>
                        <td><?= $row['jumlah_masuk'] ?></td>
                        <td><?= number_format($row['harga_setelah_potongan'], 0, ',', '.') ?></td>
                        <td><?= number_format($row['total'], 0, ',', '.') ?></td>
                        <td><?= $row['tunai'] ?></td>
                        <td><?= $row['kredit'] ?></td>
                        <td><?= $row['keterangan'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button onclick="window.print();" class="btn btn-primary">Print</button>
    </div>
</body>
</html>
