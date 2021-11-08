<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Load library phpspreadsheet
require('./vendor/excel/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// End load library phpspreadsheet

class UserDosen extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('nilai_dosen_login') != '1') {

            $this->session->set_flashdata('alert', '<div class="alert alert-danger alert-dismissable">
        		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        		<p>Anda belum login!</p>
        		</div>');
            redirect('login');
        }

        $this->load->model("mUserDosen");
        $this->load->helper(array('url', 'download'));
        $this->load->library('form_validation', 'excel');
    }

    public function index()
    {
        $lang = $this->mUserDosen->switchLang($this->session->userdata('nilai_bahasa'))->result();

        foreach ($lang as $d) {
            $data['lan_' . $d->id_multi_bahasa] = $d->translate;
        }

        $data['title']      = getDateIndo();
        $data['subtitle']   = "Dashboard";


        if ($this->mUserDosen->periodeAktif()->num_rows() > 0) {
            $data['dataPeriodeAktif']   = $this->mUserDosen->periodeAktif()->row();
        } else {
            $data['dataPeriodeAktif']   = 'Kosong';
        }

        $id_dosen = $this->session->userdata('nilai_id_dosen');

        $data['countMhs'] = $this->mUserDosen->dataIndex(
            array(
                'penilaian_semester.aktif'              => 1,
                'penilaian_jadwal.id_penilaian_dosen'   => $id_dosen,
            ),
            'penilaian_mahasiswa.nama_mahasiswa ASC'
        )->num_rows();

        $data['countMkl'] = $this->mUserDosen->dataMatkul(
            array(
                'penilaian_semester.aktif'              => 1,
                'penilaian_jadwal.id_penilaian_dosen'   => $id_dosen,
            ),
            'penilaian_mahasiswa.nama_mahasiswa ASC'
        )->num_rows();

        $data['dataIndex'] = $this->mUserDosen->dataMatkul(
            array(
                'penilaian_semester.id_penilaian_semester'  => 1,
                'penilaian_thn_akademik.thn_akademik'       => '2021/2022',
                'penilaian_jadwal.id_penilaian_dosen'       => $id_dosen,
            )
        )->result();

        $data['dataThnAkad']    = $this->db->query('SELECT * FROM penilaian_thn_akademik ORDER BY id_penilaian_thn_akademik DESC LIMIT 10')->result();

        $this->load->view('templates/header', $data);
        $this->load->view('dosen/vDashboard', $data);
        $this->load->view('templates/footer', $data);
    }

    public function dataDetail()
    {
        $lang = $this->mUserDosen->switchLang($this->session->userdata('nilai_bahasa'))->result();

        foreach ($lang as $d) {
            $data['lan_' . $d->id_multi_bahasa] = $d->translate;
        }

        $data['title']      = getDateIndo();
        $data['subtitle']   = "Data Detail";

        $id_dosen = $this->session->userdata('nilai_id_dosen');

        $matakuliah = $this->input->get('matakuliah');
        $kelas = $this->input->get('kelas');

        $data['dataAbsensi']  = $this->mUserDosen->dataAbsensi(
            array(
                'penilaian_absensi.id_penilaian_matakuliah' => $matakuliah,
                'penilaian_jadwal.kelas'                    => $kelas,
                'penilaian_jadwal.id_penilaian_dosen'       => $id_dosen,
            )
        )->result();

        $this->load->view('templates/header', $data);
        $this->load->view('dosen/vDataDetail', $data);
        $this->load->view('templates/footer', $data);
    }

    public function dataFilter()
    {
        $lang = $this->mUserDosen->switchLang($this->session->userdata('nilai_bahasa'))->result();

        foreach ($lang as $d) {
            $data['lan_' . $d->id_multi_bahasa] = $d->translate;
        }

        $data['title']      = getDateIndo();
        $data['subtitle']   = "Data Filter";

        $id_dosen = $this->session->userdata('nilai_id_dosen');

        $data['dataMatkul'] = $this->mUserDosen->dataMatkul(
            array(
                'penilaian_semester.id_penilaian_semester'  => $this->input->get('semester'),
                'penilaian_thn_akademik.thn_akademik'       => $this->input->get('thn_akademik'),
                'penilaian_jadwal.id_penilaian_dosen'       => $id_dosen,
            )
        )->result();

        $matakuliah = $this->input->get('matakuliah');
        $kelas = $this->input->get('kelas');

        if (isset($matakuliah)) {
            $data['dataAbsensi']  = $this->mUserDosen->dataAbsensi(
                array(
                    'penilaian_absensi.id_penilaian_matakuliah' => $matakuliah,
                    'penilaian_jadwal.kelas'                    => $kelas,
                    'penilaian_jadwal.id_penilaian_dosen'       => $id_dosen,
                )
            )->result();
        }

        $this->load->view('templates/header', $data);
        $this->load->view('dosen/vDataFilter', $data);
        $this->load->view('templates/footer', $data);
    }

    // Input nilai
    public function inputNilai()
    {
        $id_penilaian_absensi = $this->input->post('id_penilaian_absensi');

        $data   = array();
        $data = array();
        foreach ($id_penilaian_absensi as $d => $val) {
            $data[] = array(
                "id_penilaian_absensi"  => $_POST['id_penilaian_absensi'][$d],
                "uts"                   => $_POST['uts'][$d],
                "uas"                   => $_POST['uas'][$d],
            );
        }

        if (!$this->mUserDosen->update_batch('penilaian_absensi', $data, 'id_penilaian_absensi')) {

            $this->session->set_flashdata('success', 'Berhasil memperbarui nilai');
            redirect($_SERVER['HTTP_REFERER']);
        } else {

            $this->session->set_flashdata('error', 'Gagal memperbarui nilai');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    // Import excel nilai
    public function uploadNilai()
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
                $id_penilaian_mahasiswa     = $sheetdata[$i][0];
                $id_penilaian_matakuliah    = $sheetdata[$i][1];
                $uts                        = $sheetdata[$i][2];
                $uas                        = $sheetdata[$i][3];
                $id_penilaian_semester      = $this->input->post('id_penilaian_semester');

                $data[] = array(
                    'id_penilaian_mahasiswa'        => $id_penilaian_mahasiswa,
                    'id_penilaian_matakuliah'       => $id_penilaian_matakuliah,
                    'uts'                           => $uts,
                    'uas'                           => $uas,
                );

                // $where[] = array(
                //     'id_penilaian_mahasiswa'        => $id_penilaian_mahasiswa,
                //     'id_penilaian_matakuliah'       => $id_penilaian_matakuliah,
                //     'id_penilaian_semester'         => $id_penilaian_semester,
                // );
            }

            if (!$this->mUserDosen->update_batch('penilaian_absensi', $data, 'id_penilaian_mahasiswa')) {
                $this->session->set_flashdata('success', 'Berhasil upload data');
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $this->session->set_flashdata('error', 'Gagal upload data');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
}
