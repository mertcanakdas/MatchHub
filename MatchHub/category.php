<?php
define('security', true);

require_once 'inc/header.php';
?>
<!-- WRAPPER START -->
<div class="wrapper bg-dark-white">
    <!-- HEADER-AREA START -->
    <?php require_once 'inc/menu.php'; ?>
    <!-- HEADER-AREA END -->
    <!-- Mobile-menu start -->
    <?php require_once 'inc/mobilemenu.php'; ?>

    <?php
    $catsef = get('catsef');
    if (!$catsef) {
        go(site);
    }

    $catresult = $db->prepare("SELECT id, katbaslik, katsef, katdurum, katresim FROM urun_kategoriler WHERE katsef=:se AND katdurum=:d");
    $catresult->execute([':se' => $catsef, 'd' => 1]);
    if ($catresult->rowCount()) {
        $catrow = $catresult->fetch(PDO::FETCH_OBJ);
    } else {
        go(site);
    }

    $s = @intval(get('s'));
    if (!$s) {
        $s = 1;
    }

    $plist = $db->prepare("SELECT * FROM bayiler WHERE bayidurum=:d AND bayikat=:v");
    $plist->execute([':d' => 1, ':v' => $catrow->id]);
    $total = $plist->rowCount();
    $lim = 9;
    $show = $s * $lim - $lim;
    ?>

    <!-- HEADING-BANNER START -->
    <div class="heading-banner-area overlay-bg"
        style="background: rgba(0, 0, 0, 0) url(<?php echo site; ?>/uploads/<?php echo $catrow->katresim; ?>) no-repeat scroll center center / cover;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading-banner">
                        <div class="heading-banner-title">
                            <h2><?php echo $catrow->katbaslik; ?></h2>
                        </div>
                        <div class="breadcumbs pb-15">
                            <ul>
                                <li><a href="<?php echo site; ?>">Ana Sayfa</a></li>
                                <li><a href="#">Kategori</a></li>
                                <li><?php echo $catrow->katbaslik; ?></li>
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
                <?php require_once 'inc/sidebar.php'; ?>

                <?php
                $plist = $db->prepare("SELECT * FROM bayiler WHERE bayidurum=:d AND bayikat=:v LIMIT :show,:lim");
                $plist->bindValue(':d', (int) 1, PDO::PARAM_INT);
                $plist->bindValue(':v', $catrow->id, PDO::PARAM_INT);
                $plist->bindValue(':show', $show, PDO::PARAM_INT);
                $plist->bindValue(':lim', $lim, PDO::PARAM_INT);
                $plist->execute();

                if ($s > ceil($total / $lim)) {
                    $s = 1;
                }
                ?>

                <div class="col-lg-9 order-1 order-lg-2">
                    <!-- Shop-Content Start -->
                    <div class="shop-content mt-tab-30 mb-30 mb-lg-0">
                        <div class="product-option mb-30 clearfix">
                            <p class="mb-0"><?php echo $catrow->katbaslik; ?> Kullanıcı Listesi (<?php echo $total; ?>)</p>
                        </div>

                        <div class="tab-content">
                            <div class="tab-pane active" id="grid-view">
                                <div class="row">
                                    <?php if ($plist->rowCount()) {
                                        foreach ($plist as $row) { ?>
                                            <div class="col-lg-4 col-md-6">
                                                <div class="single-product">
                                                    <div class="product-img">
                                                        <a href="<?php echo site . "/customer/" . $row['bayilogo']; ?>">
                                                            <img width="270" height="270"
                                                                src="<?php echo site . "/uploads/customer/" . $row['bayilogo']; ?>"
                                                                alt="<?php echo $row['bayiadi']; ?>" />
                                                        </a>
                                                    </div>
                                                    <div class="product-info clearfix text-center">
                                                        <div class="fix">
                                                            <h4 class="post-title"><a
                                                                    href="<?php echo site . "/product/" . $row['bayilogo']; ?>"><?php echo $row['bayiadi']; ?></a>
                                                            </h4>
                                                        </div>
                                                        <div class="product-action">
														<a href="<?php echo site . "/chats/" . $row['id']; ?>" title="Mesajlaş"><i class="zmdi zmdi-arrow-right">Mesajlaş</i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php }
                                    } else {
                                        echo '<div class="alert alert-danger">Kullanıcı bulunamadı.</div>';
                                    } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Shop-Content End -->
                </div>
            </div>
        </div>
    </div>

    <!-- Chat Modal -->

    <!-- PRODUCT-AREA END -->
</div>

<?php require_once 'inc/footer.php'; ?>
