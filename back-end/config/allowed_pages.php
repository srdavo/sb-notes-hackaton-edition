<?php
// this function will verify if an unlogged user is trying to access a page that requires login
function validatePage(){
    if (!isset($_SESSION["id"])) {

        $currentPage = basename($_SERVER['PHP_SELF']);
        $allowedPages = [
            'index.php', 
            'login.php', 
        ];

        if (!in_array($currentPage, $allowedPages)) {

            if(isset($_COOKIE["codemelon-remember_me"])){
                header ("location: login");
                exit();
            }

            if(!isset($_SESSION["id"])){
                header ("location: index?redirect");        
                exit();
            }
            
        }

    }else{
        // session activa sí
        $currentPage = basename($_SERVER['PHP_SELF']);
        if($currentPage == 'login.php'){
            header ("location: home");
            exit();
        }
  
    }
}
validatePage();

?>
