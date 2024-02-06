<?php
$total_cart = 0;
$dataInfoOrder = array();
if (isset($_SESSION['user_id'])) {
	// total cart
	$user_id = $_SESSION['user_id'];
	$query = "SELECT COUNT(*) AS total_cart FROM carts WHERE user_id = $user_id AND is_complete = 0 AND is_deleted = 0";
	$result = mysqli_query($conn, $query);
	$total_cart = mysqli_fetch_assoc($result);

	// notification order info
	$qInfoOrder = "SELECT o.no_order, o.status_order
	FROM orders o
	LEFT JOIN reviews r ON o.id = r.order_id
	WHERE r.order_id IS NULL AND o.user_id = '$user_id'
	ORDER BY o.created_at DESC
	";
	// $dataInfoOrder = array();
	$infoOrderResult = mysqli_query($conn, $qInfoOrder);
	while ($r = mysqli_fetch_assoc($infoOrderResult)) {
		$dataInfoOrder[] = $r;
	}

}
?>

<div class="top-header-area" id="sticker">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-sm-12 text-center">
				<div class="main-menu-wrap">
					<!-- logo -->
					<div class="site-logo">
						<a href="./index.php">
							<h4 class="text-white">My Bakery</h4>
						</a>
					</div>
					<!-- logo -->

					<!-- menu start -->
					<nav class="main-menu">
						<ul>
							<li><a href="./index.php">Home</a></li>
							<li><a href="all-bread.php">Bread's</a></li>
							<li>
								<div class="header-icons">
									<a class="shopping-cart" href="profile.php"><i class="fas fa-user"></i></a>
									<a class="shopping-cart position-relative" href="cart.php">
										<i class="fas fa-shopping-cart"></i>
										<?php
										if ($total_cart !== 0) {
											echo "<div class='item-cart'>" . $total_cart['total_cart'] . "</div>";
										}
										?>

									</a>
									<a class="shopping-cart position-relative" id="notif-info" href="javascript:void(0)">
										<i class="fas fa-bell"></i>
										<?php
										if (isset($_SESSION['user_id']) && !empty($dataInfoOrder)) {
											echo '<div class="dot-notif"></div>
											<div class="notif-info">';
											foreach ($dataInfoOrder as $dataInfo) {
												echo '<div class="shadow-sm p-3 mb-2">
														<p class="mb-0 "><i class="fas fa-shopping-cart"></i> Your order <span class="fw-bold">' . $dataInfo['no_order'] . '</span></p>
														<p class="mb-0 ">Is, <span class="fw-bold ">' . $dataInfo['status_order'] . '</span></p>';
														if ($dataInfo['status_order'] === "done") {
															echo '<span class="link-review">Give your review!</span>';
														}
													echo '</div>';
											}
											echo '</div>';
										}
										?>
									</a>
								</div>
							</li>
						</ul>
					</nav>
					<div class="mobile-menu"></div>
					<!-- menu end -->
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	const link_review = document.querySelector('.link-review')
	if (link_review !== null) {
		link_review.addEventListener("click", () => {
			window.location.href = "profile.php"
		})
	}
</script>