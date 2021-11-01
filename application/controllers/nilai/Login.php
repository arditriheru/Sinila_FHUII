<?php

class login extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model("mLogin");
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['title']          = "SINILA";
        $data['subtitle']       = "Login Sistem Informasi Penilaian";

        $this->load->view('templates/header', $data);
        $this->load->view('nilai/vLogin', $data);
        $this->load->view('templates/footer', $data);
    }

    public function login()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $where1 = array(
            'mahasiswa.id_mahasiswa' => $username,
            'mahasiswa.password' => md5($password),
        );

        $where2 = array(
            'dosen.id_dosen' => $username,
            'dosen.password' => md5($password),
        );

        $where3 = array(
            'nilai_instansi_pic.nik_pic'    => $username,
            'nilai_instansi_pic.password'   => $password,
        );

        if ($username == 'admin' && $password == 'adminnilai') {
            $userdata = array(
                'nilai_bahasa'         => 'in',
                'nilai_nama_petugas'   => 'Admin Penilaian',
                'nilai_admin_login'    => '1',
                'nilai_login_as'       => 'Super Admin',
                'nilai_id_hello'       => '214102605',
                'nilai_hello'          => 'Ardi Tri Heru, S.Kom',
            );
            $this->session->set_userdata($userdata);
            $this->session->set_flashdata('success', 'Hai, Selamat Datang..');
            redirect('nilai/admin/userAdmin/index?menuUtama=active');
        } elseif ($this->mLogin->login('*', 'mahasiswa', $where1) !== FALSE) {

            $user = $this->mLogin->userMhs($where1)->row();

            $userdata = array(
                'nilai_bahasa'         => 'in',
                'nilai_id_mahasiswa'   => $user->id_mahasiswa,
                'nilai_nama_mahasiswa' => $user->nama_mahasiswa,
                'nilai_mhs_login'      => '1',
                'nilai_login_as'       => 'Mahasiswa',
                'nilai_id_hello'       => $user->id_mahasiswa,
                'nilai_hello'          => $user->nama_mahasiswa,
            );
            $this->session->set_userdata($userdata);
            $this->session->set_flashdata('success', 'Hai, Selamat Datang..');
            redirect('nilai/mahasiswa/userMahasiswa/index?menuUtama=active');
        } elseif ($this->mLogin->login('*', 'dosen', $where2) !== FALSE) {

            $user = $this->mLogin->userDosen($where2)->row();

            $userdata = array(
                'nilai_bahasa'         => 'in',
                'nilai_id_dosen'       => $user->id_dosen,
                'nilai_id_departemen'  => $user->id_departemen,
                'nilai_nama_dosen'     => $user->nama_dosen,
                'nilai_dosen_login'    => '1',
                'nilai_login_as'       => 'Dosen',
                'nilai_id_hello'       => $user->id_dosen,
                'nilai_hello'          => $user->nama_dosen,
            );
            $this->session->set_userdata($userdata);
            $this->session->set_flashdata('success', 'Hai, Selamat Datang..');
            redirect('nilai/dosen/userDosen/index?menuUtama=active&nama=nilai+Reguler&jenis=1');
        } else {

            $this->session->set_flashdata('error', 'Username atau password salah');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('nilai/login');
    }
}
