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
                <ul><a class="nav-link" href="<?php echo base_url(); ?>login/logout">
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
    <a href="<?php echo base_url(); ?>dosen/userDosen/index" class="brand-link">
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
                    <a href="<?php echo base_url(); ?>dosen/userDosen/index?menuUtama=active" class="nav-link <?php echo $this->input->get('menuUtama'); ?>">
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
                            <a href="<?php echo base_url(); ?>dosen/userDosen/dataJadwal?menuJadwalOpen=menu-open&menuJadwal=active&menuLihatJadwal=active" class="nav-link <?php echo $this->input->get('menuLihatJadwal'); ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Lihat</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" data-toggle="modal" data-target="#modalUploadNilai" class="nav-link">
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

<!-- modal Upload Nilai -->
<div class="modal fade" id="modalUploadNilai">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Upload Data Nilai</h4><br>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-prevent" action="<?php echo base_url('dosen/userDosen/uploadNilai') ?>" method="post" enctype="multipart/form-data">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Upload Excel</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <a class="btn btn-primary mb-2" href="<?php echo base_url('dosen/userDosen/templateDataJadwal'); ?>">Download Template</a>
                                    <div class="form-group">
                                        <label class="required">Semester</label>
                                        <select name="id_semester" class="form-control select2" style="width: 100%;" required="">
                                            <option value="" selected="">Pilih</option>
                                            <?php
                                            foreach ($this->mUserDosen->dataSemester(array('aktif' => 1), 'id_semester DESC')->result() as $d) : ?>
                                                <option value="<?php echo $d->id_semester; ?>"><?php echo $d->thn_akademik . ' - ' . $d->nm_semester; ?></option>
                                            <?php endforeach; ?>

                                        </select>
                                    </div>
                                    <!-- /.form-group -->
                                    <div class="form-group">
                                        <label for="dokumen">Dokumen</label>
                                        <div class="custom-file">
                                            <input type="file" name="upload_file" id="upload_file" required accept=".csv, .xls, .xlsx">
                                        </div>
                                        <p class="text-danger">Lampirkan file dengan ekstensi .Csv / .Xls / .Xlsx</p>
                                        <button class="btn btn-info button-prevent mt-1" type="submit">
                                            <!-- spinner-border adalah component bawaan bootstrap untuk menampilakn roda berputar  -->
                                            <div class="spinner"><i role="status" class="spinner-border spinner-border-sm"></i> Upload </div>
                                            <div class="hide-text">Upload</div>
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->