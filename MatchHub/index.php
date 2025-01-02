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
	<!-- Mobile-menu end -->
	<!-- HEADING-BANNER START -->

	<div class="heading-banner-area overlay-bg" style="background: rgba(0, 0, 0, 0) url(<?php echo site; ?>/uploads/anasayfa.webp) no-repeat scroll center center / cover;">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="heading-banner">
						<div class="heading-banner-title">
							<h2>MatchHub Nedir?</h2>
						</div>
						<div class="breadcumbs pb-15">
							<ul>
								<li><a href="<?php echo site; ?>">Ana Sayfa</a></li>
								<li>MatchHub'ı Tanıyalım</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- HEADING-BANNER END -->
	<!-- PRODUCT-AREA START -->
	<div class="product-area pt-80 pb-80 product-style-2">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="about-us-content" style="font-size: 20px;">
						<h3>Hakkımızda</h3>
						<p>MatchHub, oyuncuların bir araya gelerek oyun arkadaşlığı, sosyal bağlantılar ve profesyonel destek alabilecekleri yenilikçi bir platformdur. Amacımız, oyun topluluklarını bir araya getirerek herkesin daha eğlenceli, rekabetçi ve anlamlı bir oyun deneyimi yaşamasını sağlamaktır.</p>
						<p>Platformumuz, kullanıcıların oyun partnerleriyle iletişim kurmasını, rezervasyon yapmasını ve birbirinden farklı hizmetlerden faydalanmasını kolaylaştırır. Güçlü altyapımız ve şeffaf hizmet anlayışımız ile güvenilir bir deneyim sunmayı hedefliyoruz. MatchHub ile oyun dünyasında yepyeni bir deneyim sizleri bekliyor!</p>
						<p>Bizi tercih ettiğiniz için teşekkür ederiz. Topluluğumuzun bir parçası olarak oyun dünyasını birlikte keşfetmeye hazır olun!</p>
						<br><br>
						<h3>Topluluk Kuralları</h3>
						<ol>
							<li><strong>Saygılı Olun:</strong> Tüm kullanıcılar arasında saygı esas alınmalıdır. Hakaret, küfür, ayrımcılık veya nefret söylemine izin verilmez.</li>
							<li><strong>Doğru Bilgi Sağlayın:</strong> Profil bilgilerinizi doğru doldurun ve yanıltıcı bilgiler paylaşmayın.</li>
							<li><strong>Profesyonel Davranın:</strong> Hizmet sağlarken veya kullanırken profesyonel bir tutum sergileyin. Kötüye kullanım yasaktır.</li>
							<li><strong>Güvenlik Önceliklidir:</strong> Kişisel bilgilerinizi (adres, telefon, ödeme bilgileri) paylaşmayın. Şüpheli durumları yönetime bildirin.</li>
							<li><strong>Taciz Yasaktır:</strong> Taciz, zorbalık veya uygunsuz davranış kabul edilemez.</li>
							<li><strong>Uygunsuz İçerik Paylaşmayın:</strong> Şiddet, pornografi veya yasadışı içeriklerin paylaşımı yasaktır.</li>
							<!-- <li><strong>Ödeme Güvenliği:</strong> Tüm ödemeler platform üzerinden yapılmalıdır. Platform dışı ödeme talepleri yasaktır.</li> -->
							<li><strong>Hesap Güvenliği:</strong> Şifrenizi paylaşmayın ve düzenli olarak değiştirin.</li>
							<li><strong>Platform Amacına Uygun Kullanım:</strong> Platformu amacı dışında kullanmak hesabınızın askıya alınmasına neden olabilir.</li>
						</ol>
						<p>Topluluğumuzun kurallarına uyarak güvenli ve eğlenceli bir deneyim için katkıda bulunun!</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- PRODUCT-AREA END -->
<?php require_once 'inc/footer.php'; ?>
