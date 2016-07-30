<aside class="main-sidebar">
  <section class="sidebar">
    <div class="user-panel">
      <div class="pull-left image">
        <img src="<?php echo $url_rewrite;?>static/dist/img/" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p><?php echo $_SESSION['username'];?></p>
        <!-- <small>Administrator Web</small> -->
      </div>
    </div>
    <ul class="sidebar-menu">
      <li class="header">MENU NAVIGATION</li>
        <li class="active"><a href="<?php echo $url_rewrite;?>content/"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
        <?php if($_SESSION["level"]==1){?><li><a href="<?php echo $url_rewrite;?>content/panitia"><i class="fa fa-table"></i> <span>Daftar Panitia</span></a></li>
        <li><a href="<?php echo $url_rewrite;?>content/acara"><i class="fa fa-table"></i> <span>Event / Kegiatan</span></a></li> 
        <?php } ?>
        <li><a href="<?php echo $url_rewrite;?>content/penerimaan"><i class="fa fa-file-text"></i> <span>Penerimaan Dana</span></a></li>
        <li><a href="<?php echo $url_rewrite;?>content/pengeluaran"><i class="fa fa-file-text"></i> <span>Pengeluaran Dana Dana</span></a></li>
        <li><a href="<?php echo $url_rewrite;?>content/report"><i class="fa fa-group"></i> <span>Cetak Berkas</span></a></li>
        <?php if($_SESSION["level"]==0){?><li><a href="<?php echo $url_rewrite;?>content/user"><i class="fa fa-group"></i> <span>Management User</span></a></li> <?php } ?>
    </ul>
  </section>
</aside>
