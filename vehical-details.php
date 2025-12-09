<?php 
session_start();
include('includes/config.php');
include('includes/format_rupiah.php');
error_reporting(0);
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Rental Mobil DevEast</title>

<!-- CSS -->
<link rel="stylesheet" href="assets/css/bootstrap.min.css">
<link rel="stylesheet" href="assets/css/style.css">
<link rel="stylesheet" href="assets/css/owl.carousel.css">
<link rel="stylesheet" href="assets/css/owl.transitions.css">
<link rel="stylesheet" href="assets/css/slick.css">
<link rel="stylesheet" href="assets/css/bootstrap-slider.min.css">
<link rel="stylesheet" href="assets/css/font-awesome.min.css">

<!-- SWITCHER -->
<link rel="stylesheet" href="assets/switcher/css/switcher.css" />
<link rel="alternate stylesheet" href="assets/switcher/css/red.css" title="red" data-default-color="true" />
<link rel="alternate stylesheet" href="assets/switcher/css/orange.css" title="orange" />
<link rel="alternate stylesheet" href="assets/switcher/css/blue.css" title="blue" />
<link rel="alternate stylesheet" href="assets/switcher/css/pink.css" title="pink" />
<link rel="alternate stylesheet" href="assets/switcher/css/green.css" title="green" />
<link rel="alternate stylesheet" href="assets/switcher/css/purple.css" title="purple" />

<link rel="shortcut icon" href="assets/images/logo.png">
</head>

<body>

<!-- Switcher -->
<?php include('includes/colorswitcher.php');?>

<!-- Header -->
<?php include('includes/header.php');?>

<?php 
$vhid=intval($_GET['vhid']);
$sql = "SELECT mobil.*, merek.* FROM mobil JOIN merek ON merek.id_merek=mobil.id_merek WHERE mobil.id_mobil='$vhid'";
$query = mysqli_query($koneksidb,$sql);

if(mysqli_num_rows($query)>0){
while($result = mysqli_fetch_array($query)){
$_SESSION['brndid']=$result['id_merek'];
?>  

<section id="listing_img_slider">
  <div><img src="admin/img/vehicleimages/<?php echo htmlentities($result['image1']);?>" class="img-responsive"></div>
  <div><img src="admin/img/vehicleimages/<?php echo htmlentities($result['image2']);?>" class="img-responsive"></div>
  <div><img src="admin/img/vehicleimages/<?php echo htmlentities($result['image3']);?>" class="img-responsive"></div>
  <div><img src="admin/img/vehicleimages/<?php echo htmlentities($result['image4']);?>" class="img-responsive"></div>

  <?php if($result['image5'] != "") { ?>
  <div><img src="admin/img/vehicleimages/<?php echo htmlentities($result['image5']);?>" class="img-responsive"></div>
  <?php } ?>
</section>

<section class="listing-detail">
  <div class="container">
    <div class="listing_detail_head row">
      <div class="col-md-9">
        <h2><?php echo htmlentities($result['nama_merek']);?>, <?php echo htmlentities($result['nama_mobil']);?></h2>
      </div>
      <div class="col-md-3">
        <div class="price_info">
          <p><?php echo htmlentities(format_rupiah($result['harga']));?></p>/Hari
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-9">

        <!-- Fitur Utama -->
        <div class="main_features">
          <ul>
            <li><i class="fa fa-calendar"></i>
              <h5><?php echo htmlentities($result['tahun']);?></h5><p>Tahun Registrasi</p>
            </li>

            <li><i class="fa fa-cogs"></i>
              <h5><?php echo htmlentities($result['bb']);?></h5><p>Tipe Bahan Bakar</p>
            </li>

            <li><i class="fa fa-user-plus"></i>
              <h5><?php echo htmlentities($result['seating']);?></h5><p>Seats</p>
            </li>
          </ul>
        </div>

        <!-- Tab -->
        <div class="listing_more_info">
          <ul class="nav nav-tabs gray-bg" role="tablist">
            <li class="active"><a href="#vehicle-overview" data-toggle="tab">Deskripsi Kendaraan</a></li>
            <li><a href="#accessories" data-toggle="tab">Accessories</a></li>
          </ul>

          <div class="tab-content">

            <!-- Overview -->
            <div class="tab-pane active" id="vehicle-overview">
              <p><?php echo htmlentities($result['deskripsi']);?></p>
            </div>

            <!-- Accessories -->
            <div class="tab-pane" id="accessories">
              <table>
                <thead><tr><th colspan="2">Accessories</th></tr></thead>
                <tbody>

<tr><td>Air Conditioner</td>
<td><?php echo ($result['AirConditioner']==1) ? "<i class='fa fa-check'></i>" : "<i class='fa fa-close'></i>"; ?></td></tr>

<tr><td>AntiLock Braking System</td>
<td><?php echo ($result['AntiLockBrakingSystem']==1) ? "<i class='fa fa-check'></i>" : "<i class='fa fa-close'></i>"; ?></td></tr>

<tr><td>Power Steering</td>
<td><?php echo ($result['PowerSteering']==1) ? "<i class='fa fa-check'></i>" : "<i class='fa fa-close'></i>"; ?></td></tr>

<tr><td>Power Windows</td>
<td><?php echo ($result['PowerWindows']==1) ? "<i class='fa fa-check'></i>" : "<i class='fa fa-close'></i>"; ?></td></tr>

<tr><td>CD Player</td>
<td><?php echo ($result['CDPlayer']==1) ? "<i class='fa fa-check'></i>" : "<i class='fa fa-close'></i>"; ?></td></tr>

<tr><td>Leather Seats</td>
<td><?php echo ($result['LeatherSeats']==1) ? "<i class='fa fa-check'></i>" : "<i class='fa fa-close'></i>"; ?></td></tr>

<tr><td>Central Locking</td>
<td><?php echo ($result['CentralLocking']==1) ? "<i class='fa fa-check'></i>" : "<i class='fa fa-close'></i>"; ?></td></tr>

<tr><td>Power Door Locks</td>
<td><?php echo ($result['PowerDoorLocks']==1) ? "<i class='fa fa-check'></i>" : "<i class='fa fa-close'></i>"; ?></td></tr>

<tr><td>Brake Assist</td>
<td><?php echo ($result['BrakeAssist']==1) ? "<i class='fa fa-check'></i>" : "<i class='fa fa-close'></i>"; ?></td></tr>

<tr><td>Driver Airbag</td>
<td><?php echo ($result['DriverAirbag']==1) ? "<i class='fa fa-check'></i>" : "<i class='fa fa-close'></i>"; ?></td></tr>

<tr><td>Passenger Airbag</td>
<td><?php echo ($result['PassengerAirbag']==1) ? "<i class='fa fa-check'></i>" : "<i class='fa fa-close'></i>"; ?></td></tr>

<tr><td>Crash Sensor</td>
<td><?php echo ($result['CrashSensor']==1) ? "<i class='fa fa-check'></i>" : "<i class='fa fa-close'></i>"; ?></td></tr>

                </tbody>
              </table>
            </div>

          </div>
        </div>
<?php }} ?>

      </div>

      <!-- Sidebar -->
      <aside class="col-md-3">
        <div class="share_vehicle">
          <p>Share: 
            <a href="#"><i class="fa fa-facebook-square"></i></a>
            <a href="#"><i class="fa fa-twitter-square"></i></a>
            <a href="#"><i class="fa fa-linkedin-square"></i></a>
            <a href="#"><i class="fa fa-google-plus-square"></i></a>
          </p>
        </div>

        <div class="sidebar_widget">
          <h5><i class="fa fa-envelope"></i> Sewa Sekarang</h5>

          <form method="get" action="booking.php">
            <input type="hidden" name="vid" value="<?php echo $vhid;?>">

            <?php if($_SESSION['ulogin']) { ?>
            <button class="btn btn-block">Sewa Sekarang</button>
            <?php } else { ?>
            <a href="loginform" class="btn btn-xs uppercase" data-toggle="modal" data-target="#loginform">
              Login Untuk Menyewa
            </a>
            <?php } ?>

          </form>
        </div>
      </aside>
    </div>

    <div class="divider"></div>

</section>

<!-- Footer -->
<?php include('includes/footer.php');?>

<?php include('includes/login.php');?>  
<?php include('includes/registration.php');?>
<?php include('includes/forgotpassword.php');?>

<!-- JS -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>

<script src="assets/js/bootstrap-slider.min.js"></script>
<script src="assets/js/slick.min.js"></script>
<script src="assets/js/owl.carousel.min.js"></script>
<script src="assets/switcher/js/switcher.js"></script>

<script src="assets/js/interface.js"></script>

</body>
</html>