<?php echo !defined('security') ? die("HACK") : null;

$cat = $db->prepare("SELECT * FROM urun_kategoriler WHERE katdurum=:d ORDER BY siralama ASC");
$cat->execute([':d' => 1]);
?>
<div class="col-lg-3 order-2 order-lg-1">
	<!-- Widget-Search start -->
	<form action="<?php echo site; ?>/search.php" method="GET">

		<!-- <aside class="widget widget-search mb-30">

			<input type="text" name="q" placeholder="Ürün arama.." />
			<button type="submit">
				<i class="zmdi zmdi-search"></i>
			</button>

		</aside> -->
		<!-- Widget-search end -->
		<!-- Widget-Categories start -->
		<aside class="widget widget-categories  mb-30">
			<div class="widget-title">
				<h4>KATEGORİLER (<?php echo $cat->rowCount(); ?>)</h4>
			</div>
			<div id="cat-treeview" class="widget-info product-cat boxscrol2">
				<ul>
					<?php


					if ($cat->rowCount()) {
						foreach ($cat as $ca) {
							echo '<li><a href="' . $site . '/category/' . $ca['katsef'] . '"><span><input type="radio" name="kat" value="' . $ca['id'] . '" />' . $ca['katbaslik'] . '</span></a></li>';
						}
					}

					?>
				</ul>
			</div>
		</aside>
		<!-- Widget-categories end -->
		<!-- Shop-Filter start -->


	</form>
	<!-- Shop-Filter end -->
	<!-- Widget-Color start -->

	<!-- Widget-banner end -->
</div>