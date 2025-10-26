<?php 
include_once '../../views/partials/__header.php'; 
include_once '../../back-end/config/utilities.php';
?>

<transparent>
  <?php include_once "views/windows.php"; ?>
</transparent>



<main>
  
 
  <holder>
    
    <?php 
      include_once 'views/dialogs/dialogs.php'; 
      include_once 'views/sections.php';
      // exit; 
    ?>  
    
  </holder>
</main>

<script src="js/general-functions.js?v=1"></script>
<script src="js/main.js?v=1" type="module"></script>


<?php 
include_once '../../views/partials/__footer.php'; 
?>