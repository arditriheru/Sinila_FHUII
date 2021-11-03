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
                                <h3 class="card-title">Tahun Akademik : <strong><?= $this->input->get('thn_akademik'); ?></strong></h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h5><i class="nav-icon fas fa-angle-right"></i><a href="<?= base_url('admin/userAdmin/dataFilter?menuUtama=active&thn_akademik=' . $this->input->get('thn_akademik') . '&semester=1'); ?>"> Semester Ganjil</a></h5>
                                        <h5><i class="nav-icon fas fa-angle-right"></i><a href="<?= base_url('admin/userAdmin/dataFilter?menuUtama=active&thn_akademik=' . $this->input->get('thn_akademik') . '&semester=2'); ?>"> Semester Genap</a></h5>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">

                                        <?php if ($this->input->get('semester')) { ?>

                                            <table id="dataTablesAsc1" class="table table-bordered table-hover mt-5">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">#</th>
                                                        <th class="text-center">Matakuliah</th>
                                                        <th class="text-center">SKS</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $no = 1;
                                                    foreach ($dataMatkul as $d) : ?>
                                                        <tr>
                                                            <td class="text-center"><?php echo $no++; ?></td>
                                                            <td class="text-left"><?php echo '<a href="' . base_url('admin/userAdmin/dataFilter?menuUtama=active&thn_akademik=' . $this->input->get('thn_akademik') . '&semester=' . $this->input->get('semester') . '&matakuliah=' . $d->id_penilaian_matakuliah) . '"><strong>' . $d->matakuliah . '</strong></a>'; ?></td>
                                                            <td class="text-center"><?php echo $d->sks; ?></td>
                                                        </tr>

                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>

                                        <?php } ?>

                                    </div>

                                    <div class="col-lg-8">

                                        <?php if ($this->input->get('matakuliah')) { ?>

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
                                                            <td class="text-left"><?php echo $d->id_penilaian_mahasiswa . '@student.uii.ac.id<br><strong>' . $d->nama_mahasiswa . '</strong>'; ?></td>
                                                            <td class="text-center"><?php echo $d->matakuliah; ?></td>
                                                            <td class="text-center"><?= $d->uts; ?>
                                                            <td class="text-center"><?= $d->uas; ?>
                                                            <td class="text-center"><?= $d->tugas; ?></td>
                                                        </tr>

                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>

                                        <?php } ?>

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