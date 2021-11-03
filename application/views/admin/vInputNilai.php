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
                                <h3 class="card-title">Data Mahasiswa</strong></h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <table id="dataTablesAsc1" class="table table-bordered table-hover">

                                            <?php
                                            if ($id == 1) { ?>

                                                <thead>
                                                    <tr>
                                                        <th class="text-center">#</th>
                                                        <th class="text-center">Nama Mahasiswa</th>
                                                        <th class="text-center">Nilai UTS</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $no = 1;
                                                    foreach ($dataMahasiswa as $d) : ?>
                                                        <tr>
                                                            <td class="text-center"><?php echo $no++; ?></td>
                                                            <td class="text-left"><?php echo $d->id_mahasiswa . '@student.uii.ac.id<br><strong>' . $d->nama_mahasiswa . '</strong>'; ?></td>
                                                            <td><input type="text" class="form-control" name="nilai[]" id="nilai" placeholder="Penilaian skala angka 1-100" required=""></td>
                                                        </tr>

                                                    <?php endforeach; ?>
                                                </tbody>

                                            <?php } elseif ($id == 2) { ?>

                                                <thead>
                                                    <tr>
                                                        <th class="text-center">#</th>
                                                        <th class="text-center">Nama Mahasiswa</th>
                                                        <th class="text-center">Nilai UAS</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $no = 1;
                                                    foreach ($dataMahasiswa as $d) : ?>
                                                        <tr>
                                                            <td class="text-center"><?php echo $no++; ?></td>
                                                            <td class="text-left"><?php echo $d->id_mahasiswa . '@student.uii.ac.id<br><strong>' . $d->nama_mahasiswa . '</strong>'; ?></td>
                                                            <td><input type="text" class="form-control" name="nilai[]" id="nilai" placeholder="Penilaian skala angka 1-100" required=""></td>
                                                        </tr>

                                                    <?php endforeach; ?>
                                                </tbody>

                                            <?php } else { ?>

                                                <thead>
                                                    <tr>
                                                        <th class="text-center">#</th>
                                                        <th class="text-center">Nama Mahasiswa</th>
                                                        <th class="text-center">Nilai Tugas</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $no = 1;
                                                    foreach ($dataMahasiswa as $d) : ?>
                                                        <tr>
                                                            <td class="text-center"><?php echo $no++; ?></td>
                                                            <td class="text-left"><?php echo $d->id_mahasiswa . '@student.uii.ac.id<br><strong>' . $d->nama_mahasiswa . '</strong>'; ?></td>
                                                            <td><input type="text" class="form-control" name="nilai[]" id="nilai" placeholder="Penilaian skala angka 1-100" required=""></td>
                                                        </tr>

                                                    <?php endforeach; ?>
                                                </tbody>

                                            <?php }
                                            ?>

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