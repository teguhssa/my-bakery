<?php
session_start();
// import koneksi untuk ke databse
include_once('config/index.php');
// impoer helper function
include_once('helper/index.php');

// fetching data dari database
$sql = "SELECT * FROM `bakeries` WHERE is_deleted = 0 ORDER BY created_at DESC LIMIT 3 ";
$result = mysqli_query($conn, $sql);

$dataProduct = array();

while ($data = mysqli_fetch_assoc($result)) {
	$dataProduct[] = $data;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<!-- meta tag -->
	<?php include('partials/meta.php') ?>

	<!-- title -->
	<title>My Bakery</title>

	<!-- favicon -->
	<link rel="shortcut icon" type="image/png" href="assets/user/img/favicon.png">
	<!-- google font -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
	<!-- fontawesome -->
	<link rel="stylesheet" href="assets/user/css/all.min.css">
	<!-- bootstrap -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<!-- owl carousel -->
	<link rel="stylesheet" href="assets/user/css/owl.carousel.css">
	<!-- magnific popup -->
	<link rel="stylesheet" href="assets/user/css/magnific-popup.css">
	<!-- animate css -->
	<link rel="stylesheet" href="assets/user/css/animate.css">
	<!-- mean menu css -->
	<link rel="stylesheet" href="assets/user/css/meanmenu.min.css">
	<!-- main style -->
	<link rel="stylesheet" href="assets/user/css/main.css">
	<!-- responsive -->
	<link rel="stylesheet" href="assets/user/css/responsive.css">

</head>

<body>

	<!--PreLoader-->
	<?php include('partials/loader.php') ?>
	<!--PreLoader Ends-->

	<!-- header -->
	<?php include('partials/navbar.php') ?>
	<!-- header end -->

	<!-- hero area -->
	<div class="hero-area hero-bg">
		<div class="container">
			<div class="row">
				<div class="col-lg-9 offset-lg-2 text-center">
					<div class="hero-text">
						<div class="hero-text-tablecell">
							<p class="subtitle"></p>
							<h1>Roti dari Kami</h1>
							<div class="hero-btns">
								<a href="all-bread.php" class="boxed-btn">Koleksi Roti</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end hero area -->

	<!-- features list section -->
	<div class="list-section pt-80 pb-80">
		<div class="container">

		<div class="row">
				<div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
					<div class="list-box d-flex align-items-center">
						<div class="list-icon">
							<i class="fas fa-shipping-fast"></i>
						</div>
						<div class="content">
							<h3>bebas biaya kirim</h3>
							<p>Ketika memesan lebih dari 70 produk</p>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
					<div class="list-box d-flex align-items-center">
						<div class="list-icon">
							<i class="fas fa-phone-volume"></i>
						</div>
						<div class="content">
							<h3>Dukungan 24/7</h3>
							<p>Dapatkan dukungan sepanjang hari</p>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6">
					<div class="list-box d-flex justify-content-start align-items-center">
						<div class="list-icon">
							<i class="fas fa-sync"></i>
						</div>
						<div class="content">
							<h3>Pengembalian dana</h3>
							<p>Dapatkan pengembalian dana dalam 3 hari!</p>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
	<!-- end features list section -->

	<!-- product section -->
	<div class="product-section mt-150 mb-150">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 offset-lg-2 text-center">
					<div class="section-title">
					<h3><span class="orange-text">Produk</span> Kami</h3>
					</div>
				</div>
			</div>

			<div class="row">
				<?php
				foreach ($dataProduct as $data) {
					echo '
					<div class="col-lg-4 col-md-6 text-center">
								<div class="single-product-item">
									<div class="product-image">
										<a href="bread.php?id=' . $data['id'] . '"><img src="assets/upload/' . $data['bakery_img'] . '" alt="product thumbnail"></a>
									</div>
									<div class="' . ($data['stock'] == 0 ? 'out-of-stock' : '') . '"></div>
									<h3>' . $data['bakery_name'] . '</h3>
									<p class="product-price">' . rupiah($data['price']) . '</p>
								</div>
							</div>
					';
				}
				?>
			</div>
		</div>
	</div>
	<!-- end product section -->

	<!-- advertisement section -->
	<div class="abt-section mb-150">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-6 col-md-12">
					<div class="abt-bg">
						<img src="assets/user/img/bg-about.jpg" class="w-fluid" />
					</div>
				</div>
				<div class="col-lg-6 col-md-12">
					<div class="abt-text">
					<h2><span class="orange-text">Roti Saya</span></h2>
						<p>Roti adalah makanan berbahan dasar utama tepung terigu dan air, yang difermentasikan dengan
							ragi, tetapi ada juga yang tidak menggunakan ragi. </p>
						<p>Namun dengan kemajuan teknologi, manusia
							membuat roti diolah dengan berbagai bahan seperti garam, minyak, mentega, ataupun telur
							untuk menambahkan kadar protein di dalamnya sehingga didapat tekstur dan rasa tertentu.</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end advertisement section -->


	<!-- footer -->
	<?php include('partials/footer.php') ?>
	<!-- end footer -->


	<!-- jquery -->
	<script src="assets/user/js/jquery-1.11.3.min.js"></script>
	<!-- bootstrap -->
	<script src="assets/template/js/bootstrap-bundle.min.js"></script>
	<!-- isotope -->
	<script src="assets/user/js/jquery.isotope-3.0.6.min.js"></script>
	<!-- waypoints -->
	<script src="assets/user/js/waypoints.js"></script>
	<!-- magnific popup -->
	<script src="assets/user/js/jquery.magnific-popup.min.js"></script>
	<!-- mean menu -->
	<script src="assets/user/js/jquery.meanmenu.min.js"></script>
	<!-- sticker js -->
	<script src="assets/user/js/sticker.js"></script>
	<!-- main js -->
	<script src="assets/user/js/main.js"></script>


</body>

</html>