<?php 
include_once '../../views/partials/__header.php'; 
?>
<link rel="manifest" href="back-end/config/site.webmanifest" >

<transparent>
  <?php include_once "views/index/index-windows.php"; ?>
</transparent>

<main class="direction-column align-center">

  <nav class="nav-style-5 variant-1 variant-2 justify-center hide-on-mobile" style="width:calc(100% - 24px); z-index:2;">
    <?php include_once 'views/index/index-__navbar_items.php'; ?>
  </nav>
  
  <holder class="margin-0 width-100">
    <?php include_once 'views/index/index-sections.php'; ?>  
  </holder>
</main>



<?php 
include_once '../../views/partials/__footer.php'; 
?>