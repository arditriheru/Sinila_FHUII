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
                                <h3 class="card-title">Tahun Akademik : <strong><?= $dataPeriodeAktif->thn_akademik . ' - ' . $dataPeriodeAktif->nm_semester; ?></strong></h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-lg-7">
                                        <a class="btn btn-success btn-xs mb-3" data-toggle="modal" data-target="#modalTambahSemester">
                                            <i class="fas fa-plus"></i> Semester
                                        </a>
                                        <table id="dataTablesDesc1" class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">#</th>
                                                    <th class="text-center">Semester</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no = $count1;
                                                foreach ($dataSemester as $d) : ?>
                                                    <tr>
                                                        <td class="text-center"><?php echo $no--; ?></td>
                                                        <td class="text-left"><?php echo '<strong>' . $d->thn_akademik . '</strong><br>' . $d->nm_semester; ?></td>
                                                        <td class="text-center">
                                                            <a data-toggle="modal" data-target="#modalEditSemester<?php echo $d->id_semester; ?>" class="btn btn-primary btn-xs mb-3">
                                                                <i class="fas fa-edit"></i> Edit
                                                            </a>
                                                            <?php if ($d->aktif == 1) { ?>
                                                                <a href="<?php echo base_url('admin/userAdmin/nonaktifDataSemesterAksi/' . $d->id_semester); ?>" class="btn btn-success btn-xs mb-3" onclick="javascript: return confirm('Yakin non-aktifkan semester?')">
                                                                    <i class="fas fa-check"></i> Aktif
                                                                </a>
                                                            <?php } else { ?>
                                                                <a href="<?php echo base_url('admin/userAdmin/aktifDataSemesterAksi/' . $d->id_semester); ?>" class="btn btn-danger btn-xs mb-3" onclick="javascript: return confirm('Yakin aktifkan semester?')">
                                                                    <i class="fas fa-times"></i> Nonaktif
                                                                </a>
                                                            <?php } ?>

                                                        </td>
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

<!-- modal tambah semester -->
<div class="modal fade" id="modalTambahSemester">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Semester</h4><br>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-prevent" action="<?php echo base_url('admin/userAdmin/tambahDataSemesterAksi') ?>" method="post" enctype="multipart/form-data">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Form Data</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Tahun Akademik</label>
                                        <select name="id_thn_akademik" class="form-control select2" style="width: 100%;" required="">
                                            <option value="" selected="">Pilih</option>

                                            <?php foreach ($dataThnAkad as $d) : ?>
                                                <option value="<?php echo $d->id_thn_akademik; ?>"><?php echo $d->thn_akademik; ?></option>
                                            <?php endforeach; ?>

                                        </select>
                                    </div>
                                    <!-- /.form-group -->
                                    <div class="form-group">
                                        <label>Semester</label>
                                        <select name="nama_semester" class="form-control select2" style="width: 100%;" required="">
                                            <option value="" selected="">Pilih</option>
                                            <option value="1">Ganjil</option>
                                            <option value="2">Genap</option>
                                        </select>
                                    </div>
                                    <!-- /.form-group -->
                                </div>

                            </div>
                        </div>
                    </div>
                    <button class="btn btn-info button-prevent" type="submit">
                        <!-- spinner-border adalah component bawaan bootstrap untuk menampilakn roda berputar  -->
                        <div class="spinner"><i role="status" class="spinner-border spinner-border-sm"></i> Submit </div>
                        <div class="hide-text">Submit</div>
                    </button>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- modal edit semester -->
<?php foreach ($dataSemester as $d) : ?>
    <div class="modal fade" id="modalEditSemester<?php echo $d->id_semester; ?>">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Semester</h4><br>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-prevent" action="<?php echo base_url('admin/userAdmin/editDataSemesterAksi/' . $d->id_semester) ?>" method="post" enctype="multipart/form-data">
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">Form Data</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Tahun Akademik</label>
                                            <select name="id_thn_akademik" class="form-control select2" style="width: 100%;" required="">
                                                <option value="<?php echo $d->id_thn_akademik; ?>" selected=""><?php echo $d->thn_akademik; ?></option>

                                                <?php foreach ($dataThnAkad as $a) : ?>
                                                    <option value="<?php echo $a->id_thn_akademik; ?>"><?php echo $a->thn_akademik; ?></option>
                                                <?php endforeach; ?>

                                            </select>
                                        </div>
                                        <!-- /.form-group -->
                                        <div class="form-group">
                                            <label>Semester</label>
                                            <select name="nama_semester" class="form-control select2" style="width: 100%;" required="">
                                                <option value="<?php echo $d->nama_semester; ?>" selected=""><?php echo $d->nm_semester; ?></option>
                                                <option value="1">Ganjil</option>
                                                <option value="2">Genap</option>
                                            </select>
                                        </div>
                                        <!-- /.form-group -->
                                    </div>

                                </div>
                            </div>
                        </div>
                        <button class="btn btn-info button-prevent" type="submit">
                            <!-- spinner-border adalah component bawaan bootstrap untuk menampilakn roda berputar  -->
                            <div class="spinner"><i role="status" class="spinner-border spinner-border-sm"></i> Submit </div>
                            <div class="hide-text">Submit</div>
                        </button>
                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
<?php endforeach; ?>
<!-- /.modal -->