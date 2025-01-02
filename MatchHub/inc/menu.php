<?php echo !defined('security') ? die("HACK") : null; ?>

<?php



$cat = $db->prepare("SELECT * FROM urun_kategoriler WHERE katdurum=:d ORDER BY siralama ASC");
$cat->execute([':d' => 1]);

$forums = $db->prepare("SELECT * FROM urun_kategoriler WHERE katdurum=:d ORDER BY siralama ASC");
$forums->execute([':d' => 1]);
?>

<header id="sticky-menu" class="header header-2" >
	<div class="header-area">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-4 offset-md-4 col-7">
					<div class="logo text-md-center">
						<a href="<?php echo site; ?>">
							<h1><?php echo baslik  ?></h1>
						</a>
					</div>
				</div>
				<div class="col-md-4 col-5">
					<div class="mini-cart text-end">
						<ul>
							<li>


							</li>


						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- MAIN-MENU START -->
	<div class="menu-toggle menu-toggle-2 hamburger hamburger--emphatic d-none d-md-block">
		<div class="hamburger-box">
			<div class="hamburger-inner"></div>
		</div>
	</div>
	<div class="main-menu  d-none d-md-block">
		<nav>
			<ul>
				<li><a href="<?php echo site; ?>">ANA SAYFA</a></li>
				
				<li><a href="<?php echo site; ?>">OYUNCULAR</a>
					<div class="sub-menu menu-scroll">
						<ul>
							<h4>Oyunlar (<?php echo $cat->rowCount(); ?>)</h4>

							<?php


							if ($cat->rowCount()) {
								foreach ($cat as $ca) {
									echo '<li><a href="' . $site . '/category/' . $ca['katsef'] . '"><span>' . $ca['katbaslik'] . '</span></a></li>';
								}
							}

							?>
						</ul>
					</div>
				</li>
				<li><a href="<?php echo site; ?>">FORUMLAR</a>
					<div class="sub-menu menu-scroll">
						<ul>
							<h4>Forumlar (<?php echo $forums->rowCount(); ?>)</h4>

							<?php


							if ($forums ->rowCount()) {
								foreach ($forums as $forum) {
									echo '<li><a href="' . $site . '/forums/' . $forum['katsef'] . '"><span>' . $forum['katbaslik'] . '</span></a></li>';
								}
							}

							?>
						</ul>
					</div>
				</li>

				<?php if (!isset($_SESSION['login'])) { ?>

					<li><a href="<?php echo site; ?>/login">GİRİŞ YAP</a></li>
					<li><a href="<?php echo site; ?>/register">KAYIT OL</a></li>



				<?php } else { ?>

					<li><a href="<?php echo site; ?>/profile?process=profile">HESABIM</a></li>
					<li><a onclick="return confirm('Onaylıyor musunuz?');" href="<?php echo site; ?>/log-out">ÇIKIŞ YAP</a></li>
				<?php } ?>


			</ul>
		</nav>
	</div>
	<!-- MAIN-MENU END -->
</header>