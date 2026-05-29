<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-bottom-primary">
            <div class="card-header bg-white py-3">
                <div class="row">
                    <div class="col">
                        <h4 class="h5 align-middle m-0 font-weight-bold text-dark-grey">
                            Form Input Barang Masuk
                        </h4>
                    </div>
                    <div class="col-auto">
                        <a href="<?= base_url('barangmasuk') ?>" class="btn btn-sm btn-secondary btn-icon-split">
                            <span class="icon">
                                <i class="fa fa-arrow-left"></i>
                            </span>
                            <span class="text">
                                Kembali
                            </span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <?= form_open(); ?>

                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="tanggal">Tanggal Masuk</label>
                    <div class="col-md-6">
                        <input value="<?= set_value('tanggal', date('Y-m-d')); ?>" name="tanggal" id="Tanggal"
                            type="text" class="form-control date" placeholder="Tanggal Masuk...">
                        <?= form_error('tanggal', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>

                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="supplier_id">Supplier</label>
                    <div class="col-md-6">
                        <div class="input-group">
                            <select name="supplier_id" id="supplier_id" class="form-control">
                                <option value="">Pilih Supplier</option>
                                <?php foreach ($supplier as $s): ?>
                                    <option value="<?= $s['id_supplier'] ?>" <?= set_select('supplier_id', $s['id_supplier']); ?>><?= $s['nama_supplier'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="input-group-append">
                                <a class="btn btn-secondary" href="<?= base_url('supplier/add'); ?>"><i
                                        class="fa fa-plus"></i></a>
                            </div>
                        </div>
                        <?= form_error('supplier_id', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>

                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="nota">Nota</label>
                    <div class="col-md-6">
                        <input value="<?= set_value('nota'); ?>" name="nota" id="nota" type="text" class="form-control"
                            placeholder="Nota Barang...">
                        <?= form_error('nota', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>

                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="id_jenis">Kelompok Barang</label>
                    <div class="col-md-6">
                        <div class="input-group">
                            <select id="id_jenis" name="id_jenis" class="form-control">
                                <option value="">-- Pilih Kelompok --</option>
                                <?php foreach ($jenis as $j): ?>
                                    <option value="<?= $j['id_jenis'] ?>" <?= set_select('id_jenis', $j['id_jenis']) ?>>
                                        <?= $j['nama_jenis'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="input-group-append">
                                <a class="btn btn-secondary" href="<?= base_url('jenis/add'); ?>"><i
                                        class="fa fa-plus"></i></a>
                            </div>
                        </div>
                        <?= form_error('id_jenis', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>

                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="barang_id">Nama Barang</label>
                    <div class="col-md-6">
                        <div class="input-group">
                            <select id="barang_id" name="barang_id" class="custom-select">
                                <option value="" selected disabled>-- Pilih Barang --</option>
                            </select>
                            <div class="input-group-append">
                                <a class="btn btn-secondary" href="<?= base_url('barang/add'); ?>"><i
                                        class="fa fa-plus"></i></a>
                            </div>
                        </div>
                        <?= form_error('barang_id', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>

                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="stok">Stok Saat Ini</label>
                    <div class="col-md-6">
                        <input readonly name="stok" id="stok" type="text" class="form-control">
                    </div>
                </div>

                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="harga_setelah_potongan">Harga Beli</label>
                    <div class="col-md-6">
                        <input readonly value="<?= set_value('harga_setelah_potongan'); ?>"
                            name="harga_setelah_potongan" id="harga_setelah_potongan" type="number" class="form-control"
                            placeholder="Harga Beli...">
                        <?= form_error('harga_beli', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>

                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="jumlah_masuk">Jumlah Masuk</label>
                    <div class="col-md-6">
                        <input value="<?= set_value('jumlah_masuk'); ?>" name="jumlah_masuk" id="jumlah_masuk"
                            type="number" class="form-control" placeholder="Jumlah Masuk...">
                        <?= form_error('jumlah_masuk', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>

                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="total">Total</label>
                    <div class="col-md-6">
                        <input readonly name="total" id="total" type="number" class="form-control">
                    </div>
                </div>

                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="tunai">Tunai</label>
                    <div class="col-md-6">
                        <input value="<?= set_value('tunai'); ?>" name="tunai" id="tunai" type="number"
                            class="form-control" placeholder="Tunai...">
                        <?= form_error('tunai', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="kredit">Kredit</label>
                    <div class="col-md-6">
                        <input value="<?= set_value('kredit'); ?>" name="kredit" id="kredit" type="number"
                            class="form-control" placeholder="Kredit...">
                        <?= form_error('kredit', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>


                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="keterangan">Keterangan</label>
                    <div class="col-md-6">
                        <textarea name="keterangan" id="keterangan" class="form-control"
                            placeholder="Keterangan..."><?= set_value('keterangan'); ?></textarea>
                        <?= form_error('keterangan', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </div>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        // Dropdown Jenis Barang
        $('#id_jenis').change(function () {
            var id_jenis = $(this).val();
            if (id_jenis != '') {
                var url = '<?= base_url("barangmasuk/get_barang_by_jenis/") ?>' + id_jenis;
                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        var html = '<option value="">-- Pilih Barang --</option>';
                        if (Array.isArray(data) && data.length > 0) {
                            $.each(data, function (i, barang) {
                                html += '<option value="' + barang.id_barang + '">' + barang.nama_barang + '</option>';
                            });
                        } else {
                            html += '<option value="">(Tidak ada barang ditemukan)</option>';
                        }
                        $('#barang_id').html(html);
                    },
                    error: function (xhr, status, error) {
                        alert('Gagal memuat data barang!\n' + xhr.responseText);
                        $('#barang_id').html('<option value="">-- Pilih Barang --</option>');
                    }
                });
            } else {
                $('#barang_id').html('<option value="">-- Pilih Barang --</option>');
            }
        });

        // Dropdown Barang - Ambil detail barang
        $('#barang_id').change(function () {
            var barang_id = $(this).val();
            if (barang_id) {
                var url = '<?= base_url('barangmasuk/get_barang_details/') ?>' + barang_id;
                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        if (typeof data === 'object' && data !== null) {
                            $('#stok').val(data.stok);
                            if ($('#harga_beli').val() === '') {
                                $('#harga_beli').val(data.harga_beli);
                            }
                            hitungTotal();
                        } else {
                            $('#stok').val('');
                            $('#harga_beli').val('');
                            $('#total').val('');
                        }
                    },
                    error: function (xhr, status, error) {
                        alert('Gagal memuat detail barang!\n' + xhr.responseText);
                        $('#stok').val('');
                        $('#harga_beli').val('');
                        $('#total').val('');
                    }
                });
            } else {
                $('#stok').val('');
                $('#harga_beli').val('');
                $('#total').val('');
            }
        });

        // Kalkulasi total otomatis
        function hitungTotal() {
            var jumlah = parseFloat($('#jumlah_masuk').val()) || 0;
            var harga = parseFloat($('#harga_beli').val()) || 0;
            var total = jumlah * harga;
            $('#total').val(total);
        }

        $('#jumlah_masuk, #harga_beli').on('input', function () {
            hitungTotal();
        });

        // Hitung total juga jika barang dipilih (harga_beli bisa otomatis terisi)
        $('#barang_id').change(function () {
            var barang_id = $(this).val();
            if (barang_id) {
                var url = '<?= base_url('barangmasuk/get_barang_details/') ?>' + barang_id;
                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        if (typeof data === 'object' && data !== null) {
                            $('#stok').val(data.stok);
                            $('#harga_setelah_potongan').val(data.harga_setelah_potongan);
                            hitungTotal();
                        } else {
                            $('#stok').val('');
                            $('#harga_setelah_potongan').val('');
                            $('#total').val('');
                        }
                    },
                    error: function (xhr, status, error) {
                        alert('Gagal memuat detail barang!\n' + xhr.responseText);
                        $('#stok').val('');
                        $('#harga_setelah_potongan').val('');
                        $('#total').val('');
                    }
                });
            } else {
                $('#stok').val('');
                $('#harga_setelah_potongan').val('');
                $('#total').val('');
            }
        });

        // Kalkulasi total otomatis
        function hitungTotal() {
            var jumlah = parseFloat($('#jumlah_masuk').val()) || 0;
            var harga = parseFloat($('#harga_setelah_potongan').val()) || 0;
            var total = jumlah * harga;
            $('#total').val(total);
        }

        $('#jumlah_masuk, #harga_setelah_potongan').on('input', function () {
            hitungTotal();
        });

    });
</script>