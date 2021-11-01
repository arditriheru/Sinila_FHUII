<!DOCTYPE html>
<html lang="en">

<!-- /**
 * Gateway Fakultas Hukum Universitas Islam Indonesia
 *
 * @package CodeIgniter
 * @author Ardi Tri Heru (arditriheruh@gmail.com)
 * @link https://arditriheru.com/
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
  <!-- Toastr -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/toastr/toastr.min.css">

  <style>
    /* untuk menghilangkan spinner  */
    .spinner {
      display: none;
    }

    .required:after {
      content: " *";
      color: red;
    }
  </style>

  <script type="text/javascript">
    $(document).ready(function() {
      $('#imageupload').submit(function(e) {
        if ($('#image_up_id').val()) {
          e.preventDefault();

          $("#progress-bar-status-show").width('0%');
          var file_details = document.getElementById("image_up_id").files[0];
          var extension = file_details['name'].split(".");

          var allowed_extension = ["png", "jpg", "jpeg"];
          var check_for_valid_ext = allowed_extension.indexOf(extension[1]);



          if (file_details['size'] > 2097152) {
            alert('Please upload a file less than 2 MB');
            return false;
          } else if (check_for_valid_ext == -1) {
            alert('upload valid image file');
            return false;
          } else {
            if (file_details['size'] < 2097152 && check_for_valid_ext != -1) {
              $('#loader').show();
              $(this).ajaxSubmit({
                target: '#toshow',
                beforeSubmit: function() {
                  $("#progress-bar-status-show").width('0%');
                },
                uploadProgress: function(event, position, total, percentComplete) {
                  $("#progress-bar-status-show").width(percentComplete + '%');
                  $("#progress-bar-status-show").html('<div id="progress-percent">' + percentComplete + ' %</div>');
                },
                success: function() {
                  $('#loader').hide();
                  $('#imageDiv').show();
                  var url = $('#toshow').text();
                  var img = document.createElement("IMG");
                  img.src = url;
                  img.height = '100';
                  img.width = '150';
                  document.getElementById('imageDiv').appendChild(img);
                },
                resetForm: true
              });
              return false;
            }
          }
        }
      });
    });
  </script>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">