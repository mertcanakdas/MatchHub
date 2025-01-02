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
    $comment = $db->prepare("SELECT * FROM urun_yorumlar WHERE yorumurun=:u AND yorumdurum=:d ORDER BY yorumtarih ASC");
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

                </div>
                <!-- Single-product end -->
            </div>
            <!-- single-product-tab start -->
            <div class="single-pro-tab">
                <div class="row">

                    <div class="single-product clearfix">
                        <!-- Tab panes -->



                        <div class="tab-pane " id="reviews">
                            <div class="pro-tab-info pro-reviews">
                                <div class="customer-review mb-60">
                                    <h3 class="tab-title title-border mb-30"><?php echo $row->urunbaslik; ?> Forumu (<?php echo $comment->rowCount(); ?>)</h3>
                                    <ul class="product-comments clearfix">

                                        <?php


                                        if ($comment->rowCount()) {

                                            foreach ($comment as $com) {
                                            ?>
                                                <div class="mb-30" style="border-bottom:2px solid #ddd">
                                                    <div class="pro-reviewer-comment">
                                                        <div class="fix">
                                                            <div class="floatleft mbl-center">
                                                                <h5 class="text-uppercase mb-0"><strong><?php echo $com["yorumisim"]; ?></strong></h5>
                                                                <p class="reply-date"><?php echo dt($com["yorumtarih"]); ?></p>
                                                            </div>
                                                        </div>
                                                        <p class="mb-0"><?php echo $com["yorumicerik"]; ?></p>
                                                    </div>
                                            </div>

                                                    

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




                    </div>
                </div>
            </div>
            <!-- single-product-tab end -->
        </div>
    </div>
    <!-- PRODUCT-AREA END -->
    <!-- FOOTER START -->

    <?php require_once 'inc/footer.php'; ?>