<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Load library phpspreadsheet
require('./vendor/excel/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// End load library phpspreadsheet

class UserAdmin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('nilai_admin_login') != '1') {

            $this->session->set_flashdata('alert', '<div class="alert alert-danger alert-dismissable">
        		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        		<p>Anda belum login!</p>
        		</div>');
            redirect('nilai/login');
        }

        $this->load->model("nilai/mUserAdmin");
        $this->load->helper(array('url', 'download'));
        $this->load->library('form_validation', 'excel');
    }

    public function index()
    {
        $lang = $this->mUserAdmin->switchLang($this->session->userdata('nilai_bahasa'))->result();

        foreach ($lang as $d) {
            $data['lan_' . $d->id_multi_bahasa] = $d->translate;
        }

        $data['title']      = getDateIndo();
        $data['subtitle']   = "Dashboard";

        $sort = $this->input->get('short');

        $data['countMhs'] = $this->mUserAdmin->dataIndex('penilaian_absensi.id_penilaian_mahasiswa', 'penilaian_mahasiswa.nama_mahasiswa ASC')->num_rows();
        $data['countDsn'] = $this->mUserAdmin->dataIndex('penilaian_jadwal.id_penilaian_dosen', 'penilaian_mahasiswa.nama_mahasiswa ASC')->num_rows();
        $data['countMkl'] = $this->mUserAdmin->dataIndex('penilaian_jadwal.id_penilaian_matakuliah', 'penilaian_mahasiswa.nama_mahasiswa ASC')->num_rows();

        if ($sort == 2) {
            $data['dataIndex'] = $this->mUserAdmin->dataIndex('penilaian_jadwal.id_penilaian_dosen', 'penilaian_mahasiswa.nama_mahasiswa ASC')->result();
        } elseif ($sort == 3) {
            $data['dataIndex'] = $this->mUserAdmin->dataIndex('penilaian_jadwal.id_penilaian_matakuliah', 'penilaian_mahasiswa.nama_mahasiswa ASC')->result();
        } else {
            $data['dataIndex'] = $this->mUserAdmin->dataIndex('penilaian_mahasiswa.id_penilaian_mahasiswa', 'penilaian_mahasiswa.nama_mahasiswa ASC')->result();
        }

        $this->load->view('templates/header', $data);
        $this->load->view('nilai/admin/vDashboard', $data);
        $this->load->view('templates/footer', $data);
    }

    public function dataTab()
    {
        $lang = $this->mUserAdmin->switchLang($this->session->userdata('nilai_bahasa'))->result();

        foreach ($lang as $d) {
            $data['lan_' . $d->id_multi_bahasa] = $d->translate;
        }

        $data['title']      = getDateIndo();
        $data['subtitle']   = "Dashboard";

        $sort = $this->input->get('sort');

        $data['countMhs'] = $this->mUserAdmin->dataIndex('penilaian_absensi.id_penilaian_mahasiswa', 'penilaian_mahasiswa.nama_mahasiswa ASC')->num_rows();
        $data['countDsn'] = $this->mUserAdmin->dataIndex('penilaian_jadwal.id_penilaian_dosen', 'penilaian_mahasiswa.nama_mahasiswa ASC')->num_rows();
        $data['countMkl'] = $this->mUserAdmin->dataIndex('penilaian_jadwal.id_penilaian_matakuliah', 'penilaian_mahasiswa.nama_mahasiswa ASC')->num_rows();

        if ($sort == 2) {
            $data['dataTab'] = $this->mUserAdmin->dataDosen()->result();
        }

        $this->load->view('templates/header', $data);
        $this->load->view('nilai/admin/vDataTab', $data);
        $this->load->view('templates/footer', $data);
    }

    public function dataJadwal()
    {
        $lang = $this->mUserAdmin->switchLang($this->session->userdata('nilai_bahasa'))->result();

        foreach ($lang as $d) {
            $data['lan_' . $d->id_multi_bahasa] = $d->translate;
        }

        $data['title']      = getDateIndo();
        $data['subtitle']   = "Dashboard";

        $data['dataJadwal']  = $this->mUserAdmin->dataJadwal()->result();

        $this->load->view('templates/header', $data);
        $this->load->view('nilai/admin/vDataJadwal', $data);
        $this->load->view('templates/footer', $data);
    }

    public function dataAbsensi()
    {
        $lang = $this->mUserAdmin->switchLang($this->session->userdata('nilai_bahasa'))->result();

        foreach ($lang as $d) {
            $data['lan_' . $d->id_multi_bahasa] = $d->translate;
        }

        $data['title']      = getDateIndo();
        $data['subtitle']   = "Dashboard";

        $data['dataAbsensi']  = $this->mUserAdmin->dataAbsensi()->result();

        $this->load->view('templates/header', $data);
        $this->load->view('nilai/admin/vDataAbsensi', $data);
        $this->load->view('templates/footer', $data);
    }

    // Upload excel absen
    public function uploadAbsen()
    {
        $upload_file    = $_FILES['upload_file']['name'];
        $extension      = pathinfo($upload_file, PATHINFO_EXTENSION);

        if ($extension == 'csv') {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
        } else if ($extension == 'xls') {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        } else {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        }

        $spreadsheet    = $reader->load($_FILES['upload_file']['tmp_name']);
        $sheetdata      = $spreadsheet->getActiveSheet()->toArray();
        $sheetcount     = count($sheetdata);

        if ($sheetcount > 1) {
            $data   = array();

            for ($i = 1; $i < $sheetcount; $i++) {
                $id_mahasiswa           = $sheetdata[$i][0];
                $id_matakuliah          = $sheetdata[$i][1];
                $id_penilaian_semester  = $this->input->post('id_penilaian_semester');

                $data[] = array(
                    'id_penilaian_mahasiswa'    => $id_mahasiswa,
                    'id_penilaian_semester'     => $id_penilaian_semester,
                    'id_penilaian_matakuliah'   => $id_matakuliah,
                );
            }

            if ($this->mUserAdmin->insert_batch('penilaian_absensi', $data)) {
                $this->session->set_flashdata('success', 'Berhasil upload data');
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $this->session->set_flashdata('error', 'Gagal upload data');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }

    // Upload excel jadwal
    public function uploadJadwal()
    {
        $upload_file    = $_FILES['upload_file']['name'];
        $extension      = pathinfo($upload_file, PATHINFO_EXTENSION);

        if ($extension == 'csv') {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
        } else if ($extension == 'xls') {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        } else {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        }

        $spreadsheet    = $reader->load($_FILES['upload_file']['tmp_name']);
        $sheetdata      = $spreadsheet->getActiveSheet(1)->toArray();
        $sheetcount     = count($sheetdata);

        if ($sheetcount > 1) {
            $data   = array();

            for ($i = 1; $i < $sheetcount; $i++) {
                $id_penilaian_matakuliah    = $sheetdata[$i][0];
                $id_penilaian_dosen         = $sheetdata[$i][1];
                $kelas                      = $sheetdata[$i][2];
                $id_penilaian_semester      = $this->input->post('id_penilaian_semester');

                $data[] = array(
                    'id_penilaian_matakuliah'     => $id_penilaian_matakuliah,
                    'id_penilaian_dosen'          => $id_penilaian_dosen,
                    'id_penilaian_semester'       => $id_penilaian_semester,
                    'kelas'                       => $kelas,
                );
            }

            if ($this->mUserAdmin->insert_batch('penilaian_jadwal', $data)) {
                $this->session->set_flashdata('success', 'Berhasil upload data');
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $this->session->set_flashdata('error', 'Gagal upload data');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }

    // Upload excel matakuliah
    public function uploadMatakuliah()
    {
        $upload_file    = $_FILES['upload_file']['name'];
        $extension      = pathinfo($upload_file, PATHINFO_EXTENSION);

        if ($extension == 'csv') {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
        } else if ($extension == 'xls') {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        } else {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        }

        $spreadsheet    = $reader->load($_FILES['upload_file']['tmp_name']);
        $sheetdata      = $spreadsheet->getActiveSheet()->toArray();
        $sheetcount     = count($sheetdata);

        if ($sheetcount > 1) {
            $data   = array();

            for ($i = 1; $i < $sheetcount; $i++) {
                $id_matakuliah  = $sheetdata[$i][0];
                $matakuliah     = $sheetdata[$i][1];
                $sks            = $sheetdata[$i][2];

                $data[] = array(
                    'id_matakuliah' => $id_matakuliah,
                    'matakuliah'    => $matakuliah,
                    'sks'           => $sks,
                );
            }

            if ($this->mUserAdmin->insert_batch('matakuliah', $data)) {
                $this->session->set_flashdata('success', 'Berhasil upload data');
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $this->session->set_flashdata('error', 'Gagal upload data');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }

    // Upload excel dosen
    public function uploadDosen()
    {
        $upload_file    = $_FILES['upload_file']['name'];
        $extension      = pathinfo($upload_file, PATHINFO_EXTENSION);

        if ($extension == 'csv') {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
        } else if ($extension == 'xls') {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        } else {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        }

        $spreadsheet    = $reader->load($_FILES['upload_file']['tmp_name']);
        $sheetdata      = $spreadsheet->getActiveSheet()->toArray();
        $sheetcount     = count($sheetdata);

        if ($sheetcount > 1) {
            $data   = array();

            for ($i = 1; $i < $sheetcount; $i++) {
                $nik        = $sheetdata[$i][0];
                $nama_dosen = $sheetdata[$i][1];

                $data[] = array(
                    'id_penilaian_dosen'    => $nik,
                    'nama_dosen'            => $nama_dosen,
                );
            }

            if ($this->mUserAdmin->insert_batch('penilaian_dosen', $data)) {
                $this->session->set_flashdata('success', 'Berhasil upload data');
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $this->session->set_flashdata('error', 'Gagal upload data');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }

    // Upload excel mahasiswa
    public function uploadMahasiswa()
    {
        $upload_file    = $_FILES['upload_file']['name'];
        $extension      = pathinfo($upload_file, PATHINFO_EXTENSION);

        if ($extension == 'csv') {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
        } else if ($extension == 'xls') {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        } else {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        }

        $spreadsheet    = $reader->load($_FILES['upload_file']['tmp_name']);
        $sheetdata      = $spreadsheet->getActiveSheet()->toArray();
        $sheetcount     = count($sheetdata);

        if ($sheetcount > 1) {
            $data   = array();

            for ($i = 1; $i < $sheetcount; $i++) {
                $id_penilaian_mahasiswa = $sheetdata[$i][0];
                $nama_mahasiswa         = $sheetdata[$i][1];

                $data[] = array(
                    'id_penilaian_mahasiswa'    => $id_penilaian_mahasiswa,
                    'nama_mahasiswa'            => $nama_mahasiswa,
                );
            }

            if ($this->mUserAdmin->insert_batch('penilaian_mahasiswa', $data)) {
                $this->session->set_flashdata('success', 'Berhasil upload data');
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $this->session->set_flashdata('error', 'Gagal upload data');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }

    // download template jadwal
    public function templateDataJadwal()
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Template Upload Data Jadwal.xlsx"');
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'KODE MATAKULIAH');
        $sheet->setCellValue('B1', 'NIK DOSEN');
        $sheet->setCellValue('C1', 'KELAS');

        $writer = new Xlsx($spreadsheet);
        $writer->save("php://output");
    }

    // download template absensi
    public function templateDataAbsen()
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Template Upload Data Absensi.xlsx"');
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'NIM MAHASISWA');
        $sheet->setCellValue('B1', 'KODE MATAKULIAH');

        $writer = new Xlsx($spreadsheet);
        $writer->save("php://output");
    }

    // download template dosen
    public function templateDataDosen()
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Template Upload Data Dosen.xlsx"');
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'NIK DOSEN');
        $sheet->setCellValue('B1', 'NAMA DOSEN');

        $writer = new Xlsx($spreadsheet);
        $writer->save("php://output");
    }

    // download template mahasiswa
    public function templateDataMahasiswa()
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Template Upload Data Mahasiswa.xlsx"');
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'NIM MAHASISWA');
        $sheet->setCellValue('B1', 'NAMA MAHASISWA');

        $writer = new Xlsx($spreadsheet);
        $writer->save("php://output");
    }

    // download template mahasiswa
    public function templateDataMatkul()
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Template Upload Data Matakuliah.xlsx"');
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'KODE MATAKULIAH');
        $sheet->setCellValue('B1', 'MATAKULIAH');

        $writer = new Xlsx($spreadsheet);
        $writer->save("php://output");
    }

    // Export ke excel
    public function exportExcelDataMagang($jenis)
    {
        $result   = $this->mUserAdmin->periodeMagang()->row();
        $thn_akad = $result->thn_akademik;

        // Create new Spreadsheet object
        $spreadsheet = new Spreadsheet();
        $spreadsheet->createSheet();
        $spreadsheet->createSheet();

        // Set document properties
        $spreadsheet->getProperties()->setCreator('Ardi Tri Heru - TeknoBit')
            ->setLastModifiedBy('Ardi Tri Heru - TeknoBit')
            ->setTitle('Office 2007 XLSX Test Document')
            ->setSubject('Office 2007 XLSX Test Document')
            ->setDescription('Test document for Office 2007 XLSX, generated using PHP classes.')
            ->setKeywords('office 2007 openxml php')
            ->setCategory('Test result file');

        // Data worksheet mahasiswa
        $spreadsheet->setActiveSheetIndex(0)
            ->setTitle('Data Mahasiswa')
            ->setCellValue('A1', 'NO')
            ->setCellValue('B1', 'KODE DAFTAR')
            ->setCellValue('C1', 'NIM MAHASISWA')
            ->setCellValue('D1', 'NAMA MAHASISWA')
            ->setCellValue('E1', 'JENIS')
            ->setCellValue('F1', 'ID INSTANSI')
            ->setCellValue('G1', 'NIK PEMBIMBING');

        if ($jenis == 1) {
            $query = $this->mUserAdmin->detailMagang('magang_daftar.id_magang_daftar IS NOT NULL', '1')->result();
        } else {
            $query = $this->mUserAdmin->detailMagang('magang_daftar.id_magang_daftar IS NOT NULL', '2')->result();
        }

        $noa = 1;
        $ia  = 2;
        foreach ($query as $d) {

            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $ia, $noa++)
                ->setCellValue('B' . $ia, $d->id_magang_daftar)
                ->setCellValue('C' . $ia, $d->id_mahasiswa)
                ->setCellValue('D' . $ia, $d->nama_mahasiswa)
                ->setCellValue('E' . $ia, $d->nama_magang_jenis)
                ->setCellValue('F' . $ia, $d->id_magang_instansi)
                ->setCellValue('G' . $ia, $d->id_pembimbing);
            $ia++;
        }

        // Data worksheet dosen
        $spreadsheet->setActiveSheetIndex(1)
            ->setTitle('Data Dosen')
            ->setCellValue('A1', 'NO')
            ->setCellValue('B1', 'NIK DOSEN')
            ->setCellValue('C1', 'NAMA DOSEN');

        $dosen = $this->mUserAdmin->selectData('dosen', 'id_dosen, nama_dosen', 'id_dosen !=0', 'nama_dosen ASC')->result();

        $nob = 1;
        $ib  = 2;
        foreach ($dosen as $d) {

            $spreadsheet->setActiveSheetIndex(1)
                ->setCellValue('A' . $ib, $nob++)
                ->setCellValue('B' . $ib, $d->id_dosen)
                ->setCellValue('C' . $ib, $d->nama_dosen);
            $ib++;
        }

        // Data worksheet instansi
        $spreadsheet->setActiveSheetIndex(2)
            ->setTitle('Data Instansi')
            ->setCellValue('A1', 'NO')
            ->setCellValue('B1', 'ID INSTANSI')
            ->setCellValue('C1', 'NAMA INSTANSI')
            ->setCellValue('D1', 'ALAMAT');

        $instansi = $this->mUserAdmin->selectData('magang_instansi', '*', 'id_magang_instansi IS NOT NULL', 'nama_instansi ASC')->result();

        $noc = 1;
        $ic  = 2;
        foreach ($instansi as $d) {

            $spreadsheet->setActiveSheetIndex(2)
                ->setCellValue('A' . $ic, $noc++)
                ->setCellValue('B' . $ic, $d->id_magang_instansi)
                ->setCellValue('C' . $ic, $d->nama_instansi)
                ->setCellValue('D' . $ic, $d->alamat_instansi);
            $ic++;
        }

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $spreadsheet->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Data pemagangan periode"' . $thn_akad . '".xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
    }
}
