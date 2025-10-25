
<span class="position-relative simple-container direction-column">

  <button 
    class="nav-button hide-on-mobile first-nav-element" 
    onclick="toggleMenu('menu-app-options')" 
    id="toggler-menu-app-options"
    data-flip-id="animate"
    >
    <md-ripple></md-ripple>
    <span class="icon-holder">
      <?php 
        if(isset($_SESSION["additional_data"])){
            if($_SESSION["additional_data"]["profile_picture"] != ""){
                $picture = $_SESSION["additional_data"]["profile_picture"];
                echo "<span class='simple-container overflow-hidden border-radius-64 header-account-circle'><img class='width-100' src='$picture'></span>";
            }else{
                echo '
                    <span
                      class="header-account-circle" 
                      id="response-header-account-username-first-letter"
                      name="account-first-letter"
                    ></span>
                ';
            }
        }
      ?>
      <md-icon class="filled hidden">cognition</md-icon>
    </span>
    <md-icon class="filled hidden" style="margin-left:auto; opacity:0.24; scale:0.8; position:absolute; right: 16px;">expand_all</md-icon>
    <span>Melon Mind</span>
  </button> 

  <md-menu id="menu-app-options" class="style-modern" style="min-width:216px;" anchor="toggler-menu-app-options">
    <md-menu-item onclick="toggleWindow('#window-settings')" data-flip-id="animate">
      <md-icon slot="start" class="filled" aria-hidden="true">settings</md-icon>
      <div slot="headline" >Configuración</div>
    </md-menu-item>
    <md-menu-item onclick="window.location.href='index'">
      <md-icon slot="start" class="filled" aria-hidden="true">first_page</md-icon>
      <div slot="headline">Página principal</div>
    </md-menu-item>
  </md-menu>
</span>



<button 
  id="nav-button-section-home"
  class="nav-button" active
  data-section="section-home" 
  onclick="toggleSection('section-home')"
  >
  <md-ripple></md-ripple>
  <span class="icon-holder" >
    <span class="material-symbols-rounded">home</span>
  </span>
  <span>Inicio</span>
</button>
<button 
  class="nav-button" 
  data-section="section-patients" 
  onclick="toggleSection('section-patients')"
  >
  <md-ripple></md-ripple>
  <span class="icon-holder" >
    <span class="material-symbols-rounded">groups</span>
  </span>
  <span>Pacientes</span>
</button>





<button 
  class="nav-button label-button nav-action-button top-margin-24 hide-on-mobile"  
  data-section="section-diary"
  >
  <span>Opciones</span>
</button>

<button 
  class="nav-button hide-on-mobile nav-action-button"  
  data-action="open-create-appt-window"
  data-flip-id="animate"
  >
  <md-ripple></md-ripple>
  <span class="icon-holder" >
    <span class="material-symbols-rounded">calendar_add_on</span>
  </span>
  <span>Agendar cita</span>
</button>

<button
  class="nav-button hide-on-mobile nav-action-button"
  onclick="PatientsManager.openCreatePatientWindow()"
  data-flip-id="animate"
  >
  <md-ripple></md-ripple>
  <span class="icon-holder" >
    <span class="material-symbols-rounded">person_add</span>
  </span>
  <span>Nuevo paciente</span>
</button>
<button
  class="nav-button hide-on-mobile nav-action-button"
  onclick="ExpensesManager.openCreateExpenseWindow()"
  data-flip-id="animate"
  >
  <md-ripple></md-ripple>
  <span class="icon-holder" >
    <span class="material-symbols-rounded">shopping_bag</span>
  </span>
  <span>Registrar gasto</span>
</button>








<!-- <div class="simple-container top-margin-24">
  <button
    active
    class="style-2 nav-action-button hide-on-mobile primary-container on-primary-container-text"
    >
    <md-icon class="dynamic filled">rocket_launch</md-icon>
    <span>Continuar con Pro</span>
  </button>
</div> -->


<!-- <button
  class="nav-button hide-on-mobile nav-action-button"
  data-flip-id="animate"
  onclick="toggleSubSection('#sub-section-calendar-day', {animationType: 'from-origin'})"
  >
  <md-ripple></md-ripple>
  <span class="icon-holder">
    <span class="material-symbols-rounded">preview</span>
  </span>
  <span>Test cEvent</span>
</button> -->




<div class="simple-container hide-on-mobile grow-1"></div>
<!-- <button 
  class="nav-button hide-on-mobile nav-action-button"  
  data-section="section-diary"
  onclick="toggleWindow('#window-send-bug')"
  data-flip-id="animate"
  >
  <md-ripple></md-ripple>
  <span class="icon-holder" >
    <span class="material-symbols-rounded">bug_report</span>
  </span>
  <span>Reportar error</span>
</button> -->


<button 
  class="nav-button hide-on-mobile nav-action-button"  
  data-section="section-diary"
  onclick="toggleWindow('#window-send-suggestion')"
  data-flip-id="animate"
  >
  <md-ripple></md-ripple>
  <span class="icon-holder" >
    <span class="material-symbols-rounded">feedback</span>
  </span>
  <span>Dar feedback</span>
</button>