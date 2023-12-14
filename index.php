<?php
// import koneksi untuk ke databse
include_once('config/index.php');
// impoer helper function
include_once('helper/index.php');

// fetching data dari database
$sql = "SELECT * FROM `bakeries` WHERE is_deleted = 0 ORDER BY created_at DESC LIMIT 3 ";
$result = mysqli_query($conn, $sql);

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
							<p class="subtitle">Fresh & Flacky</p>
							<h1>Fresh Bread from oven</h1>
							<div class="hero-btns">
								<a href="shop.html" class="boxed-btn">Bread Collection</a>
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
							<h3>Free Shipping</h3>
							<p>When order over $75</p>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
					<div class="list-box d-flex align-items-center">
						<div class="list-icon">
							<i class="fas fa-phone-volume"></i>
						</div>
						<div class="content">
							<h3>24/7 Support</h3>
							<p>Get support all day</p>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6">
					<div class="list-box d-flex justify-content-start align-items-center">
						<div class="list-icon">
							<i class="fas fa-sync"></i>
						</div>
						<div class="content">
							<h3>Refund</h3>
							<p>Get refund within 3 days!</p>
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
						<h3><span class="orange-text">Our</span> Products</h3>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid, fuga quas itaque eveniet beatae optio.</p>
					</div>
				</div>
			</div>

			<div class="row">
				<?php
				while ($data = mysqli_fetch_assoc($result)) {
					echo '<div class="col-lg-4 col-md-6 text-center">
								<div class="single-product-item">
									<div class="product-image">
										<a href="bread.php?id=' . $data['id'] . '"><img src="assets/upload/' . $data['bakery_img'] . '" alt="product thumbnail"></a>
									</div>
									<h3>' . $data['bakery_name'] . '</h3>
									<p class="product-price">' . rupiah($data['price']) . '</p>
								</div>
							</div>';
				}
				?>
			</div>
		</div>
	</div>
	<!-- end product section -->

	<!-- advertisement section -->
	<div class="abt-section mb-150">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 col-md-12">
					<div class="abt-bg">
						<a href="https://www.youtube.com/watch?v=DBLlFWYcIGQ" class="video-play-btn popup-youtube"><i class="fas fa-play"></i></a>
					</div>
				</div>
				<div class="col-lg-6 col-md-12">
					<div class="abt-text">
						<p class="top-sub">Since Year 1999</p>
						<h2>We are <span class="orange-text">My Bread</span></h2>
						<p>Etiam vulputate ut augue vel sodales. In sollicitudin neque et massa porttitor vestibulum ac vel nisi. Vestibulum placerat eget dolor sit amet posuere. In ut dolor aliquet, aliquet sapien sed, interdum velit. Nam eu molestie lorem.</p>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sapiente facilis illo repellat veritatis minus, et labore minima mollitia qui ducimus.</p>
						<a href="about.html" class="boxed-btn mt-4">know more</a>
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