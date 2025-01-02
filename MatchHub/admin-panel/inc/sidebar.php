<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
  <div class="app-sidebar__user">
    <div>
      <p class="app-sidebar__user-name">Hoşgeldiniz, <?php echo $aname; ?></p>
    </div>
  </div>
  <ul class="app-menu">
    <li>
      <a class="app-menu__item active" href="<?php echo admin; ?>">
        <i class="app-menu__icon fa fa-dashboard"></i>
        <span class="app-menu__label">Ana Sayfa</span></a>
    </li>

    <li>
      <a class="app-menu__item" href="<?php echo admin; ?>/customers.php">
        <i class="app-menu__icon fa fa-users"></i>
        <span class="app-menu__label">Kullanıcılar</span></a>
    </li>


    <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-list"></i>
        <span class="app-menu__label">Forumlar</span>
        <i class="treeview-indicator fa fa-angle-right"></i></a>
      <ul class="treeview-menu">

        <li>
          <a class="treeview-item" href="<?php echo admin; ?>/categories.php">
            <i class="icon fa fa-circle-o"></i> Forum Listesi
          </a>
        </li>
        <li>
          <a class="treeview-item" href="<?php b2b('newcategory'); ?>">
            <i class="icon fa fa-circle-o"></i> Yeni Forum Ekle
          </a>
        </li>

      </ul>
    </li>

    <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-gift"></i>
        <span class="app-menu__label">Oyunlar</span>
        <i class="treeview-indicator fa fa-angle-right"></i></a>
      <ul class="treeview-menu">

        <li>
          <a class="treeview-item" href="<?php echo admin; ?>/products.php">
            <i class="icon fa fa-circle-o"></i> Oyun Listesi
          </a>
        </li>
        <li>
          <a class="treeview-item" href="<?php b2b('newproduct'); ?>">
            <i class="icon fa fa-circle-o"></i> Yeni Oyun Ekle
          </a>
        </li>

      </ul>
    </li>







    <li>
      <a class="app-menu__item" href="<?php echo admin; ?>/comments.php">
        <i class="app-menu__icon fa fa-comments"></i>
        <span class="app-menu__label">Forum Yorumları</span></a>
    </li>






   

    <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-cogs"></i>
        <span class="app-menu__label">Ayarlar</span>
        <i class="treeview-indicator fa fa-angle-right"></i></a>
      <ul class="treeview-menu">

        <li>
          <a class="treeview-item" href="<?php b2b('general'); ?>">
            <i class="icon fa fa-circle-o"></i> Genel Ayarlar
          </a>
        </li>
        <!-- <li>
          <a class="treeview-item" href="<?php b2b('logo'); ?>">
            <i class="icon fa fa-circle-o"></i> Logo Ayarları
          </a>
        </li> -->

        <li>
          <a class="treeview-item" href="<?php b2b('smtp'); ?>">
            <i class="icon fa fa-circle-o"></i> SMTP Ayarları
          </a>
        </li>

        <!-- <li>
          <a class="treeview-item" href="<?php b2b('contact'); ?>">
            <i class="icon fa fa-circle-o"></i> İletişim Ayarları
          </a>
        </li> -->

      </ul>
    </li>

  </ul>
</aside>