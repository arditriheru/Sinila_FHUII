<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li>
            <a class="nav-link" href="https://arditriheru.com" target="_blank">
                <p class="badge badge-success">ONLINE</p>
            </a>
        </li>
        <li>
            <a class="nav-link">
                <p><?php echo $this->session->userdata('ijazah_akses'); ?></p>
            </a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Navbar alert -->
        <li class="nav-item">
            <?php echo $this->session->flashdata('alert') ?>
        </li>
        <!-- Language Dropdown Menu -->
        <li class="nav-item">
            <a href="<?php echo base_url(); ?>ijazah/dataIjazah/switchLanguage/in">
                <i class="flag-icon flag-icon-id mr-2"></i>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?php echo base_url(); ?>ijazah/dataIjazah/switchLanguage/en">
                <i class="flag-icon flag-icon-us mr-2"></i>
            </a>
        </li>
        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="fas fa-power-off"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <ul><a class="nav-link" href="<?php echo base_url(); ?>ijazah/login/logout">
                        <i class="far fa-circle nav-icon"></i> Logout
                    </a></ul>
            </div>
        </li>
    </ul>
</nav>
<!-- /.navbar -->

<script>
    // 1. tangkap element dengan class menu
    const menu = document.querySelector(".navbar-nav");

    // 2. jika element dengan class menu diklik
    menu.addEventListener('click', function(e) {
        // 3. maka ambil element apa yang diklik oleh user
        const targetMenu = e.target;

        // 4. lalu cek, jika element itu adalah link dengan class menu__link
        if (targetMenu.classList.contains('menu__link')) {

            // 5. maka ambil menu link yang aktif
            const menuLinkActive = document.querySelector("ul li a.active");

            // 6. lalu cek, Jika menu link active ada dan menu yang di klik user adalah menu yang tidak sama dengan menu yang aktif, (cara cek-nya yaitu dengan membandingkan value attribute href-nya)
            if (menuLinkActive !== null && targetMenu.getAttribute('href') !== menuLinkActive.getAttribute('href')) {

                // 7. maka hapus class active pada menu yang sedang aktif
                menuLinkActive.classList.remove('active');
            }

            // 8. terakhir tambahkan class active pada menu yang di klik oleh user
            targetMenu.classList.add('active');
        }
    });
</script>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo base_url(); ?>ijazah/dataIjazah/index" class="brand-link">
        <img src="<?php echo base_url(); ?>assets/dist/img/MainLogo.png" alt="Main Logo" class="brand-image">
        <span class="brand-text font-weight-light">SIJA</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?php echo base_url(); ?>assets/dist/img/avatar.png" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?php echo $this->session->userdata('hello') ?></a>
            </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="<?php echo base_url(); ?>ijazah/dataIjazah/index" class="nav-link active">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p><?php echo $menu_utama; ?></p>
                    </a>
                </li>

                <?php if ($this->session->userdata('ijazah_akses') == 'Admin') { ?>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-copy"></i>
                            <p><?php echo $dokumen_ijazah; ?><i class="fas fa-angle-left right"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?php echo base_url(); ?>ijazah/dataIjazah/dataIjazah/1" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p><?php echo $lihat; ?></p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo base_url(); ?>ijazah/dataIjazah/dataIjazah/2" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p><?php echo $tambah; ?></p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo base_url(); ?>ijazah/dataIjazah/dataIjazah/3" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p><?php echo $import_data; ?></p>
                                </a>
                            </li>
                        </ul>
                    </li>

                <?php } ?>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>