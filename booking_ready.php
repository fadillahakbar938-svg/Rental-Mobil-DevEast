<?php
session_start();
error_reporting(0);
include('includes/config.php');
include('includes/format_rupiah.php');
include('includes/library.php');

if(strlen($_SESSION['ulogin']) == 0){
    header('location:index.php');
}else{

if(isset($_POST['submit'])){
    $fromdate=$_POST['fromdate'];
    $todate=$_POST['todate'];
    $durasi=$_POST['durasi'];
    $pickup=$_POST['pickup'];
    $vid=$_POST['vid'];
    $email=$_POST['email'];
    $biayadriver=$_POST['biayadriver'];
    $status = "Menunggu Pembayaran";
    $tgl=date('Y-m-d');

    // INSERT tanpa kode booking dulu
    $sql = "INSERT INTO booking (kode_booking,id_mobil,tgl_mulai,tgl_selesai,durasi,driver,status,email,pickup,tgl_booking)
            VALUES('', '$vid', '$fromdate', '$todate', '$durasi', '$biayadriver', '$status', '$email', '$pickup', '$tgl')";
    $query = mysqli_query($koneksidb,$sql);

    if($query){
        // Ambil id_booking terakhir
        $id = mysqli_insert_id($koneksidb);

        // Generate kode booking berdasarkan id
        $kode = "TRX".str_pad($id, 5, "0", STR_PAD_LEFT);

        // Update ke tabel booking
        mysqli_query($koneksidb, "UPDATE booking SET kode_booking='$kode' WHERE id_booking='$id'");

        // Insert tanggal booking ke cek_booking
        for($cek=0; $cek<$durasi; $cek++){
            $tglmulai = strtotime($fromdate);
            $jmlhari  = 86400*$cek;
            $tglhasil = date("Y-m-d",$tglmulai+$jmlhari);

            mysqli_query($koneksidb,
                "INSERT INTO cek_booking (kode_booking,id_mobil,tgl_booking,status)
                VALUES('$kode','$vid','$tglhasil','$status')");
        }

        echo "<script>alert('Mobil berhasil disewa.');</script>";
        echo "<script type='text/javascript'>document.location = 'riwayatsewa.php?kode=$kode';</script>";

    } else {
        echo "<script>alert('Terjadi kesalahan. Silakan coba lagi.');</script>";
    }
}
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Rental Mobil DevEast</title>
<link rel="stylesheet" href="assets/css/bootstrap.min.css">
<link rel="stylesheet" href="assets/css/style.css">
<link rel="stylesheet" href="assets/css/font-awesome.min.css">
<link rel="shortcut icon" href="assets/images/logo.png">
</head>
<body>

<?php include('includes/colorswitcher.php');?>
<?php include('includes/header.php');?>

<div>
<br/>
<center><h3>Mobil Tersedia untuk disewa.</h3></center>
<hr>
</div>

<?php
$email=$_SESSION['ulogin']; 
$vid=$_GET['vid'];
$mulai=$_GET['mulai'];
$selesai=$_GET['selesai'];
$driver=$_GET['driver'];
$pickup=$_GET['pickup'];

$start = new DateTime($mulai);
$finish = new DateTime($selesai);
$int = $start->diff($finish);
$durasi = $int->days + 1;

$sqldriver = "SELECT * FROM tblpages WHERE id='0'";
$querydriver = mysqli_query($koneksidb,$sqldriver);
$resultdriver = mysqli_fetch_array($querydriver);
$drive=$resultdriver['detail'];

if($driver=="1"){
    $drivercharges = $drive*$durasi;
}else{
    $drivercharges = 0;
}

$sql1 = "SELECT mobil.*,merek.* FROM mobil,merek WHERE merek.id_merek=mobil.id_merek AND mobil.id_mobil='$vid'";
$query1 = mysqli_query($koneksidb,$sql1);
$result = mysqli_fetch_array($query1);

$harga = $result['harga'];
$totalmobil = $durasi*$harga;
$totalsewa = $totalmobil+$drivercharges;
?>

<section class="user_profile inner_pages">
<div class="container">
<div class="col-md-6 col-sm-8">
    <div class="product-listing-img"><img src="admin/img/vehicleimages/<?php echo htmlentities($result['image1']);?>" class="img-responsive"></div>
    <div class="product-listing-content">
        <h5><?php echo htmlentities($result['nama_merek']);?>, <?php echo htmlentities($result['nama_mobil']);?></h5>
        <p class="list-price"><?php echo htmlentities(format_rupiah($result['harga']));?> / Hari</p>
        <ul>
            <li><i class="fa fa-user"></i><?php echo htmlentities($result['seating']);?> Seats</li>
            <li><i class="fa fa-calendar"></i><?php echo htmlentities($result['tahun']);?></li>
            <li><i class="fa fa-car"></i><?php echo htmlentities($result['bb']);?></li>
        </ul>
    </div>
</div>

<div class="user_profile_info">
<div class="col-md-12 col-sm-10">
<form method="post" name="sewa">
<input type="hidden" name="vid" value="<?php echo $vid;?>">
<input type="hidden" name="email" value="<?php echo $email;?>">
<input type="hidden" name="durasi" value="<?php echo $durasi;?>">
<input type="hidden" name="biayadriver" value="<?php echo $drivercharges;?>">
<input type="hidden" name="pickup" value="<?php echo $pickup;?>">

<div class="form-group">
<label>Tanggal Mulai</label>
<input type="date" class="form-control" name="fromdate" value="<?php echo $mulai;?>" readonly>
</div>

<div class="form-group">
<label>Tanggal Selesai</label>
<input type="date" class="form-control" name="todate" value="<?php echo $selesai;?>" readonly>
</div>

<div class="form-group">
<label>Durasi</label>
<input type="text" class="form-control" value="<?php echo $durasi;?> Hari" readonly>
</div>

<div class="form-group">
<label>Metode Pickup</label>
<input type="text" class="form-control" value="<?php echo $pickup;?>" readonly>
</div>

<div class="form-group">
<label>Biaya Mobil</label>
<input type="text" class="form-control" value="<?php echo format_rupiah($totalmobil);?>" readonly>
</div>

<div class="form-group">
<label>Biaya Driver</label>
<input type="text" class="form-control" value="<?php echo format_rupiah($drivercharges);?>" readonly>
</div>

<div class="form-group">
<label>Total Biaya Sewa</label>
<input type="text" class="form-control" value="<?php echo format_rupiah($totalsewa);?>" readonly>
</div>

<br>
<div class="form-group">
<input type="submit" name="submit" value="Sewa" class="btn btn-block">
</div>
</form>
</div>
</div>

</div>
</section>

<?php include('includes/footer.php');?>

</body>
</html>
<?php } ?>
