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
                                <h3 class="card-title">Data Jadwal</strong></h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <a class="btn btn-primary mb-2" href="#" data-toggle="modal" data-target="#modalUploadJadwal">Upload Data</a>
                                <table id="dataTablesAsc1" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">Matakuliah</th>
                                            <th class="text-center">Nama Dosen</th>
                                            <th class="text-center">Kelas</th>
                                            <th class="text-center">Semester</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($dataJadwal as $d) : ?>
                                            <tr>
                                                <td class="text-center"><?php echo $no++; ?></td>
                                                <td class="text-left"><?php echo $d->id_matakuliah . '<br><strong>' . $d->matakuliah . '</strong>'; ?></td>
                                                <td class="text-left"><?php echo $d->id_dosen . '<br><strong>' . $d->nama_dosen . '</strong>'; ?></td>
                                                <td class="text-center"><?= $d->kelas ?></td>
                                                <td class="text-left"><?php echo $d->nm_semester . '<br><strong>' . $d->thn_akademik . '</strong>'; ?></td>
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