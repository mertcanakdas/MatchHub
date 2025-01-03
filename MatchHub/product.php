<?php
define('security', true);

require_once 'inc/header.php'; ?>

<!-- WRAPPER START -->
<div class="wrapper bg-dark-white">

	<!-- HEADER-AREA START -->
	<?php require_once 'inc/menu.php'; ?>

	<!-- HEADER-AREA END -->
	<!-- Mobile-menu start -->
	<?php require_once 'inc/mobilemenu.php'; ?>

	<?php

	$sef = get('productsef');
	if (!$sef) {
		go(site);
	}

	$product  = $db->prepare("SELECT * FROM urunler WHERE urundurum=:d AND urunsef=:se");
	$product->execute([':d' => 1, ':se' => $sef]);
	if ($product->rowCount()) {


		$row = $product->fetch(PDO::FETCH_OBJ);

		if (@$bgift > 0) {

			$calc  = $row->urunfiyat * $bgift / 100;
			$price = $row->urunfiyat - $calc;
		} else {
			$price = $row->urunfiyat;
		}
	} else {
		go(site);
	}


	//ürün yorumları
	$comment = $db->prepare("SELECT * FROM urun_yorumlar WHERE yorumurun=:u AND yorumdurum=:d ORDER BY yorumtarih DESC");
	$comment->execute([':u' => $row->urunkodu, ':d' => 1]);



	?>

	<!-- Mobile-menu end -->
	<!-- HEADING-BANNER START -->
	<div class="heading-banner-area overlay-bg" style="background: rgba(0, 0, 0, 0) url(<?php echo site; ?>/uploads/product/<?php echo $row->urunbanner; ?>) no-repeat scroll center center / cover;">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="heading-banner">
						<div class="heading-banner-title">
							<h2><?php echo $row->urunbaslik; ?></h2>
						</div>
						<div class="breadcumbs pb-15">
							<ul>
								<li><a href="<?php echo site; ?>">ANA SAYFA</a></li>
								<li>ÜRÜN</li>
								<li><?php echo $row->urunbaslik; ?></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- HEADING-BANNER END -->
	<!-- PRODUCT-AREA START -->
	<div class="product-area single-pro-area pt-80 pb-80 product-style-2">
		<div class="container">
			<div class="row shop-list single-pro-info no-sidebar">
				<!-- Single-product start -->
				<div class="col-lg-12">
					<div class="single-product clearfix">
						<!-- Single-pro-slider Big-photo start -->
						<div class="single-pro-slider single-big-photo view-lightbox slider-for">


							<?php

							$pimage = $db->prepare("SELECT resimurun,resimdosya,resimdurum,kapak,resimtarih FROM urun_resimler WHERE resimurun=:u  ORDER BY siralama ASC");
							$pimage->execute([':u' => $row->urunkodu]);

							if ($pimage->rowCount()) {
								foreach ($pimage as $pim) {
							?>
									<div class="<?php echo $pim['kapak'] == 1 ? 'slick-slide slick-current slick-active' : null; ?>">
										<img width="370" height="450" src="<?php echo $site . "/uploads/product/" . $pim['resimdosya']; ?>" alt="<?php echo $row->urunbaslik; ?>" />
										<a class="view-full-screen" href="<?php echo $site . "/uploads/product/" . $pim['resimdosya']; ?>" data-lightbox="roadtrip" data-title="<?php echo $row->urunbaslik; ?>">
											<i class="zmdi zmdi-zoom-in"></i>
										</a>
									</div>


							<?php }
							} ?>

						</div>
						<!-- Single-pro-slider Big-photo end -->
						<div class="product-info">

							<div class="fix mb-20">
								<span class="pro-price"><b>Ürün Fiyat :</b> <?php echo $price . " ₺"; ?> | <b>Ürün Kodu:</b> <?php echo $row->urunkodu; ?></span>
							</div>
							<div class="product-description">
								<p><?php echo strip_tags(mb_substr($row->urunicerik, 0, 1000, 'utf8')); ?> | <a href='#description'>Tüm açıklamayı oku</a></p>

							</div>
							<!-- color start -->

							<!-- Size end -->

							<div class="clearfix">

								<?php if ($arow->sitesiparisdurum == 1) { ?>
									<form action="" method="POST" onsubmit="return false;" id="addcartform">

										<input type="number" value="1" name="qty" class="cart-plus-minus-box">

										<div class="product-action clearfix">
											<input type="hidden" value="<?php echo $row->urunkodu; ?>" name="pcode" />


											<button type="submit" onclick="addcart();" id="addcartt" class="btn btn-default"><i class="zmdi zmdi-shopping-cart-plus"></i> Sepete Ekle</button>


										</div>
									</form>
								<?php } else {

									alert("Web sitemiz şuanda sipariş işlemlerine kapalıdır, en kısa sürede aktif edilecektir,", "warning");
								} ?>


							</div>

							<!-- Single-pro-slider Small-photo start -->

							<div class="single-pro-slider single-sml-photo slider-nav">

								<?php
								$pimageslider = $db->prepare("SELECT resimurun,resimdosya,resimdurum,kapak,resimtarih FROM urun_resimler WHERE resimurun=:u ORDER BY resimtarih DESC");
								$pimageslider->execute([':u' => $row->urunkodu]);
								if ($pimageslider->rowCount()) {

									foreach ($pimageslider as $pimg) {
								?>
										<div>
											<img width="70" height="83" src="<?php echo site . "/uploads/product/" . $pimg['resimdosya']; ?>" alt="<?php echo $row->urunbaslik; ?>" />
										</div>
								<?php }
								} ?>
							</div>

							<!-- Single-pro-slider Small-photo end -->
						</div>
					</div>
				</div>
				<!-- Single-product end -->
			</div>
			<!-- single-product-tab start -->
			<div class="single-pro-tab">
				<div class="row">
					<div class="col-md-3">
						<div class="single-pro-tab-menu">
							<!-- Nav tabs -->
							<ul class="nav d-block">
								<li><a class="active" href="#description" data-bs-toggle="tab">Ürün Açıklaması</a></li>
								<li><a href="#reviews" data-bs-toggle="tab">Ürün Yorumları (<?php echo $comment->rowCount(); ?>)</a></li>
								<li><a href="#information" data-bs-toggle="tab">Ürün Özellikler</a></li>
							</ul>
						</div>
					</div>
					<div class="col-md-9">
						<!-- Tab panes -->
						<div class="tab-content">
							<div class="tab-pane active" id="description">
								<div class="pro-tab-info pro-description">
									<h3 class="tab-title title-border mb-30"><?php echo $row->urunbaslik; ?> Açıklaması</h3>

									<?php echo $row->urunicerik; ?>

								</div>
							</div>

							<div class="tab-pane " id="reviews">
								<div class="pro-tab-info pro-reviews">
									<div class="customer-review mb-60">
										<h3 class="tab-title title-border mb-30"><?php echo $row->urunbaslik; ?> Yorumları (<?php echo $comment->rowCount(); ?>)</h3>
										<ul class="product-comments clearfix">

											<?php


											if ($comment->rowCount()) {

												foreach ($comment as $com) {
											?>
													<li class="mb-30" style="border-bottom:2px solid #ddd">

														<div class="pro-reviewer-comment">
															<div class="fix">
																<div class="floatleft mbl-center">
																	<h5 class="text-uppercase mb-0"><strong><?php echo $com["yorumisim"]; ?></strong></h5>
																	<p class="reply-date"><?php echo dt($com["yorumtarih"]); ?></p>
																</div>

															</div>
															<p class="mb-0"><?php echo $com["yorumicerik"]; ?></p>
														</div>
													</li>
											<?php
												}
											} else {
												alert('Bu ürüne yorum yapılmamış, ilk yorum yapan siz olun', 'warning');
											}
											?>

										</ul>
									</div>

									<?php if (@$_SESSION['login'] == @sha1(md5(IP() . $bcode))) { ?>
										<div class="leave-review">
											<h3 class="tab-title title-border mb-30">Yorum Yapın</h3>

											<div class="reply-box">
												<form action="#" id="commentform" onsubmit="return false">
													<div class="row">
														<div class="col-md-12">
															<textarea class="custom-textarea" name="commentcontent" placeholder="Yorumunuz"></textarea>

															<input type="hidden" name="productcode" value="<?php echo $row->urunkodu; ?>" />
															<button type="submit" class="button-one submit-button mt-20" onclick="newcomment();" id="newcommentt">Yorum yapın</button>
														</div>
													</div>
												</form>
											</div>
										</div>
									<?php } else {
										alert("Yorum yapabilmekk için lütfen <a href='" . site . "/login'>giriş yapınız</a>", "danger");
									} ?>

								</div>
							</div>

							<div class="tab-pane" id="information">
								<div class="pro-tab-info pro-information">
									<h3 class="tab-title title-border mb-30"><?php echo $row->urunbaslik; ?> Özellikleri</h3>

									<div class="table-responsive">

										<table class="table table-hover">
											<?php
											$pskill = $db->prepare("SELECT * FROM urun_ozellikler WHERE ozellikurun=:u AND ozellikdurum=:d ORDER BY siralama ASC");

											$pskill->execute([':u' => $row->urunkodu, ':d' => 1]);
											if ($pskill->rowCount()) {
												foreach ($pskill as $prow) {

											?>
													<tr>
														<th><?php echo $prow['ozellikbaslik']; ?>:</th>
														<td><?php echo $prow['ozellikicerik']; ?></td>
													</tr>
											<?php

												}
											} else {
												alert('Ürün özelliği eklenmemiş', 'danger');
											}
											?>


										</table>

									</div>

								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
			<!-- single-product-tab end -->
		</div>
	</div>
	<!-- PRODUCT-AREA END -->
	<!-- FOOTER START -->
	<?php require_once 'inc/footer.php'; ?>