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
                // usar ruta absoluta para evitar redirecciones relativas en subdirectorios
                header ("Location: /login.php");
                exit();
            }

            // if(!isset($_COOKIE["codemelon-remember_me"]) || !isset($_SESSION["id"])){
            //     // echo "Current Page: ".$_SERVER['REQUEST_URI'];
            //     header ("location: index?redirect");        
            //     exit();
            // }
            if(!isset($_SESSION["id"])){
                // usar ruta absoluta para evitar redirecciones relativas en subdirectorios
                // y apuntar al archivo real index.php
                header ("Location: /index.php?redirect");        
                exit();
            }
            
        }

    }else{
        // session activa sí
        $currentPage = basename($_SERVER['PHP_SELF']);
        if($currentPage == 'login.php'){
            // redirigir a la página principal usando ruta absoluta
            header ("Location: /home.php");
            exit();
        }

        // $allowedPages = ['index.php', 'consent.php'];
        // if (in_array($currentPage, $allowedPages)) {
        //     header ("location: home");
        //     exit();
        // }  
    }
}
validatePage();

?>
