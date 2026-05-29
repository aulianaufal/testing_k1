<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm border-bottom-primary">
            <div class="card-header bg-white py-3">
                <h4 class="h5 align-middle m-0 font-weight-bold text-dark-grey">
                    Form Laporan
                </h4>
            </div>
            <div class="card-body">
                <?= form_open('laporan/cetak', ['id' => 'laporanForm', 'target' => '_blank']); ?>
                   <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
                <div class="row form-group">
                    <label class="col-md-3 text-md-right" for="transaksi">Laporan Transaksi</label>
                    <div class="col-md-9">
                        <div class="custom-control custom-radio">
                            <input value="barang_masuk" type="radio" id="barang_masuk" name="transaksi"
                                class="custom-control-input" checked required>
                            <label class="custom-control-label" for="barang_masuk">Barang Masuk</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input value="barang_keluar" type="radio" id="barang_keluar" name="transaksi"
                                class="custom-control-input" required>
                            <label class="custom-control-label" for="barang_keluar">Barang Keluar</label>
                        </div>
                        <?= form_error('transaksi', '<span class="text-danger small">', '</span>'); ?>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-lg-3 text-lg-right" for="tanggal_mulai">Tanggal Mulai</label>
                    <div class="col-lg-5">
                        <div class="input-group">
                            <input value="<?= set_value('tanggal_mulai'); ?>" name="tanggal_mulai" id="tanggal_mulai" type="text"
                                class="form-control datepicker" placeholder="Tanggal Mulai" required>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-fw fa-calendar"></i></span>
                            </div>
                        </div>
                        <?= form_error('tanggal_mulai', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-lg-3 text-lg-right" for="tanggal_akhir">Tanggal Akhir</label>
                    <div class="col-lg-5">
                        <div class="input-group">
                            <input value="<?= set_value('tanggal_akhir'); ?>" name="tanggal_akhir" id="tanggal_akhir" type="text"
                                class="form-control datepicker" placeholder="Tanggal Akhir" required>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-fw fa-calendar"></i></span>
                            </div>
                        </div>
                        <?= form_error('tanggal_akhir', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <!-- Hidden field untuk mengirim tanggal gabungan -->
                <input type="hidden" name="tanggal" id="tanggal_gabungan">
                <div class="row form-group">
                    <div class="col-lg-9 offset-lg-3">
                        <button type="button" class="btn btn-secondary btn-icon-split" id="btnCetak">
                            <span class="icon">
                                <i class="fa fa-print"></i>
                            </span>
                            <span class="text">Cetak</span>
                        </button>
                        <button type="button" class="btn btn-info btn-icon-split ml-2" id="btnReset">
                            <span class="icon">
                                <i class="fa fa-refresh"></i>
                            </span>
                            <span class="text">Reset Form</span>
                        </button>
                    </div>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function () {
        let printWindow = null;


        // Initialize datepicker for both fields
        $('.datepicker').daterangepicker({
            singleDatePicker: true,
            locale: {
                format: 'DD/MM/YYYY'
            },
            opens: 'right',
            autoUpdateInput: true
        });


        // Function to update hidden field dengan gabungan tanggal
        function updateTanggalGabungan() {
            var tanggalMulai = $('#tanggal_mulai').val();
            var tanggalAkhir = $('#tanggal_akhir').val();


            if (tanggalMulai && tanggalAkhir) {
                $('#tanggal_gabungan').val(tanggalMulai + ' - ' + tanggalAkhir);
            }
        }


        // Update hidden field saat tanggal berubah
        $('.datepicker').on('apply.daterangepicker', function(ev, picker) {
            updateTanggalGabungan();
        });


        // Handle cetak button click
        $('#btnCetak').on('click', function(e) {
            // Update tanggal gabungan sebelum submit
            updateTanggalGabungan();


            // Validasi tanggal
            var tanggalMulai = $('#tanggal_mulai').val();
            var tanggalAkhir = $('#tanggal_akhir').val();


            if (!tanggalMulai || !tanggalAkhir) {
                alert('Mohon lengkapi tanggal mulai dan tanggal akhir');
                return false;
            }


            // Convert tanggal untuk validasi
            var mulai = moment(tanggalMulai, 'DD/MM/YYYY');
            var akhir = moment(tanggalAkhir, 'DD/MM/YYYY');


            if (mulai.isAfter(akhir)) {
                alert('Tanggal mulai tidak boleh lebih besar dari tanggal akhir');
                return false;
            }


            // Disable tombol sementara
            $('#btnCetak').prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Memproses...');


            // Tutup window print sebelumnya jika masih ada
            if (printWindow && !printWindow.closed) {
                printWindow.close();
            }


            // Ambil data form
            var transaksi = $('input[name="transaksi"]:checked').val();
            var tanggal = $('#tanggal_gabungan').val();


            // Buka window baru untuk cetak
            printWindow = window.open('', 'printWindow', 'width=1200,height=800,scrollbars=yes,resizable=yes');
            printWindow.document.write('<html><head><title>Loading...</title></head><body><div style="text-align:center;padding:50px;"><h3>Memuat laporan...</h3><div class="spinner"></div></body></html>');


            // Buat form baru untuk dikirim ke window baru
            var form = $('<form>', {
                'method': 'POST',
                'action': '<?= base_url("laporan/cetak") ?>',
                'target': 'printWindow'
            });


            // Tambahkan input fields
            form.append($('<input>', {
                'type': 'hidden',
                'name': 'transaksi',
                'value': transaksi
            }));


            form.append($('<input>', {
                'type': 'hidden',
                'name': 'tanggal',
                'value': tanggal
            }));


            form.append($('<input>', {
                'type': 'hidden',
                'name': 'action',
                'value': 'print'
            }));


            // Tambahkan form ke body, submit, lalu hapus
            $('body').append(form);
            form.submit();
            form.remove();


            // Monitor print window untuk auto refresh
            var checkClosed = setInterval(function() {
                if (printWindow.closed) {
                    clearInterval(checkClosed);
                    // Re-enable tombol
                    $('#btnCetak').prop('disabled', false).html('<span class="icon"><i class="fa fa-print"></i></span><span class="text">Cetak</span>');
                }
            }, 1000);


            // Auto enable tombol setelah 3 detik (fallback)
            setTimeout(function() {
                $('#btnCetak').prop('disabled', false).html('<span class="icon"><i class="fa fa-print"></i></span><span class="text">Cetak</span>');
            }, 3000);
        });


        // Reset form function
        function resetForm() {
            $('#laporanForm')[0].reset();
            $('#barang_masuk').prop('checked', true);
            $('#tanggal_gabungan').val('');


            // Reset datepicker
            $('.datepicker').val('');
        }


        // Handle reset button
        $('#btnReset').on('click', function() {
            resetForm();
        });


        // Auto focus pada tanggal mulai saat halaman dimuat
        setTimeout(function() {
            $('#tanggal_mulai').focus();
        }, 500);
    });
</script>


<style>
    .spinner-border-sm {
        width: 1rem;
        height: 1rem;
    }


    .spinner-border {
        display: inline-block;
        width: 2rem;
        height: 2rem;
        vertical-align: text-bottom;
        border: .25em solid currentColor;
        border-right-color: transparent;
        border-radius: 50%;
        animation: spinner-border .75s linear infinite;
    }


    @keyframes spinner-border {
        to { transform: rotate(360deg); }
    }
</style>