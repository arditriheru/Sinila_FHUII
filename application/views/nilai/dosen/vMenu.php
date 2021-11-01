<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block mt-2">
            <a href="https://arditriheru.com/" class="badge badge-success">ONLINE</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="https://arditriheru.com/" class="nav-link"><?php echo $this->session->userdata('nilai_id_hello') . ' - ' . $this->session->userdata('nilai_hello'); ?></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Navbar alert -->
        <li class="nav-item">
            <?php echo $this->session->flashdata('alert'); ?>
        </li>
        <!-- login as -->
        <li class="nav-item">
            <a class="nav-link" href="https://arditriheru.com/" target="_blank">
                Login as : <?php echo $this->session->userdata('nilai_login_as'); ?>
            </a>
        </li>
        <!-- expand fullscreen -->
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <!-- Bilingual Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <?php
                if ($this->session->userdata('nilai_bahasa') == 'in') { ?>
                    <img src="<?php echo base_url(); ?>assets/dist/img/in_lang.png" alt="Swith Language" width="25px" class="brand-image">
                <?php } else { ?>
                    <img src="<?php echo base_url(); ?>assets/dist/img/en_lang.png" alt="Swith Language" width="25px" class="brand-image">
                <?php } ?>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <div class="dropdown-divider"></div>
                <a class="nav-link" href="<?php echo base_url(); ?>switchLanguage/index/magang_bahasa/in">
                    <img src="<?php echo base_url(); ?>assets/dist/img/in_lang.png" alt="Swith Language" width="25px" class="brand-image"> <?php echo $lan_indonesia; ?>
                </a>
                <div class="dropdown-divider"></div>
                <a class="nav-link" href="<?php echo base_url(); ?>switchLanguage/index/magang_bahasa/en">
                    <img src="<?php echo base_url(); ?>assets/dist/img/en_lang.png" alt="Swith Language" width="25px" class="brand-image"> <?php echo $lan_inggris; ?>
                </a>
            </div>
        </li>
        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="fas fa-chevron-down"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <ul><a class="nav-link" href="<?php echo base_url(); ?>nilai/login/logout">
                        <i class="far fa-circle nav-icon"></i> Logout
                    </a></ul>
            </div>
        </li>
    </ul>
</nav>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo base_url(); ?>nilai/dosen/userDosen/index" class="brand-link">
        <img src="<?php echo base_url(); ?>assets/dist/img/MainLogo.png" alt="Main Logo" class="brand-image">
        <span class="brand-text font-weight-light">S I N I L A</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar mt-6">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" id="myDIV" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="<?php echo base_url(); ?>nilai/dosen/userDosen/index?menuUtama=active" class="nav-link <?php echo $this->input->get('menuUtama'); ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p><?php echo $lan_menu_utama; ?></p>
                    </a>
                </li>
                <li class="nav-item <?php echo $this->input->get('menuJadwalOpen'); ?>">
                    <a href="#" class="nav-link <?php echo $this->input->get('menuJadwal'); ?>">
                        <i class="nav-icon fas fa-star"></i>
                        <p>Nilai Akhir<i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo base_url(); ?>nilai/dosen/userDosen/dataJadwal?menuJadwalOpen=menu-open&menuJadwal=active&menuLihatJadwal=active" class="nav-link <?php echo $this->input->get('menuLihatJadwal'); ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Lihat</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" data-toggle="modal" data-target="#modalUploadJadwal" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Upload</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>