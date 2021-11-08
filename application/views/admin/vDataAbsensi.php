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
                                <h3 class="card-title">Data Absensi</strong></h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <a class="btn btn-primary mb-2" href="#" data-toggle="modal" data-target="#modalUploadAbsen">Upload Data</a>
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
                                                <td class="text-left"><?php echo '<a href="' . base_url('admin/userAdmin/dataDetail?menuUtama=active&thn_akademik=' . $dataPeriodeAktif->thn_akademik . '&semester=' . $dataPeriodeAktif->nama_semester . '&matakuliah=' . $d->id_matakuliah . '&kelas=' . $d->kelas . '&namamk=' . $d->matakuliah) . '"><strong>' . $d->matakuliah . '</strong></a>'; ?></td>
                                                <td class="text-center"><?php echo $d->kelas; ?></td>
                                            </tr>

                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
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