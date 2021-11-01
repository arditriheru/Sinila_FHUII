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
                                <li class="breadcrumb-item active"><?php echo $title; ?></li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <h2 class="text-center display-4"><?php echo $pencarian_dokumen; ?></h2>
                    <div class="row mb-5">
                        <div class="col-md-8 offset-md-2">
                            <form action="<?php echo base_url("ijazah/dataIjazah/cari/") ?>" method="post" id="import_form" enctype="multipart/form-data">
                                <div class="input-group">
                                    <input type="search" class="form-control form-control-lg" name="nama_mhs" value="<?php echo $keyword ?>" required="">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-lg btn-default">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card">
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
                                                        <a class="btn btn-primary btn-sm" href="<?php echo base_url() . 'ijazah/dataIjazah/cari?nama_mhs=' . $keyword . '&preview=' . substr($d->dokumen, 0, -16) . 'preview'; ?>">
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
                            </div>
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