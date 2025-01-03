<?php require_once 'inc/header.php';?>
    <!-- Sidebar menu-->
    <?php require_once 'inc/sidebar.php';?>
    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-th-list"></i> Forum Listesi</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo admin;?>"><i class="fa fa-home fa-lg"></i></a></li>
          <li class="breadcrumb-item active"><a href="#">Forum Listesi</a></li>
        </ul>
      </div>
      <div class="row">

      <form action="<?php echo admin."/categorysearch.php"; ?>" method="GET" class="col-md-12">
          <div class="form-group">
            <input type="text" name='q' class="form-control" placeholder="Forum adı giriniz" />
          </div>
        </form>

        <form action="" method="GET" class="col-md-2">
          <div class="form-group">
            <input type="text" name="blim" class="form-control" placeholder="Listeleme sayısı" />
          </div>
        </form>
      
        <div class="col-md-12">

          <?php   

            $s     = @intval(get('s'));
            if(!$s){
              $s   = 1;
            }

            $blim   = @intval(get('blim'));
            if(!$blim){
              $blim = 50;
            }

            $query = $db->prepare("SELECT * FROM urun_kategoriler ORDER BY id DESC");
            $query->execute();

            $total = $query->rowCount();
            $lim   = $blim;
            $show  = $s * $lim - $lim;

            $query = $db->prepare("SELECT * FROM urun_kategoriler ORDER BY id DESC LIMIT :show,:lim");
            $query->bindValue(':show',(int) $show,PDO::PARAM_INT);
            $query->bindValue(':lim',(int) $lim,PDO::PARAM_INT);
            $query->execute();

            if($s > ceil($total / $lim)){
              $s = 1;
            }

            if($query->rowCount()){
          ?>


          <div class="tile">
            <h3 class="tile-title">Kategori Listesi (<?php echo $total;?>)</h3>
            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>#ID</th>
                    <th>#Resim</th>
                    <th>Başlık</th>
                    <th>Durum</th>
                    <th>Sıralama</th>
                    <th>İşlem</th>
                  </tr>
                </thead>
                <tbody id="page_list">

                  <?php foreach($query as $row){ ?>
                    
                    <tr id="<?php echo $row['id'];?>"> 
                    <td><?php echo $row['id'];?></td>
                    <td><img src="<?php echo $site."/uploads/".$row['katresim'];?>" width="100" height="100" /></td>
                    <td><?php echo $row['katbaslik'];?></td>
                    <td><?php echo $row['katdurum'] == 1 ? '<span class="badge badge-success ">Aktif</span>' : '<span class="badge badge-danger">Pasif</span>';?>
                  

                    <?php echo $row['silinmeyen_kat'] == 1 ? '<span class="badge badge-danger ">Silinmez kategori</span>' : null;?>
                    
                  </td>
                  <td><?php echo $row['siralama'];?></td>

                 
                    <td>
                      <a title="Düzenle" href="<?php b2b('categoryedit',$row['id']); ?>"><i class="fa fa-edit"></i></a> | 
                      <a onclick="return confirm('Bu kategorideki tüm ürünler, silinmez olarak seçilen kategoriye aktarılacaktır onaylıyor musunuz?');" title="Sil" href="<?php b2b('categorydelete',$row['id']);?>"><i class="fa fa-close"></i></a>
                    </td>
                  </tr>

                  <?php } ?>

                </tbody>
              </table>
            </div>
          </div>

          <?php }else{

            alert("Kategori bulunmuyor","danger");

           } ?>


          <div>
            <ul class="pagination">
              <?php 
                if($total > $lim){
                  if($blim){
                    pagination($s, ceil($total/$lim),'categories.php?blim='.$blim.'&s=');
                  }else{
                    pagination($s, ceil($total/$lim),'categories.php?s=');

                  }
                }
              ?>	
            </ul>
          </div>

        </div>

      


      </div>
    </main>
    <?php require_once 'inc/footer.php';?>
    <script>
      $(document).ready(function(){
        $("#page_list").sortable({
          placeholder : 'ui-state-higlight',
          update      : function(event, ui){

            var page_id_array = new Array();
            $("#page_list tr").each(function(){
              page_id_array.push($(this).attr('id'));
            });

            $.ajax({
               url     : "<?php echo admin;?>/orderby.php?table=urun_kategoriler",
               method  : "POST",
               data    : {page_id_array:page_id_array},
               success : function(data){
                 alert("Sıralama güncellendi");
                 window.location.reload();
               }
            })


          }
        });
      });
    </script>