<div class="simple-container grow-1 justify-between-wide-screen h-padding-16 max-width-1200">
  <div class="simple-container grow-0-1">
    <button 
      class="nav-button stepbro" active 
      data-section="section-index" 
      onclick="toggleSection('section-index', '#index-scroll-target')"
      >
      <md-ripple></md-ripple>
      <span class="icon-holder" >
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="16" viewBox="0 0 24 16" fill="none">
          <rect y="0.696289" width="14.6076" height="14.6076" rx="7.30381" fill="var(--md-sys-color-on-background)"/>
          <rect x="16.5786" y="0.696289" width="7.42162" height="14.6076" rx="3.71081" fill="var(--md-sys-color-on-background)"/>
        </svg> 
      </span>
      <span class="simple-container align-center gap-8">
        <span class="only-on-mobile">Inicio</span>
        <span class="hide-on-mobile">codemelon</span>
      </span>
    </button>
  </div>
  <div class="simple-container grow-0-1 gap-8">
    <button 
      class="nav-button"
      data-flip-id="animate"
      onclick="toggleWindow('#window-projects'); return false;"
      >
      <md-ripple></md-ripple>
      <span class="icon-holder" >
        <span class="material-symbols-rounded only-on-mobile">apps</span>
      </span>
      <span>Proyectos</span>
    </button>
    <button 
      class="nav-button"
      id="direct-action-header-button" 
      data-flip-id="animate"
      onclick="toggleWindow('#window-contact'); return false;"
      >
      <md-ripple></md-ripple>
      <span class="icon-holder" >
        <span class="material-symbols-rounded only-on-mobile">mail</span>
      </span>
      <span>Contáctanos</span>
    </button>

    <button 
      class="nav-button"
      data-flip-id="animate"
      onclick="toggleWindow('#window-theme','absolute'); "
      title="Tema"
      >
      <md-ripple></md-ripple>
      <span class="icon-holder" >
        <span class="material-symbols-rounded" style="font-variation-settings:'FILL' 1;">palette</span>
      </span>
      <span class="only-on-mobile">Tema</span>
    </button>

    
  </div>
</div>



<script>
  const directActionButton = document.getElementById('direct-action-header-button');
  document.addEventListener("DOMContentLoaded", function(event) {
    const scrollTarget = document.querySelector("#index-scroll-target");

    // Escucha el evento de scroll
    scrollTarget.addEventListener('scroll', function() {
      // Obtén el valor de scroll
      const scrollValue = scrollTarget.scrollTop;

      if (scrollValue > 520) {
        directActionButton.setAttribute("directActionOn", ""); 
      } else {
        directActionButton.removeAttribute("directActionOn"); 
      }
    });
   

  });
  
</script>




<!-- <button 
  class="nav-button"
  data-section="section-login" 
  onclick="toggleSection('section-login')"
  >
  <md-ripple></md-ripple>
  <span class="icon-holder">
    <span class="material-symbols-rounded">login</span>
  </span>
  <span>Iniciar sesión</span>
</button>

<button 
  class="nav-button"
  data-section="section-signup" 
  onclick="toggleSection('section-signup')"
  >
  <md-ripple></md-ripple>
  <span class="icon-holder">
    <span class="material-symbols-rounded">person_add</span>
  </span>
  <span>Crear cuenta</span>
</button> -->

