<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>PRODUCTOSTECNOLOGICOS - <?php echo $titulo; ?></title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;700;900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="/plugins/fontawesome-free/css/all.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Tempusdominus Bootstrap 4 -->
        <link rel="stylesheet" href="/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
        <!-- JQVMap -->
        <link rel="stylesheet" href="/plugins/jqvmap/jqvmap.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="/dist/css/adminlte.min.css">
  

        <!-- overlayScrollbars -->
        <link rel="stylesheet" href="/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
        <!-- Daterange picker -->
        <link rel="stylesheet" href="/plugins/daterangepicker/daterangepicker.css">
        <!-- summernote -->
        <link rel="stylesheet" href="/plugins/summernote/summernote-bs4.min.css">

        <link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
        <link rel="stylesheet" href="/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
        <link rel="stylesheet" href="/build/css/app.css">
        <link rel="stylesheet" href="/plugins/select2/css/select2.min.css">
        <link rel="stylesheet" href="/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">




        
    </head>

    <!--  sidebar-collapse -->
    <body class="hold-transition sidebar-mini <?php echo pagina_actual('crear-venta') ? 'sidebar-collapse':''?> layout-fixed">
        <div class="wrapper">
          
            <!-- Preloader -->
            <?php   include_once __DIR__ .'/templates/header.php';?>
            
            <?php   include_once __DIR__ .'/templates/sidebar.php';?>
            <div class="content-wrapper">
                <?php echo $contenido; ?>
            </div> 
            <?php   include_once __DIR__ .'/templates/aside.php';?>
            <?php   include_once __DIR__ .'/templates/footer.php';?>

        </div>
        


        <script src="/plugins/jquery/jquery.min.js"></script>
        <!-- jQuery UI 1.11.4 -->
        <script src="/plugins/jquery-ui/jquery-ui.min.js"></script>
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <script>
        $.widget.bridge('uibutton', $.ui.button)
        </script>
        <!-- Bootstrap 4 -->
        <script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- ChartJS -->
       <!--  <script src="/plugins/chart.js/Chart.min.js"></script> -->
        <!-- Sparkline -->
  <!--       <script src="/plugins/sparklines/sparkline.js"></script> -->
        <!-- JQVMap -->
  <!--   <script src="/plugins/jqvmap/jquery.vmap.min.js"></script>  -->
<!--       <script src="/plugins/jqvmap/maps/jquery.vmap.usa.js"></script> -->
  
    <!--     <script src="/plugins/jquery-knob/jquery.knob.min.js"></script> -->
        <!-- daterangepicker -->
       <!--  <script src="/plugins/moment/moment.min.js"></script> -->
  <!--       <script src="/plugins/daterangepicker/daterangepicker.js"></script> -->
        <!-- Tempusdominus Bootstrap 4 -->
<!--         <script src="/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script> -->
        <!-- Summernote -->
   <!--      <script src="/plugins/summernote/summernote-bs4.min.js"></script> -->
        <!-- overlayScrollbars -->
 <!--        <script src="/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script> -->
        <!-- AdminLTE App -->
     
        <script src="/dist/js/adminlte.js"></script>
        <!-- AdminLTE for demo purposes -->
    
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
   <!--   <script src="/dist/js/pages/dashboard.js"></script>  -->

        <script src="/plugins/select2/js/select2.full.min.js"></script>
        <script src="/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
        <script src="/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
        <script src="/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
        <script src="/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
        <script src="/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
        <script src="/plugins/jszip/jszip.min.js"></script>
        <script src="/plugins/pdfmake/pdfmake.min.js"></script>
        <script src="/plugins/pdfmake/vfs_fonts.js"></script>
        <script src="/plugins/daterangepicker/daterangepicker.js"></script>
        <script src="/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
        <script src="/plugins/datatables-buttons/js/buttons.print.min.js"></script>
        <script src="/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
        <script src="/plugins/select2/js/select2.full.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> 
        <script src="../../plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="../../plugins/jquery-validation/additional-methods.min.js"></script>
        <script>
        // $(function () {
        //     $("#tabla").DataTable({
        //     "responsive": true, "lengthChange": false, "autoWidth": false,
        //     "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        //     }).buttons().container().appendTo('#tabla_wrapper .col-md-6:eq(0)');
            
        // });
</script>
<script>

</script>


            <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js" integrity="sha512-ElRFoEQdI5Ht6kZvyzXhYG9NqjtkmlkfYk0wr6wHxU9JEHakS7UJZNeml5ALk+8IKlU6jDgMabC3vkumRokgJA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
     <!--        <script src="/build/js/main.min.js" defer></script> -->
            <script src="/build/js/bundle.min.js" defer></script>

    </body>
</html>