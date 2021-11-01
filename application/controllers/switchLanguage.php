<?php

defined('BASEPATH') or exit('No direct script access allowed');
require FCPATH . 'vendor/autoload.php';

class switchLanguage extends CI_Controller
{
    public function index($name, $lang)
    {
        $this->session->set_userdata($name, $lang);
        redirect($_SERVER['HTTP_REFERER']);
    }
}
