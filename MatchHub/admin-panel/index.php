<?php require_once 'inc/header.php'; ?>
<!-- Sidebar menu-->
<?php require_once 'inc/sidebar.php'; ?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i> Admin Panel</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="#">Ana Sayfa</a></li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-6 col-lg-3">
      <div class="widget-small primary coloured-icon"><i class="icon fa fa-users fa-3x"></i>
        <div class="info">
          <h4>Kullanıcılar</h4>
          <p><b><?php echo rowresult('bayiler');  ?></b></p>
        </div>
      </div>
    </div>


    <div class="col-md-6 col-lg-3">
      <div class="widget-small danger coloured-icon"><i class="icon fa fa-gift fa-3x"></i>
        <div class="info">
          <h4>Oyunlar</h4>
          <p><b><?php echo rowresult('urunler');  ?></b></p>
        </div>
      </div>
    </div>
  </div>
  <div class="row">







  </div>
</main>

<?php require_once 'inc/footer.php'; ?>