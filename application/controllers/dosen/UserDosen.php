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


        if ($this->mUserAdmin->periodeAktif()->num_rows() > 0) {
            $result                     = $this->mUserAdmin->periodeAktif()->row();
            $data['dataPeriodeAktif']   = $result->thn_akademik . ' - ' . $result->nm_semester;
        } else {
            $data['dataPeriodeAktif']   = 'Kosong';
        }

        $id_dosen = $this->session->userdata('nilai_id_dosen');

        $data['countMhs'] = $this->mUserDosen->dataIndex(
            array(
                'penilaian_semester.aktif'              => 1,
                'penilaian_jadwal.id_penilaian_dosen'   => $id_dosen,
            ),
            'penilaian_absensi.id_penilaian_mahasiswa',
            'penilaian_mahasiswa.nama_mahasiswa ASC'
        )->num_rows();

        $data['countMkl'] = $this->mUserDosen->dataIndex(
            array(
                'penilaian_semester.aktif'              => 1,
                'penilaian_jadwal.id_penilaian_dosen'   => $id_dosen,
            ),
            'penilaian_jadwal.id_penilaian_matakuliah',
            'penilaian_mahasiswa.nama_mahasiswa ASC'
        )->num_rows();

        $data['dataIndex'] = $this->mUserDosen->dataIndex(
            array(
                'penilaian_semester.aktif'              => 1,
                'penilaian_jadwal.id_penilaian_dosen'   => $id_dosen,
            ),
            'penilaian_mahasiswa.id_penilaian_mahasiswa',
            'penilaian_mahasiswa.nama_mahasiswa ASC'
        )->result();

        $this->load->view('templates/header', $data);
        $this->load->view('dosen/vDashboard', $data);
        $this->load->view('templates/footer', $data);
    }
}
