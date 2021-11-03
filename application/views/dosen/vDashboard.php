<div class="wrapper">

    <?php $this->view('dosen/vMenu'); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h5><?php echo $title; ?></h5>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active"><?php echo $subtitle; ?></li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- main column -->

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Tahun Akademik : <strong><?= $dataPeriodeAktif; ?></strong></h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <!-- Small boxes (Stat box) -->
                                <div class="row">
                                    <div class="col-lg-6 col-6">
                                        <!-- small box -->
                                        <div class="small-box bg-info">
                                            <div class="inner">
                                                <h3><?= $countMhs; ?></h3>

                                                <p>Total Mahasiswa</p>
                                            </div>
                                            <div class="icon">
                                                <i class="fas fa-check"></i>
                                            </div>
                                            <a href="<?php echo base_url('admin/userAdmin/dataTab?menuUtama=active&sort=1') ?>" class="small-box-footer">Lihat Data <i class="fas fa-arrow-circle-right"></i></a>
                                        </div>
                                    </div>
                                    <!-- ./col -->
                                    <div class="col-lg-6 col-6">
                                        <!-- small box -->
                                        <div class="small-box bg-success">
                                            <div class="inner">
                                                <h3><?= $countMkl; ?></h3>

                                                <p>Total Matakuliah</p>
                                            </div>
                                            <div class="icon">
                                                <i class="fas fa-book"></i>
                                            </div>
                                            <a href="<?php echo base_url('admin/userAdmin/dataTab?menuUtama=active&sort=3') ?>" class="small-box-footer">Lihat Data <i class="fas fa-arrow-circle-right"></i></a>
                                        </div>
                                    </div>
                                    <!-- ./col -->
                                </div>
                                <!-- /.row -->

                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Data Mahasiswa</strong></h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="input-group input-group-lg mb-3">
                                            <div class="input-group-prepend">
                                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                                    Tahun Akademik
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <?php foreach ($dataThnAkad as $d) : ?>
                                                        <li class="dropdown-item"><a href="<?= base_url('dosen/userDosen/dataFilter?menuUtama=active&thn_akademik=' . $d->thn_akademik); ?>"><?php echo 'Periode ' . $d->thn_akademik; ?></a></li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </div>
                                            <!-- /btn-group -->
                                        </div>
                                        <!-- /input-group -->
                                        <table id="dataTablesAsc1" class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">#</th>
                                                    <th class="text-center">Nama Mahasiswa</th>
                                                    <th class="text-center">Matakuliah</th>
                                                    <th class="text-center">Kelas</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no = 1;
                                                foreach ($dataIndex as $d) : ?>
                                                    <tr>
                                                        <td class="text-center"><?= $no++; ?></td>
                                                        <td class="text-left"><?= $d->id_penilaian_mahasiswa . '@student.uii.ac.id<br><strong>' . $d->nama_mahasiswa . '</strong>'; ?></td>
                                                        <td class="text-center"><?= $d->matakuliah; ?></td>
                                                        <td class="text-center"><?= $d->kelas; ?></td>
                                                    </tr>

                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>

                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>

                    <!--/.col (main) -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <?php $this->load->view('templates/copyright'); ?>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->