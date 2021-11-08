<div class="wrapper">

    <?php $this->view('admin/vMenu'); ?>

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
                                <h3 class="card-title">Tahun Akademik : <strong><?= $dataPeriodeAktif->thn_akademik . ' - ' . $dataPeriodeAktif->nm_semester; ?></strong></h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <!-- Small boxes (Stat box) -->
                                <div class="row">
                                    <div class="col-lg-4 col-6">
                                        <!-- small box -->
                                        <div class="small-box bg-info">
                                            <div class="inner">
                                                <h3><?= $countMhs; ?></h3>

                                                <p>Total Mahasiswa</p>
                                            </div>
                                            <div class="icon">
                                                <i class="fas fa-check"></i>
                                            </div>
                                            <a href="<?php echo base_url('admin/userAdmin/dataFilter?menuUtama=active&thn_akademik=' . $dataPeriodeAktif->thn_akademik . '&semester=' . $dataPeriodeAktif->nama_semester) ?>" class="small-box-footer">Lihat Data <i class="fas fa-arrow-circle-right"></i></a>
                                        </div>
                                    </div>
                                    <!-- ./col -->
                                    <div class="col-lg-4 col-6">
                                        <!-- small box -->
                                        <div class="small-box bg-success">
                                            <div class="inner">
                                                <h3><?= $countDsn; ?></h3>

                                                <p>Total Dosen</p>
                                            </div>
                                            <div class="icon">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <a href="<?php echo base_url('admin/userAdmin/dataFilter?menuUtama=active&thn_akademik=' . $dataPeriodeAktif->thn_akademik . '&semester=' . $dataPeriodeAktif->nama_semester) ?>" class="small-box-footer">Lihat Data <i class="fas fa-arrow-circle-right"></i></a>
                                        </div>
                                    </div>
                                    <!-- ./col -->
                                    <div class="col-lg-4 col-6">
                                        <!-- small box -->
                                        <div class="small-box bg-warning">
                                            <div class="inner">
                                                <h3><?= $countMkl; ?></h3>

                                                <p>Total Matakuliah</p>
                                            </div>
                                            <div class="icon">
                                                <i class="fas fa-book"></i>
                                            </div>
                                            <a href="<?php echo base_url('admin/userAdmin/dataFilter?menuUtama=active&thn_akademik=' . $dataPeriodeAktif->thn_akademik . '&semester=' . $dataPeriodeAktif->nama_semester) ?>" class="small-box-footer">Lihat Data <i class="fas fa-arrow-circle-right"></i></a>
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
                                                        <li class="dropdown-item"><a href="<?= base_url('admin/userAdmin/dataFilter?menuUtama=active&thn_akademik=' . $d->thn_akademik); ?>"><?php echo 'Periode ' . $d->thn_akademik; ?></a></li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </div>
                                            <!-- /btn-group -->
                                        </div>
                                        <!-- /input-group -->
                                        <table id="dataTablesAsc1" class="table table-bordered table-hover mt-5">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">#</th>
                                                    <th class="text-center">Matakuliah</th>
                                                    <th class="text-center">Kelas</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no = 1;
                                                foreach ($dataIndex as $d) : ?>
                                                    <tr>
                                                        <td class="text-center"><?php echo $no++; ?></td>
                                                        <td class="text-left"><?php echo '<a href="' . base_url('admin/userAdmin/dataDetail?menuUtama=active&thn_akademik=' . $dataPeriodeAktif->thn_akademik . '&semester=' . $dataPeriodeAktif->nama_semester . '&matakuliah=' . $d->id_penilaian_matakuliah . '&kelas=' . $d->kelas . '&namamk=' . $d->matakuliah) . '"><strong>' . $d->matakuliah . '</strong></a>'; ?></td>
                                                        <td class="text-center"><?php echo $d->kelas; ?></td>
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