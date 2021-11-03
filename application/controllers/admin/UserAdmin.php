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
            redirect('login');
        }

        $this->load->model("mUserAdmin");
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

        if ($this->mUserAdmin->periodeAktif()->num_rows() > 0) {
            $result                     = $this->mUserAdmin->periodeAktif()->row();
            $data['dataPeriodeAktif']   = $result->thn_akademik . ' - ' . $result->nm_semester;
        } else {
            $data['dataPeriodeAktif']   = 'Kosong';
        }

        $sort = $this->input->get('short');

        $data['countMhs']       = $this->mUserAdmin->dataIndex('penilaian_absensi.id_penilaian_mahasiswa', 'penilaian_mahasiswa.nama_mahasiswa ASC')->num_rows();
        $data['countDsn']       = $this->mUserAdmin->dataIndex('penilaian_jadwal.id_penilaian_dosen', 'penilaian_mahasiswa.nama_mahasiswa ASC')->num_rows();
        $data['countMkl']       = $this->mUserAdmin->dataIndex('penilaian_jadwal.id_penilaian_matakuliah', 'penilaian_mahasiswa.nama_mahasiswa ASC')->num_rows();
        $data['dataThnAkad']    = $this->db->query('SELECT * FROM penilaian_thn_akademik ORDER BY id_penilaian_thn_akademik DESC LIMIT 10')->result();

        if ($sort == 2) {
            $data['dataIndex'] = $this->mUserAdmin->dataIndex('penilaian_jadwal.id_penilaian_dosen', 'penilaian_mahasiswa.nama_mahasiswa ASC')->result();
        } elseif ($sort == 3) {
            $data['dataIndex'] = $this->mUserAdmin->dataIndex('penilaian_jadwal.id_penilaian_matakuliah', 'penilaian_mahasiswa.nama_mahasiswa ASC')->result();
        } else {
            $data['dataIndex'] = $this->mUserAdmin->dataIndex('penilaian_mahasiswa.id_penilaian_mahasiswa', 'penilaian_mahasiswa.nama_mahasiswa ASC')->result();
        }

        $this->load->view('templates/header', $data);
        $this->load->view('admin/vDashboard', $data);
        $this->load->view('templates/footer', $data);
    }

    public function dataTab()
    {
        $lang = $this->mUserAdmin->switchLang($this->session->userdata('nilai_bahasa'))->result();

        foreach ($lang as $d) {
            $data['lan_' . $d->id_multi_bahasa] = $d->translate;
        }

        $data['title']      = getDateIndo();
        $data['subtitle']   = "Data Filter";

        $data['dataMatkul'] = $this->mUserAdmin->dataMatkul(
            array(
                'penilaian_semester.id_penilaian_semester'  => $this->input->get('semester'),
                'penilaian_thn_akademik.thn_akademik'       => $this->input->get('thn_akademik'),
            )
        )->result();

        $matakuliah = $this->input->get('matakuliah');

        if (isset($matakuliah)) {
            $data['dataAbsensi']  = $this->mUserAdmin->dataAbsensi(
                array(
                    'penilaian_absensi.id_penilaian_matakuliah' => $matakuliah
                )
            )->result();
        }

        $this->load->view('templates/header', $data);
        $this->load->view('admin/vDataTab', $data);
        $this->load->view('templates/footer', $data);
    }

    // Data semester
    public function dataSemester()
    {
        $lang = $this->mUserAdmin->switchLang($this->session->userdata('nilai_bahasa'))->result();

        foreach ($lang as $d) {
            $data['lan_' . $d->id_multi_bahasa] = $d->translate;
        }

        $data['title']          = getDateIndo();
        $data['subtitle']       = "Data Semester";

        $date                   = date('Y') . '/' . date('Y', strtotime('+1 year', strtotime(date('Y'))));

        if (!$this->mUserAdmin->countData('penilaian_thn_akademik', array('thn_akademik' => $date)) > 0) {
            $this->mUserAdmin->insertData('penilaian_thn_akademik', array(
                'thn_akademik' => $date
            ));
        }

        $data['thn_akademik']   = getThnAkademik();
        $data['dataSemester']   = $this->mUserAdmin->dataSemester('id_penilaian_semester IS NOT NULL', 'id_penilaian_semester DESC')->result();
        $data['dataThnAkad']    = $this->db->query('SELECT * FROM penilaian_thn_akademik ORDER BY id_penilaian_thn_akademik DESC LIMIT 2')->result();
        $data['count1']         = $this->mUserAdmin->countData('penilaian_semester', 'id_penilaian_semester IS NOT NULL');
        $data['count2']         = $this->mUserAdmin->countData('penilaian_thn_akademik', 'id_penilaian_thn_akademik IS NOT NULL');

        $this->load->view('templates/header', $data);
        $this->load->view('admin/vDataSemester', $data);
        $this->load->view('templates/footer', $data);
    }

    public function tambahDataSemesterAksi()
    {
        $data = array(
            'id_penilaian_thn_akademik' => $this->input->post('id_penilaian_thn_akademik'),
            'nama_semester'             => $this->input->post('nama_semester'),
        );

        if (!$this->mUserAdmin->insertData('penilaian_semester', $data)) {

            $this->session->set_flashdata('success', 'Berhasil menambah data');
            redirect($_SERVER['HTTP_REFERER']);
        } else {

            $this->session->set_flashdata('error', 'Gagal menambah data');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function editDataSemesterAksi($id)
    {
        $data = array(
            'id_penilaian_thn_akademik' => $this->input->post('id_penilaian_thn_akademik'),
            'nama_semester'             => $this->input->post('nama_semester'),
        );

        if (!$this->mUserAdmin->updateData('penilaian_semester', $data, array('id_penilaian_semester' => $id))) {

            $this->session->set_flashdata('success', 'Berhasil memperbarui data');
            redirect($_SERVER['HTTP_REFERER']);
        } else {

            $this->session->set_flashdata('error', 'Gagal memperbarui data');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function nonaktifDataSemesterAksi($id)
    {
        $data = array(
            'aktif'      => 0,
        );

        if (!$this->mUserAdmin->updateData('penilaian_semester', $data, array('id_penilaian_semester' => $id))) {

            $this->session->set_flashdata('success', 'Berhasil nonaktifkan data');
            redirect($_SERVER['HTTP_REFERER']);
        } else {

            $this->session->set_flashdata('error', 'Gagal nonaktifkan data');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function aktifDataSemesterAksi($id)
    {
        $data = array(
            'aktif'      => 1,
        );

        if ($this->mUserAdmin->countData('penilaian_semester', 'aktif=1') > 0) {
            $this->session->set_flashdata('error', 'Nonaktifkan terlebih dahulu semester yang aktif');
            redirect($_SERVER['HTTP_REFERER']);
        } else {

            if (!$this->mUserAdmin->updateData('penilaian_semester', $data, array('id_penilaian_semester' => $id))) {

                $this->session->set_flashdata('success', 'Berhasil aktifkan data');
                redirect($_SERVER['HTTP_REFERER']);
            } else {


                $this->session->set_flashdata('error', 'Gagal aktifkan data');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }

    // Data Jadwal
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
        $this->load->view('admin/vDataJadwal', $data);
        $this->load->view('templates/footer', $data);
    }

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

    // Data Absensi
    public function dataAbsensi()
    {
        $lang = $this->mUserAdmin->switchLang($this->session->userdata('nilai_bahasa'))->result();

        foreach ($lang as $d) {
            $data['lan_' . $d->id_multi_bahasa] = $d->translate;
        }

        $data['title']      = getDateIndo();
        $data['subtitle']   = "Dashboard";

        $data['dataAbsensi']  = $this->mUserAdmin->dataAbsensi('penilaian_absensi.id_penilaian_absensi IS NOT NULL')->result();

        $this->load->view('templates/header', $data);
        $this->load->view('admin/vDataAbsensi', $data);
        $this->load->view('templates/footer', $data);
    }

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

    // Data matakuliah
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

    // Data Dosen
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

    // Data mahasiswa
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

    // ----------------------------------------------------------------- Template ----------------------------------------------------------------- //

    // Template jadwal
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

    // Template absensi
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

    // Template dosen
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

    // Template mahasiswa
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

    // Template matakuliah
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
}
