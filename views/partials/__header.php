<?php
include_once __DIR__ . '/../../back-end/config/config.php';
include_once __DIR__ . '/../../back-end/config/session.php';

include __DIR__ . '/../../back-end/config/allowed_pages.php';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    
    <script> 
      const BASE_URL = "<?= BASE_URL ?>"
    </script>
    <script src="<?= BASE_URL ?>js/accountMain.js?v=3" type="module"></script>
    <script src="https://accounts.google.com/gsi/client" async></script>
    

    <!-- style and themes -->
    <link rel="stylesheet" href="<?= BASE_URL ?>css/style.css?v=1.45.0">

    <link rel="stylesheet" href="<?= BASE_URL ?>css/theme/theme.css?v=1.7.0">
    <link id="theme-style" rel="stylesheet" href="<?= BASE_URL ?>css/theme/colors/oled.css">
    <script src="<?= BASE_URL ?>js/theme.js"></script>
    
    <!-- Material Web Components -->
    <script src="<?= BASE_URL?>js/bundle.js"></script>
    



    <meta charset="UTF-8">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <!-- <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"> -->

    
    <meta name="csrf-token" content="<?= $_SESSION['csrf_token'] ?>">


    <!-- Manifest -->
    <?php 
      if (strpos($_SERVER['REQUEST_URI'], '/apps/') !== false) {
        $current_url = explode('/', $_SERVER['REQUEST_URI'])[2];
      } else {
        $current_url = '';
      }
      
      switch ($current_url) {
             
        default:
          echo "<title>Codemelon</title>";
          echo "<link rel='shortcut icon' type='image/png' href='https://codemelon.net/assets/icon.png'>";
          break;
      }

    ?>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">

    <!-- fonts / icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">  -->
    <link
        rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"
      
    />
    
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,200..800&family=Urbanist:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    
  </head>
<body>
  

<transparent>
  <?php
    if(isset($_SESSION['id'])){
      include_once $_SERVER['DOCUMENT_ROOT'] . BASE_URL .'views/windows/window-settings.php';
      include_once $_SERVER['DOCUMENT_ROOT'] . BASE_URL .'views/windows/window-send-suggestion.php';

      if($_SESSION['additional_data']['permissions'] == 7){
        include_once $_SERVER['DOCUMENT_ROOT'] . BASE_URL .'views/windows/window-admin-panel.php';
      }
      
    } else{
      // include_once $_SERVER['DOCUMENT_ROOT'] . BASE_URL .'views/windows/window-sb-signup.php';
      // include_once $_SERVER['DOCUMENT_ROOT'] . BASE_URL .'views/windows/window-sb-login.php';
      include_once $_SERVER['DOCUMENT_ROOT'] . BASE_URL .'views/windows/window-signup.php';
      include_once $_SERVER['DOCUMENT_ROOT'] . BASE_URL .'views/windows/window-login.php';
      include_once $_SERVER['DOCUMENT_ROOT'] . BASE_URL .'views/windows/window-forgot-password.php';
    }
  ?>
</transparent>
