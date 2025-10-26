<div class="simple-container grow-1 justify-between-wide-screen h-padding-16 max-width-1200">
  <div class="simple-container grow-0-1">
    <button 
      class="nav-button stepbro" active 
      data-section="section-index" 
      onclick="toggleSection('section-index', false)"
      >
      <md-ripple></md-ripple>
      <span class="icon-holder" >
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 24" fill="none">
          <path d="M0.421875 1.56524C0.421875 0.700783 1.12266 0 1.98712 0H13.0088C14.2478 0 14.9956 1.37112 14.3248 2.41274L1.97573 21.5876C1.3049 22.6292 2.05273 24.0003 3.29168 24.0003H14.3134C15.1778 24.0003 15.8786 23.2996 15.8786 22.4351V11.4784C15.8786 10.614 15.1778 9.91319 14.3134 9.91319H1.98711C1.12266 9.91319 0.421875 9.21241 0.421875 8.34795V1.56524Z" fill="var(--md-sys-color-on-background)"/>
        </svg>
      </span>
      <span class="simple-container align-center gap-8">
        <span class="only-on-mobile">Inicio</span>
        <span class="hide-on-mobile">mainotes</span>
      </span>
    </button>
  </div>
  <div class="simple-container grow-0-1 gap-8">
    

    <?php
      if(isset($_SESSION['id'])){
        echo "
          <button 
            class='nav-button'
            id='direct-action-header-button'
            onclick='window.location=\"home\"'
            >
            <span class='icon-holder only-on-mobile'>
            <span class='material-symbols-rounded'>arrow_circle_right</span>
            </span>
            <md-ripple></md-ripple>
            <span>Ir a app</span>
          </button>
          <button 
            class='nav-button'
            data-flip-id='animate'
            onclick='toggleWindow(\"#window-settings\")'
            >
            <span class='icon-holder'>
            <span class='material-symbols-rounded'>settings</span>
            </span>
            <md-ripple></md-ripple>
            <span class='only-on-mobile'>Configuración</span>
          </button>
        ";
      } else{
        echo "
          <button 
            class='nav-button'
            data-flip-id='animate' 
            name='button-open-login-window'
            >
            <span class='icon-holder only-on-mobile'>
            <span class='material-symbols-rounded'>login</span>
            </span>
            <md-ripple></md-ripple>
            Iniciar sesión
          </button>
          <button 
            class='nav-button'
            id='direct-action-header-button'
            data-flip-id='animate' 
            name='button-open-signup-window'
            >
            <span class='icon-holder only-on-mobile'>
            <span class='material-symbols-rounded'>person_add</span>
            </span>
            <md-ripple></md-ripple>
            Crear cuenta
          </button>
        ";
      }
    ?>
    
  </div>

  



  
</div>


<script>
  const directActionButton = document.getElementById('direct-action-header-button');
  document.addEventListener("DOMContentLoaded", function(event) {
    const activeSection = document.querySelector("#section-index");
    const header = document.querySelector("nav");

    // Escucha el evento de scroll
    activeSection.addEventListener('scroll', function() {
      // Obtén el valor de scroll
      const scrollValue = activeSection.scrollTop;

      if (scrollValue > 0) {
        directActionButton.setAttribute("directActionOn", "");
        header.setAttribute("nav-compacted", "");
      } else {
        directActionButton.removeAttribute("directActionOn");
        header.removeAttribute("nav-compacted"); 
      }


    });
   

  });
  
</script>

<style>

  


  @media only screen and (min-width: 680px){
    nav{
      
      margin:0 !important;
      margin-top:24px !important;
      position:absolute;
      max-width:1200px;
      height:64px !important;
      display:flex;
      align-items:center;
      border-radius:64px;
      transform-origin: top;
      transition: max-width 0.5s cubic-bezier(.36,.6,0,1), background 0.5s cubic-bezier(.36,.6,0,1), transform 0.3s cubic-bezier(0,0,0.5,1), box-shadow 0.3s cubic-bezier(0,0,0.5,1);
      backdrop-filter: blur(16px);
    }
    [nav-compacted]{
      max-width:800px;
      box-shadow: 0 0 0 1px var(--md-sys-color-surface-container) inset;
      background: rgba(255,255,255,0.8) !important;
    }
    [nav-compacted]:hover{
      transform: scale(1.02);
      box-shadow: 0 0 0 1px var(--md-sys-color-surface-container) inset, 0 0 24px 0 rgba(0,0,0,0.04);
    }
    @media (prefers-color-scheme: dark) {
      [nav-compacted]{
        background: rgba(0,0,0,0.6) !important;
      }
    }
  }
  

</style>


