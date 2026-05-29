 <?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_model extends CI_Model
{
    public function get($table, $data = null, $where = null)
    {
        if ($data != null) {
            return $this->db->get_where($table, $data)->row_array();
        } else {
            return $this->db->get_where($table, $where)->result_array();
        }
    }

    public function update($table, $pk, $id, $data)
    {
        $this->db->where($pk, $id);
        return $this->db->update($table, $data);
    }

    public function insert($table, $data, $batch = false)
    {
        return $batch ? $this->db->insert_batch($table, $data) : $this->db->insert($table, $data);
    }

    public function delete($table, $pk, $id)
    {
        return $this->db->delete($table, [$pk => $id]);
    }

    public function getUsers($id)
    {
        $this->db->where('id_user !=', $id);
        return $this->db->get('user')->result_array();
    }
    /**
     * Method untuk debugging struktur database
     */
    public function checkDatabaseStructure()
    {
        $result = [];
        
        // Cek tabel barang_masuk
        if ($this->db->table_exists('barang_masuk')) {
            $fields = $this->db->field_data('barang_masuk');
            $result['barang_masuk'] = array_column($fields, 'name');
        }
        
        // Cek tabel barang_keluar
        if ($this->db->table_exists('barang_keluar')) {
            $fields = $this->db->field_data('barang_keluar');
            $result['barang_keluar'] = array_column($fields, 'name');
        }
        
        // Cek tabel barang
        if ($this->db->table_exists('barang')) {
            $fields = $this->db->field_data('barang');
            $result['barang'] = array_column($fields, 'name');
        }
        
        // Cek tabel jenis
        if ($this->db->table_exists('jenis')) {
            $fields = $this->db->field_data('jenis');
            $result['jenis'] = array_column($fields, 'name');
        }
        
        // Cek tabel satuan
        if ($this->db->table_exists('satuan')) {
            $fields = $this->db->field_data('satuan');
            $result['satuan'] = array_column($fields, 'name');
        }
        
        // Cek tabel supplier
        if ($this->db->table_exists('supplier')) {
            $fields = $this->db->field_data('supplier');
            $result['supplier'] = array_column($fields, 'name');
        }
        
        // Cek tabel customer
        if ($this->db->table_exists('customer')) {
            $fields = $this->db->field_data('customer');
            $result['customer'] = array_column($fields, 'name');
        }
        
        return $result;
    }

    /**
     * Method untuk mendapatkan sample data untuk debugging
     */
    public function getSampleData($table, $limit = 5)
    {
        if (!$this->db->table_exists($table)) {
            return [];
        }
        
        $this->db->limit($limit);
        return $this->db->get($table)->result_array();
    }

    // Method lainnya tetap sama...
    public function count($table)
    {
        return $this->db->count_all($table);
    }

    public function sum($table, $field)
    {
        $this->db->select_sum($field);
        return $this->db->get($table)->row_array()[$field];
    }

    public function min($table, $field, $min)
    {
        $field = $field . ' <=';
        $this->db->where($field, $min);
        return $this->db->get($table)->result_array();
    }

    public function getMax($table, $field, $kode = null)
    {
        $this->db->select_max($field);
        if ($kode != null) {
            $this->db->like($field, $kode, 'after');
        }
        return $this->db->get($table)->row_array()[$field];
    }

    public function get_barang_by_jenis($jenis_id)
    {
        $this->db->select('id_barang, nama_barang');
        $this->db->from('barang');
        $this->db->where('id_jenis', $jenis_id);
        return $this->db->get()->result_array();
    }

    public function chartBarangMasuk($bulan)
    {
        $this->db->select('COUNT(*) AS total');
        $this->db->from('barang_masuk');
        $this->db->where('MONTH(tanggal_masuk)', $bulan);
        $query = $this->db->get();
        return $query->row()->total;
    }

    public function getBarangMasuk($limit = null)
    {
        $this->db->select('bm.id_barang_masuk as transaksi_id, bm.tanggal_masuk as tanggal, s.nama_supplier, j.nama_jenis, b.nama_barang, sat.nama_satuan, bm.jumlah_masuk');
        $this->db->from('barang_masuk bm');
        $this->db->join('supplier s', 'bm.supplier_id = s.id_supplier', 'left');
        $this->db->join('barang b', 'bm.barang_id = b.id_barang', 'left');
        $this->db->join('jenis j', 'b.jenis_id = j.id_jenis', 'left');
        $this->db->join('satuan sat', 'b.satuan_id = sat.id_satuan', 'left');
        $this->db->order_by('bm.tanggal_masuk', 'desc');
        if ($limit !== null) {
            $this->db->limit($limit);
        }
        return $this->db->get()->result_array();
    }

    public function getBarangKeluar($limit = null)
    {
        $this->db->select('bk.id_barang_keluar, bk.tanggal_keluar, j.nama_jenis, b.nama_barang, sat.nama_satuan, bk.jumlah_keluar');
        $this->db->from('barang_keluar bk');
        $this->db->join('barang b', 'bk.barang_id = b.id_barang', 'left');
        $this->db->join('jenis j', 'b.jenis_id = j.id_jenis', 'left');
        $this->db->join('satuan sat', 'b.satuan_id = sat.id_satuan', 'left');
        $this->db->order_by('bk.tanggal_keluar', 'desc');
        if ($limit !== null) {
            $this->db->limit($limit);
        }
        return $this->db->get()->result_array();
    }

    public function getBarang()
    {
        $this->db->select('bg.*, j.nama_jenis, s.nama_satuan, sp.nama_supplier');
        $this->db->from('barang bg');
        $this->db->join('jenis j', 'j.id_jenis = bg.jenis_id', 'left');
        $this->db->join('satuan s', 's.id_satuan = bg.satuan_id', 'left');
        $this->db->join('supplier sp', 'sp.id_supplier = bg.id_supplier', 'left');
        return $this->db->get()->result_array();
    }

    public function chartBarangKeluar($bulan)
    {
        $like = 'T-BK-' . date('y') . $bulan;
        $this->db->like('id_barang_keluar', $like, 'after');
        return count($this->db->get('barang_keluar')->result_array());
    }

    public function laporan($table, $mulai, $akhir)
    {
        $tgl = $table == 'barang_masuk' ? 'tanggal' : 'tanggal_keluar';
        $this->db->where($tgl . ' >=', $mulai);
        $this->db->where($tgl . ' <=', $akhir);
        return $this->db->get($table)->result_array();
    }

    public function cekStok($id)
    {
        $this->db->join('satuan s', 'bg.satuan_id=s.id_satuan');
        return $this->db->get_where('barang bg', ['id_barang' => $id])->row_array();
    }

    public function getBarangWithSupplier()
    {
        $this->db->select('bg.id_barang, bg.nama_barang, bg.stok, bg.harga_beli, bg.harga_jual, bg.id_supplier, bg.satuan_id as id_satuan, bg.jenis_id as id_jenis, j.nama_jenis, s.nama_satuan, sp.nama_supplier');
        $this->db->from('barang bg');
        $this->db->join('jenis j', 'j.id_jenis = bg.jenis_id');
        $this->db->join('satuan s', 's.id_satuan = bg.satuan_id');
        $this->db->join('supplier sp', 'sp.id_supplier = bg.id_supplier');
        return $this->db->get()->result_array();
    }

    public function getStokInventori()
    {
        $this->db->select('
            s.*,
            bg.nama_barang,
            bg.detail_barang,
            sat.nama_satuan,
            sup.nama_supplier,
            j.nama_jenis
        ');
        $this->db->from('stok s');
        $this->db->join('barang bg', 'bg.id_barang = s.barang_id', 'left');
        $this->db->join('satuan sat', 'sat.id_satuan = bg.satuan_id', 'left');
        $this->db->join('supplier sup', 'sup.id_supplier = s.supplier_id', 'left');
        $this->db->join('jenis j', 'j.id_jenis = bg.jenis_id', 'left');
        $this->db->order_by('s.tanggal', 'DESC');
        $this->db->order_by('bg.nama_barang', 'ASC');

        return $this->db->get()->result_array();
    }

    public function getDetailStokBarang($barang_id)
    {
        $this->db->select('
            s.*,
            sup.nama_supplier,
            DATE_FORMAT(s.created_at, "%d-%m-%Y %H:%i") as waktu_input
        ');
        $this->db->from('stok s');
        $this->db->join('supplier sup', 'sup.id_supplier = s.supplier_id', 'left');
        $this->db->where('s.barang_id', $barang_id);
        $this->db->order_by('s.tanggal', 'DESC');

        return $this->db->get()->result_array();
    }

    public function getRingkasanStok()
    {
        $this->db->select('
            bg.id_barang,
            bg.nama_barang,
            bg.stok as stok_sistem,
            COALESCE(SUM(s.stok_awal), 0) as total_stok_awal,
            COALESCE(SUM(s.barang_masuk), 0) as total_barang_masuk,
            COALESCE(SUM(s.barang_keluar), 0) as total_barang_keluar,
            COALESCE(SUM(s.persediaan_akhir), 0) as total_persediaan_akhir,
            sat.nama_satuan,
            j.nama_jenis
        ');
        $this->db->from('barang bg');
        $this->db->join('stok s', 's.barang_id = bg.id_barang', 'left');
        $this->db->join('satuan sat', 'sat.id_satuan = bg.satuan_id', 'left');
        $this->db->join('jenis j', 'j.id_jenis = bg.jenis_id', 'left');
        $this->db->group_by('bg.id_barang');
        $this->db->order_by('bg.nama_barang', 'ASC');

        return $this->db->get()->result_array();
    }

    public function getStokDashboard()
    {
        $this->db->select('COUNT(*) as total');
        $this->db->from('barang');
        $this->db->where('stok <', 10);
        $stok_menipis = $this->db->get()->row_array()['total'];

        $this->db->select('COUNT(*) as total');
        $this->db->from('barang');
        $total_barang = $this->db->get()->row_array()['total'];

        $this->db->select('COUNT(*) as total');
        $this->db->from('stok');
        $this->db->where('DATE(tanggal)', date('Y-m-d'));
        $transaksi_hari_ini = $this->db->get()->row_array()['total'];

        $this->db->select('SUM(stok * harga_setelah_potongan) as total_nilai');
        $this->db->from('barang');
        $total_nilai = $this->db->get()->row_array()['total_nilai'];

        return [
            'stok_menipis' => $stok_menipis,
            'total_barang' => $total_barang,
            'transaksi_hari_ini' => $transaksi_hari_ini,
            'total_nilai_stok' => $total_nilai ?: 0
        ];
    }

    public function getStokInventoriFilter($filter)
    {
        $this->db->select('s.*, bg.nama_barang, bg.satuan, j.nama_jenis, sp.nama_supplier');
        $this->db->from('stok s');
        $this->db->join('barang bg', 'bg.id_barang = s.barang_id');
        $this->db->join('jenis j', 'j.id_jenis = bg.jenis_id');
        $this->db->join('supplier sp', 'sp.id_supplier = s.supplier_id');

        if (!empty($filter['bulan'])) {
            $bulan = date('m', strtotime($filter['bulan']));
            $tahun = date('Y', strtotime($filter['bulan']));
            $this->db->where('MONTH(s.tanggal)', $bulan);
            $this->db->where('YEAR(s.tanggal)', $tahun);
        }

        $this->db->order_by('s.tanggal', 'ASC');
        return $this->db->get()->result_array();
    }
    /**
     * Method untuk mendapatkan data barang masuk dengan periode tanggal
     */
    public function getLaporanBarangMasuk($mulai, $akhir)
    {
        $this->db->select('
            bm.id_barang_masuk as id,
            bm.tanggal_masuk as tanggal,
            COALESCE(bm.nota, "-") as nota,
            bm.jumlah_masuk,
            COALESCE(bm.harga_setelah_potongan, 0) as harga_setelah_potongan,
            COALESCE(bm.total, 0) as total,
            COALESCE(bm.tunai, 0) as tunai,
            COALESCE(bm.kredit, 0) as kredit,
            COALESCE(bm.keterangan, "-") as keterangan,
            COALESCE(b.nama_barang, "Barang Tidak Diketahui") as nama_barang,
            COALESCE(j.nama_jenis, "Jenis Tidak Diketahui") as nama_jenis,
            COALESCE(s.nama_satuan, "Satuan Tidak Diketahui") as nama_satuan,
            COALESCE(sp.nama_supplier, "Supplier Tidak Diketahui") as nama_supplier
        ');
        $this->db->from('barang_masuk bm');
        $this->db->join('barang b', 'b.id_barang = bm.barang_id', 'left');
        $this->db->join('jenis j', 'j.id_jenis = b.jenis_id', 'left');
        $this->db->join('satuan s', 's.id_satuan = b.satuan_id', 'left');
        $this->db->join('supplier sp', 'sp.id_supplier = bm.supplier_id', 'left');
        $this->db->where('bm.tanggal_masuk >=', $mulai);
        $this->db->where('bm.tanggal_masuk <=', $akhir);
        $this->db->order_by('bm.tanggal_masuk', 'ASC');
        $this->db->order_by('bm.id_barang_masuk', 'ASC');


        return $this->db->get()->result_array();
    }


    /**
     * Method untuk mendapatkan data barang keluar dengan periode tanggal
     */
    public function getLaporanBarangKeluar($mulai, $akhir)
    {
        $this->db->select('
            bk.id_barang_keluar as id,
            bk.tanggal_keluar,
            COALESCE(bk.nota, "-") as nota,
            bk.jumlah_keluar,
            COALESCE(bk.harga_setelah_potongan, bk.harga_jual, 0) as harga_setelah_potongan,
            COALESCE(bk.total, 0) as total,
            COALESCE(bk.tunai, 0) as tunai,
            COALESCE(bk.kredit, 0) as kredit,
            COALESCE(bk.keterangan, "-") as keterangan,
            COALESCE(b.nama_barang, "Barang Tidak Diketahui") as nama_barang,
            COALESCE(j.nama_jenis, "Jenis Tidak Diketahui") as nama_jenis,
            COALESCE(s.nama_satuan, "Satuan Tidak Diketahui") as nama_satuan,
            COALESCE(c.nama_customer, "Customer Tidak Diketahui") as nama_supplier
        ');
        $this->db->from('barang_keluar bk');
        $this->db->join('barang b', 'b.id_barang = bk.barang_id', 'left');
        $this->db->join('jenis j', 'j.id_jenis = b.jenis_id', 'left');
        $this->db->join('satuan s', 's.id_satuan = b.satuan_id', 'left');
        $this->db->join('customer c', 'c.id_customer = bk.customer_id', 'left');
        $this->db->where('bk.tanggal_keluar >=', $mulai);
        $this->db->where('bk.tanggal_keluar <=', $akhir);
        $this->db->order_by('bk.tanggal_keluar', 'ASC');
        $this->db->order_by('bk.id_barang_keluar', 'ASC');
    }
}