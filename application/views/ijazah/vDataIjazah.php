<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <?php $this->view('ijazah/vMenu'); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1><?php echo $title; ?></h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                <li class="breadcrumb-item active"><?php echo $title; ?></li>
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

                        <?php if ($id == 1) { ?>

                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title"><?php echo $subtitle; ?></h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <table id="example2" class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">#</th>
                                                    <th class="text-center"><?php echo $nim; ?></th>
                                                    <th class="text-center"><?php echo $nama_mahasiswa; ?></th>
                                                    <th class="text-center"><?php echo $tmpt_tgl_lahir; ?></th>
                                                    <th class="text-center"><?php echo $nama_ortu; ?></th>
                                                    <th class="text-center"><?php echo $tahun; ?></th>
                                                    <th class="text-center">Detail</th>
                                                    <th class="text-center" colspan="2">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php $no = 1;
                                                foreach ($dataijazah as $d) : ?>

                                                    <tr>
                                                        <td class="text-center"><?php echo $no++; ?></td>
                                                        <td class="text-center"><?php echo $d->nim; ?></td>
                                                        <td class="text-left"> <?php echo $d->nama_mhs; ?></td>
                                                        <td class="text-center">
                                                            <?php
                                                            if ($d->tgl_lahir == "0000-00-00") {
                                                                echo $d->tmpt_lahir . ', - ';
                                                            } else {
                                                                echo $d->tmpt_lahir . ', ' . formatDateIndo($d->tgl_lahir);
                                                            } ?>
                                                        </td>
                                                        <td class="text-center"><?php echo $d->nama_ortu; ?></td>
                                                        <td class="text-center"><?php echo $d->thn_akademik; ?></td>
                                                        <td class="text-center"><?php echo date("d-m-Y", strtotime($d->tanggal)) . "&nbsp;" . $d->jam; ?></td>
                                                        <td class="text-center">
                                                            <a class="btn btn-info btn-sm" href="<?php echo $d->dokumen; ?>" target="_blank">
                                                                <i class="fas fa-folder-open">
                                                                </i>
                                                                <?php echo $buka; ?>
                                                            </a>
                                                            <a class="btn btn-primary btn-sm" href="<?php echo base_url() . 'ijazah/dataIjazah/dataIjazah/1?preview=' . substr($d->dokumen, 0, -16) . 'preview'; ?>">
                                                                <i class="fas fa-eye">
                                                                </i>
                                                                Preview
                                                            </a>
                                                        </td>
                                                    </tr>

                                                <?php endforeach; ?>

                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                            </div>

                            <?php if (isset($preview)) { ?>
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">Preview</h3>
                                        </div>
                                        <!-- /.card-header -->
                                        <div class="card-body">
                                            <iframe src="<?php echo $preview; ?>" width="100%" height="700px" allow="autoplay"></iframe>
                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                    <!-- /.card -->
                                </div>
                            <?php } ?>

                        <?php } elseif ($id == 2) { ?>

                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title"><?php echo $subtitle; ?></h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <form action="<?php echo base_url("ijazah/dataIjazah/upload/" . $id) ?>" method="post" enctype="multipart/form-data">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label for="nim">NIM</label>
                                                    <input type="number" class="form-control" name="nim" id="nim" placeholder="Masukkan.." required="">
                                                </div>
                                                <div class="form-group">
                                                    <label for="nama_mhs">Nama Mahasiswa</label>
                                                    <input type="text" class="form-control" name="nama_mhs" id="nama_mhs" onkeyup="this.value = this.value.toUpperCase()" placeholder="Masukkan.." required="">
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-7">
                                                        <div class="form-group">
                                                            <label for="tmpt_lahir">Tempat Lahir</label>
                                                            <input type="text" class="form-control" name="tmpt_lahir" id="tmpt_lahir" onkeyup="this.value = this.value.toUpperCase()" placeholder="Masukkan..">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="form-group">
                                                            <label for="tgl_lahir">Tanggal Lahir</label>
                                                            <input type="date" class="form-control" name="tgl_lahir" id="tgl_lahir" placeholder="Masukkan..">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="nama_ortu">Nama Ortu</label>
                                                    <input type="text" class="form-control" name="nama_ortu" id="nama_ortu" onkeyup="this.value = this.value.toUpperCase()" placeholder="Masukkan..">
                                                </div>
                                                <div class="form-group">
                                                    <label for="thn_akademik">Tahun Akademik</label>
                                                    <input type="number" class="form-control" name="thn_akademik" id="thn_akademik" placeholder="Masukkan..">
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="dokumen">Upload Dokumen</label>
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input" name="upload" id="customFile">
                                                                <label class="custom-file-label" for="customFile">Choose file</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="dokumen">Link Dokumen</label>
                                                            <input type="text" class="form-control" name="link" id="dokumen" placeholder="Masukkan..">
                                                        </div>
                                                    </div>
                                                </div>

                                                <button type="submit" class="btn btn-primary btb-kirim">Tambah</button>
                                                <button class="btn btn-primary btn-loading d-none" type="button" disabled>
                                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                    Loading...
                                                </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        <?php } elseif ($id == 3) { ?>

                            <div class="col-md-6">
                                <a class="btn btn-primary mb-2" href="<?php echo base_url(); ?>ijazah/dataIjazah/spreadhseet_format_download">Download Template</a>
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title"><?php echo $subtitle; ?></h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <form action="<?php echo base_url("ijazah/dataIjazah/spreadsheet_import/") ?>" method="post" id="import_form" enctype="multipart/form-data">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div class="custom-file">
                                                        <input type="file" name="upload_file" id="upload_file" required accept=".xls, .xlsx">
                                                    </div>
                                                    <input type="submit" name="import" value="Upload" class="btn btn-info" />
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        <?php } ?>

                        <!--/.col (main) -->
                    </div>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <?php echo getVersion(); ?>
            </div>
            <strong><?php echo getCopyright(); ?></strong>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->