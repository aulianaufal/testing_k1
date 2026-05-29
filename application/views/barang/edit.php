<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-bottom-primary">
            <div class="card-header bg-white py-3">
                <div class="row">
                    <div class="col">
                        <h4 class="h5 align-middle m-0 font-weight-bold text-dark-grey">
                            Form Edit Barang
                        </h4>
                    </div>
                    <div class="col-auto">
                        <a href="<?= base_url('barang') ?>" class="btn btn-sm btn-secondary btn-icon-split">
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
                <?= form_open('', [], ['id_barang' => $barang['id_barang']]); ?>
                <div class="row form-group">
                    <label class="col-md-3 text-md-right" for="nama_barang">Nama Barang</label>
                    <div class="col-md-9">
                        <input value="<?= set_value('nama_barang', $barang['nama_barang']); ?>" name="nama_barang" id="nama_barang" type="text" class="form-control" placeholder="Nama Barang...">
                        <?= form_error('nama_barang', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-3 text-md-right" for="id_jenis">Jenis Barang</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <select name="id_jenis" id="id_jenis" class="custom-select">
                                <option value="" selected disabled>Pilih Jenis Barang</option>
                                <?php foreach ($jenis as $j) : ?>
                                    <option <?= $barang['id_jenis'] == $j['id_jenis'] ? 'selected' : ''; ?> <?= set_select('id_jenis', $j['id_jenis']) ?> value="<?= $j['id_jenis'] ?>"><?= $j['nama_jenis'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="input-group-append">
                                <a class="btn btn-secondary" href="<?= base_url('jenis/add'); ?>"><i class="fa fa-plus"></i></a>
                            </div>
                        </div>
                        <?= form_error('id_jenis', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-3 text-md-right" for="id_satuan">Satuan Barang</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <select name="id_satuan" id="id_satuan" class="custom-select">
                                <option value="" selected disabled>Pilih Satuan Barang</option>
                                <?php foreach ($satuan as $s) : ?>
                                    <option <?= $barang['id_satuan'] == $s['id_satuan'] ? 'selected' : ''; ?> <?= set_select('id_satuan', $s['id_satuan']) ?> value="<?= $s['id_satuan'] ?>"><?= $s['nama_satuan'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="input-group-append">
                                <a class="btn btn-secondary" href="<?= base_url('satuan/add'); ?>"><i class="fa fa-plus"></i></a>
                            </div>
                        </div>
                        <?= form_error('id_satuan', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-3 text-md-right" for="id_supplier">Supplier</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <select name="id_supplier" id="id_supplier" class="custom-select">
                                <option value="" selected disabled>Pilih Supplier</option>
                                <?php foreach ($supplier as $sup) : ?>
                                    <option <?= $barang['id_supplier'] == $sup['id_supplier'] ? 'selected' : ''; ?> <?= set_select('id_supplier', $sup['id_supplier']) ?> value="<?= $sup['id_supplier'] ?>"><?= $sup['nama_supplier'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="input-group-append">
                                <a class="btn btn-secondary" href="<?= base_url('supplier/add'); ?>"><i class="fa fa-plus"></i></a>
                            </div>
                        </div>
                        <?= form_error('id_supplier', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-3 text-md-right" for="harga_beli">Harga Beli</label>
                    <div class="col-md-9">
                        <input value="<?= set_value('harga_beli', $barang['harga_beli']); ?>" name="harga_beli" id="harga_beli" type="number" class="form-control" placeholder="Harga Beli...">
                        <?= form_error('harga_beli', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-3 text-md-right" for="potongan1">Potongan 1 (%)</label>
                    <div class="col-md-9">
                        <input value="<?= set_value('potongan1', 0); ?>" name="potongan1" id="Potongan1" type="decimal" 
                            class="form-control" placeholder="potongan 1...">
                        <?= form_error('potongan1', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-3 text-md-right" for="potongan2">Potongan 2 (%)</label>
                    <div class="col-md-9">
                        <input value="<?= set_value('potongan2', 0); ?>" name="potongan2" id="Potongan2" type="decimal" 
                            class="form-control" placeholder="potongan 2...">
                        <?= form_error('potongan2', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-3 text-md-right" for="potongan3">Potongan 3 (%)</label>
                    <div class="col-md-9">
                        <input value="<?= set_value('potongan3', 0); ?>" name="potongan3" id="Potongan3" type="decimal" 
                            class="form-control" placeholder="potongan 3...">
                        <?= form_error('potongan3', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                
                <div class="row form-group">
                    <label class="col-md-3 text-md-right" for="ppn">PPN (%)</label>
                    <div class="col-md-9">
                        <select name="ppn" id="ppn" class="form-control">
                            <?php for ($i = 0; $i <= 20; $i++) : ?>
                                <option value="<?= $i ?>" <?= set_select('ppn', $i, $i == $barang['ppn']) ?>><?= $i ?>%</option>
                            <?php endfor; ?>
                        </select>
                        <?= form_error('ppn', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-3 text-md-right" for="harga_jual">Harga Jual</label>
                    <div class="col-md-9">
                        <input type="number" class="form-control" name="harga_jual" id="harga_jual" value="<?= set_value('harga_jual', $barang['harga_jual']); ?>" placeholder="Harga Jual">
                        <?= form_error('harga_jual', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-3 text-md-right" for="stok">Stok</label>
                    <div class="col-md-9">
                        <input value="<?= set_value('stok', $barang['stok']); ?>" name="stok" id="stok" type="number" min="0" class="form-control" placeholder="Stok...">
                        <?= form_error('stok', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-9 offset-md-3">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </div>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>