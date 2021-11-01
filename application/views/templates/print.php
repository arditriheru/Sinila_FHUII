<!DOCTYPE html>
<html lang="en">

<!-- /**
 * Gateway Fakultas Hukum Universitas Islam Indonesia
 *
 * @package CodeIgniter
 * @author Ardi Tri Heru (arditriheruh@gmail.com)
 * @link https://github.com/arditriheru
 */

/**
 */ -->

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo getTopTitle(); ?></title>

	<link rel="icon" type="image/png" href="<?php echo base_url(); ?>assets/login/images/icons/favicon.jpg" />
	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/fontawesome-free/css/all.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<!-- Tempusdominus Bootstrap 4 -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
	<!-- iCheck -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
	<!-- JQVMap -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/jqvmap/jqvmap.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/adminlte.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/adminlte.css">
	<!-- overlayScrollbars -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
	<!-- Daterange picker -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/daterangepicker/daterangepicker.css">
	<!-- summernote -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/summernote/summernote-bs4.min.css">
	<!-- DataTables -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
	<!-- flag-icon-css -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/flag-icon-css/css/flag-icon.min.css">
	<!-- chatbox-css -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/chatbox.css">

	<style type="text/css">
		.invoice-title h2,
		.invoice-title h3 {
			display: inline-block;
		}

		.table>tbody>tr>.no-line {
			border-top: none;
		}

		.table>thead>tr>.no-line {
			border-bottom: none;
		}

		.table>tbody>tr>.no-line {
			border-top: 2px solid;
		}

		.red-text {
			color: red !important;
		}

		@media print {
			h1 {
				font-family: "Britannic Bold", Broadway, Calibri, sans-serif;
			}

			p {
				font-size: 10pt;
				font-family: "Calibri", serif;
			}

			.red-text {
				color: red !important;
			}

			.print-title {
				font-size: 12pt;
			}

			.print-thead {
				font-size: 10pt;
			}

			.print-text-tiny {
				font-size: 7pt;
			}

			.noprint {
				display: none;
			}
		}
	</style>

	<script language="javascript" type="text/javascript">
		window.addEventListener("load", window.print());

		function windowClose() {
			window.open('', '_parent', '');
			window.close();
		}
	</script>
</head>