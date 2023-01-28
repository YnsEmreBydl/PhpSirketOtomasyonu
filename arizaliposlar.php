<?php require_once('baglan.php') ?>

<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Muhasebe Uygulaması</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">

  <script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
  <link rel="stylesheet" href="sweetalert2.min.css">
<!-- JavaScript -->
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

<!-- CSS -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
<!-- Default theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>
<!-- Semantic UI theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.min.css"/>
<!-- Bootstrap theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css"/></head>

</head>
<div class="wrapper">



  <?php require_once('header.php') ?>

  <?php require_once('sidebar.php') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">


        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">

      <div class="card card-solid">

        <div class="card-body pb-0">
<h3>ARIZALI POS CİHAZLARI</h3><hr>
          <div class="row">
            <?php


                  $sayfada = 10; // sayfada gösterilecek içerik miktarını belirtiyoruz.
                     $sorgu=$db->prepare("SELECT * FROM pos");
                     $sorgu->execute();
                     $toplam_icerik=$sorgu->rowCount();
                     $toplam_sayfa = ceil($toplam_icerik / $sayfada);
                  // eğer sayfa girilmemişse 1 varsayalım.
                     $sayfa = isset($_GET['sayfa']) ? (int) $_GET['sayfa'] : 1;
          // eğer 1'den küçük bir sayfa sayısı girildiyse 1 yapalım.
                     if($sayfa < 1) $sayfa = 1;
        // toplam sayfa sayımızdan fazla yazılırsa en son sayfayı varsayalım.
                     if($sayfa > $toplam_sayfa) $sayfa = $toplam_sayfa;
                     $limit = ($sayfa - 1) * $sayfada;

             if ($toplam_icerik == 0) {?>
                    <div class="alert alert-warning col-12">ARIZALI POS BULUNMAMAKTADIR</div>
              <?php } else{

                       $poscek = $db -> prepare("select * from pos where pos_durum=:pos_durum limit $limit, $sayfada");
                      $poscek -> execute(array('pos_durum'=>0));
                      $toplam_icerik=$poscek->rowCount();
                    while ($possor = $poscek -> fetch(PDO::FETCH_ASSOC)){   ?>
            <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
              <div class="card bg-light d-flex flex-fill">
                <div class="card-header text-muted border-bottom-0">
                </div>
                <div class="card-body pt-0">
                  <div class="row">
                    <div class="col-7">
                      <p class="text-muted text-sm"><b>MARKA: </b> <?php echo $possor['pos_marka'] ?> </p>
                      <ul class="ml-4 mb-0 fa-ul text-muted">
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Adres: <?php echo $possor['pos_adres'] ?></li><hr>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Telefon: <?php echo $possor['pos_tel'] ?></li><hr>

                          <li class="small"><span class="fa-li"><i class="fas fa-wallet"></i></span> Terminal No: <?php echo $possor['pos_terminal'] ?></li><hr>
                            <li class="small"><span class="fa-li"><i class="fas fa-wallet"></i></span> Seri No: <?php echo $possor['pos_seri'] ?></li><hr>
                            <li style="width:350px"><span class="fa-li"><i class="fas fa-wallet"></i></span> ARIZA AÇIKLAMA:<b> <?php echo $possor['pos_aciklama'] ?></b></li>

                      </ul>
                    </div>
                 <div class="col-5 text-center">
                      <img src="dist/img/pos-terminal.png" alt="user-avatar" class="img-fluid">
                    </div>
                  </div>
                </div>

                <div class="card-footer">

                  <div class="text-right">
                     <td>
                        <?php if ($possor['pos_durum']==1) { ?>

                          <div class="btn btn-success btn-sm">Aktif</div>

                        <?php } elseif($possor['pos_durum']==0) {?>
                          <div class="btn btn-danger btn-sm">Arızalı</div>
                        <?php } ?>
                      </td>

                      <td><a href="duzenle.php?sayfa=posduzenle&pos_id=<?php echo $possor['pos_id'] ?>"><button type="submit" class="btn btn-warning btn-sm">Düzenle</button></a></td>



                  </div>
                </div>
              </div>
            </div>
         <?php } ?>
       <?php } ?>
        </div>
  <a href="ekle.php?sayfa=posekle"><button class="btn btn-primary" style="float:right;">Yeni Pos Ekle</button></a>
      </div>

  <ul style="float:right;" class="pagination p-3">
    <li class="page-item"><a class="page-link" href="borc.php?sayfa=<?php $s--; ?>">Geri</a></li>
     <?php

                          $s=0;

                          while ($s < $toplam_sayfa) {

                            $s++; ?>

                            <?php

                            if ($s==$sayfa) {?>
    <li class="page-item active"><a class="page-link" href="pos.php?sayfa=<?php echo $s; ?>"><?php echo $s; ?></a></li>
     <?php } else {?>
        <li>

      <li class="page-item"><a class="page-link" href="pos.php?sayfa=<?php echo $s; ?>"><?php echo $s; ?></a></li>

                            </li>

                            <?php   }

                          }

                          ?>
    <li class="page-item"><a class="page-link" href="#">İleri</a></li>
  </ul>
</nav>

              </div>
               </div>
            <!-- /.card -->

            <!-- /.card -->
          </div>
          <!-- /.col -->

          <!-- /.col -->
        </div>
        <!-- /.row (main row) -->

      </div><!-- /.container-fluid -->

    </section>
    <!-- /.content -->
  </div>
              </div>

  <!-- /.content-wrapper -->

  <?php require_once('footer.php') ?>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>

<script src="dist/js/pages/dashboard.js"></script>

 <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
 <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>




 <?php if (@$_GET['posdurum']=="poseklendi") {?>
 <script type="text/javascript">


Swal.fire({
  position: 'center',
  icon: 'success',
  title: 'Yeni pos Eklendi',
  showConfirmButton: false,
  timer: 1500
});

  </script>

<?php } ?>

 <?php if (@$_GET['posdurum']=="posguncellendi") {?>
 <script type="text/javascript">


Swal.fire({
  position: 'center',
  icon: 'success',
  title: 'pos Güncellendi',
  showConfirmButton: false,
  timer: 1500
});

  </script>

<?php } ?>





</body>
</html>
