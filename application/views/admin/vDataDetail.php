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
                            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
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
                                <h3 class="card-title">Matakuliah : <strong><?= $this->input->get('namamk'); ?></strong> Kelas : <strong><?= $this->input->get('kelas'); ?></strong></h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-lg-12">

                                        <form class="form-prevent" action="<?php echo base_url('dosen/userDosen/inputNilai') ?>" method="post" enctype="multipart/form-data">

                                            <table id="dataTablesAsc2" class="table table-bordered table-hover mt-5">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" rowspan="2">#</th>
                                                        <th class="text-center" rowspan="2">Nama Mahasiswa</th>
                                                        <th class="text-center" rowspan="2">Matakuliah</th>
                                                        <th class="text-center" colspan="3">Nilai</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-center">UTS</th>
                                                        <th class="text-center">UAS</th>
                                                        <th class="text-center">Tugas</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php $no = 1;
                                                    foreach ($dataAbsensi as $d) : ?>
                                                        <tr>
                                                            <td class="text-center"><?php echo $no++; ?></td>
                                                            <td class="text-left"><?php echo $d->id_mahasiswa . '@student.uii.ac.id<br><strong>' . $d->nama_mahasiswa . '</strong>'; ?></td>
                                                            <td class="text-left"><?php echo ' (Kelas ' . $d->kelas . ') ' . '<br><strong>' . $d->matakuliah . '</strong>'; ?></td>
                                                            <td class="text-center"><?= $d->uts; ?></td>
                                                            <td class="text-center"><?= $d->uas; ?></td>
                                                            <td class="text-center"><?= $d->tugas; ?></td>
                                                        </tr>

                                                    <?php endforeach; ?>

                                                </tbody>
                                            </table>
                                            <button class="btn btn-info button-prevent float-sm-right mt-2 mb-5" type="submit">
                                                <!-- spinner-border adalah component bawaan bootstrap untuk menampilakn roda berputar  -->
                                                <div class="spinner"><i role="status" class="spinner-border spinner-border-sm"></i> Input Nilai </div>
                                                <div class="hide-text">Input Nilai</div>
                                            </button>
                                        </form>

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