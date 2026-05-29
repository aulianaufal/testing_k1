<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Stok extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cek_login();

        $this->load->model('Admin_model', 'admin');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['title'] = "Laporan Stok";
        $data['stok'] = $this->admin->getStokInventori();
        $this->template->load('template/dashboard', 'stok/data', $data);
    }

    public function filter()
{
    $data['title'] = "Filter Laporan Stok";
    $data['stok'] = []; // Initialize empty array
    
    // Jika ada filter yang dikirim
    if ($this->input->post()) {
        $filter = [
            'bulan' => $this->input->post('bulan')
        ];
        
        // Validasi input
        $this->form_validation->set_rules('bulan', 'Bulan', 'required|trim');
        
        if ($this->form_validation->run() === TRUE) {
            $data['stok'] = $this->admin->getStokInventoriFilter($filter);
            $data['filter'] = $filter;
            
            if (empty($data['stok'])) {
                $this->session->set_flashdata('warning', 'Tidak ada data yang sesuai dengan filter yang dipilih.');
            }
        } else {
            $this->session->set_flashdata('error', 'Terjadi kesalahan dalam validasi data filter.');
        }
    }
    
    $this->template->load('template/dashboard', 'stok/filter', $data);
}

    // Method untuk reset filter
    public function reset_filter()
    {
        redirect('stok/filter');
    }

    public function detail($barang_id = null)
    {
        if (!$barang_id || !is_numeric($barang_id)) {
            $this->session->set_flashdata('error', 'ID Barang tidak valid');
            redirect('stok');
        }

        $data['title'] = "Detail Stok Barang";
        $data['barang'] = $this->admin->get('barang', ['id_barang' => $barang_id]);
        $data['detail_stok'] = $this->admin->getDetailStokBarang($barang_id);
        
        if (!$data['barang']) {
            $this->session->set_flashdata('error', 'Barang tidak ditemukan');
            redirect('stok');
        }

        $this->template->load('template/dashboard', 'stok/detail', $data);
    }

    private function _updateStok($id)
    {
        // Validasi form
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required|trim');
        $this->form_validation->set_rules('barang_id', 'Barang', 'required|numeric');
        $this->form_validation->set_rules('supplier_id', 'Supplier', 'required|numeric');
        $this->form_validation->set_rules('stok_awal', 'Stok Awal', 'required|numeric');
        $this->form_validation->set_rules('barang_masuk', 'Barang Masuk', 'required|numeric');
        $this->form_validation->set_rules('barang_keluar', 'Barang Keluar', 'required|numeric');
        $this->form_validation->set_rules('harga_beli', 'Harga Beli', 'required|numeric');

        if ($this->form_validation->run() === TRUE) {
            $stok_awal = $this->input->post('stok_awal');
            $barang_masuk = $this->input->post('barang_masuk');
            $barang_keluar = $this->input->post('barang_keluar');
            $harga_beli = $this->input->post('harga_beli');
            
            // Perhitungan yang benar
            $barang_tersedia = $stok_awal + $barang_masuk;  // Stok tersedia sebelum barang keluar
            $persediaan_akhir = $barang_tersedia - $barang_keluar; // Stok akhir setelah barang keluar
            
            // Harga rata-rata (dalam kasus ini sama dengan harga beli karena satu transaksi)
            $harga_rata_rata = $harga_beli;
            
            // Harga persediaan akhir
            $harga_persediaan_akhir = $persediaan_akhir * $harga_beli;

            $data = [
                'tanggal' => $this->input->post('tanggal'),
                'barang_id' => $this->input->post('barang_id'),
                'supplier_id' => $this->input->post('supplier_id'),
                'stok_awal' => $stok_awal,
                'barang_masuk' => $barang_masuk,
                'barang_keluar' => $barang_keluar,
                'barang_tersedia' => $barang_tersedia,
                'persediaan_akhir' => $persediaan_akhir,
                'harga_beli' => $harga_beli,
                'harga_rata_rata' => $harga_rata_rata,
                'harga_persediaan_akhir' => $harga_persediaan_akhir,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            if ($this->admin->update('stok', 'id', $id, $data)) {
                $this->session->set_flashdata('success', 'Data stok berhasil diupdate');
                redirect('stok');
            } else {
                $this->session->set_flashdata('error', 'Gagal mengupdate data stok');
            }
        } else {
            $this->session->set_flashdata('error', validation_errors());
        }
    }

    public function export_excel()
    {
        // Check if PHPExcel library exists
        if (!class_exists('PHPExcel')) {
            $this->session->set_flashdata('error', 'Library PHPExcel tidak ditemukan');
            redirect('stok');
        }

        try {
            $filter = [
                'tanggal_dari' => $this->input->get('tanggal_dari'),
                'tanggal_sampai' => $this->input->get('tanggal_sampai'),
                'jenis_id' => $this->input->get('jenis_id'),
                'supplier_id' => $this->input->get('supplier_id'),
                'barang_id' => $this->input->get('barang_id')
            ];
            
            // Jika tidak ada filter dari GET, ambil dari POST (jika ada)
            if (empty(array_filter($filter))) {
                $filter = [
                    'tanggal_dari' => $this->input->post('tanggal_dari'),
                    'tanggal_sampai' => $this->input->post('tanggal_sampai'),
                    'jenis_id' => $this->input->post('jenis_id'),
                    'supplier_id' => $this->input->post('supplier_id'),
                    'barang_id' => $this->input->post('barang_id')
                ];
            }
            
            // Jika masih tidak ada filter, ambil semua data
            if (empty(array_filter($filter))) {
                $stok_data = $this->admin->getStokInventori();
            } else {
                $stok_data = $this->admin->getStokInventoriFilter($filter);
            }
            
            if (empty($stok_data)) {
                $this->session->set_flashdata('warning', 'Tidak ada data untuk diekspor');
                redirect('stok');
                return;
            }
            
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->setActiveSheetIndex(0);
            
            // Set document properties
            $objPHPExcel->getProperties()
                ->setCreator("Sistem Inventori")
                ->setLastModifiedBy("Sistem Inventori")
                ->setTitle("Laporan Stok Inventori")
                ->setSubject("Laporan Stok")
                ->setDescription("Laporan stok inventori barang");
            
            // Header
            $objPHPExcel->getActiveSheet()->setCellValue('A1', 'LAPORAN STOK INVENTORI');
            $objPHPExcel->getActiveSheet()->mergeCells('A1:L1');
            
            // Style header
            $headerStyle = [
                'font' => ['bold' => true, 'size' => 16],
                'alignment' => ['horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER]
            ];
            $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($headerStyle);
            
            // Sub header dengan filter
            $row = 3;
            if (!empty($filter['tanggal_dari']) && !empty($filter['tanggal_sampai'])) {
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, 'Periode: ' . date('d-m-Y', strtotime($filter['tanggal_dari'])) . ' s/d ' . date('d-m-Y', strtotime($filter['tanggal_sampai'])));
                $row++;
            }
            
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, 'Tanggal Cetak: ' . date('d-m-Y H:i:s'));
            $row += 2;
            
            // Header tabel
            $headers = [
                'A' => 'No',
                'B' => 'Tanggal',
                'C' => 'Jenis Barang',
                'D' => 'Nama Barang',
                'E' => 'Satuan',
                'F' => 'Supplier',
                'G' => 'Stok Awal',
                'H' => 'Barang Masuk',
                'I' => 'Barang Keluar',
                'J' => 'Barang Tersedia',
                'K' => 'Persediaan Akhir',
                'L' => 'Harga Beli'
            ];
            
            foreach ($headers as $col => $header) {
                $objPHPExcel->getActiveSheet()->setCellValue($col . $row, $header);
            }
            
            // Style header tabel
            $tableHeaderStyle = [
                'font' => ['bold' => true],
                'fill' => [
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => ['rgb' => 'E2E8F0']
                ],
                'borders' => [
                    'allborders' => [
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    ]
                ]
            ];
            $objPHPExcel->getActiveSheet()->getStyle('A' . $row . ':L' . $row)->applyFromArray($tableHeaderStyle);
            
            // Data
            $no = 1;
            $row++;
            foreach ($stok_data as $stok) {
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $no++);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, date('d-m-Y', strtotime($stok['tanggal'])));
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $stok['nama_jenis'] ?? '');
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $stok['nama_barang'] ?? '');
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $stok['nama_satuan'] ?? '');
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $row, $stok['nama_supplier'] ?? '');
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $row, $stok['stok_awal'] ?? 0);
                $objPHPExcel->getActiveSheet()->setCellValue('H' . $row, $stok['barang_masuk'] ?? 0);
                $objPHPExcel->getActiveSheet()->setCellValue('I' . $row, $stok['barang_keluar'] ?? 0);
                $objPHPExcel->getActiveSheet()->setCellValue('J' . $row, $stok['barang_tersedia'] ?? 0);
                $objPHPExcel->getActiveSheet()->setCellValue('K' . $row, $stok['persediaan_akhir'] ?? 0);
                $objPHPExcel->getActiveSheet()->setCellValue('L' . $row, $stok['harga_beli'] ?? 0);
                $row++;
            }
            
            // Style data rows
            $dataStyle = [
                'borders' => [
                    'allborders' => [
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    ]
                ]
            ];
            $objPHPExcel->getActiveSheet()->getStyle('A5:L' . ($row - 1))->applyFromArray($dataStyle);
            
            // Auto size columns
            foreach (range('A', 'L') as $col) {
                $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
            }
            
            $filename = 'Laporan_Stok_' . date('Y-m-d_H-i-s') . '.xlsx';
            
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');
            header('Cache-Control: max-age=1');
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
            header('Cache-Control: cache, must-revalidate');
            header('Pragma: public');
            
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save('php://output');
            
        } catch (Exception $e) {
            $this->session->set_flashdata('error', 'Terjadi kesalahan saat mengekspor data: ' . $e->getMessage());
            redirect('stok');
        }
    }

    // AJAX untuk mendapatkan barang berdasarkan jenis
    public function get_barang_by_jenis($jenis_id = null)
    {
        if (!$jenis_id || !is_numeric($jenis_id)) {
            $response = ['status' => 'error', 'message' => 'ID Jenis tidak valid', 'data' => []];
        } else {
            $barang = $this->admin->get_barang_by_jenis($jenis_id);
            $response = [
                'status' => 'success',
                'message' => 'Data berhasil diambil',
                'data' => $barang
            ];
        }
        
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }

    public function delete($id = null)
    {
        if (!$id || !is_numeric($id)) {
            $this->session->set_flashdata('error', 'ID tidak valid');
            redirect('stok');
        }

        // Check if data exists
        $stok = $this->admin->get('stok', ['id' => $id]);
        if (!$stok) {
            $this->session->set_flashdata('error', 'Data stok tidak ditemukan');
            redirect('stok');
        }

        if ($this->admin->delete('stok', 'id', $id)) {
            $this->session->set_flashdata('success', 'Data stok berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data stok');
        }
        
        redirect('stok');
    }
}