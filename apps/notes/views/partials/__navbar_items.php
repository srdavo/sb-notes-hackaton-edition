
<span class="position-relative">

  <button 
    class="nav-button hide-on-mobile" 
    onclick="toggleMenu('menu-app-options')" 
    id="toggler-menu-app-options"
    data-flip-id="animate"
    >
    <md-ripple></md-ripple>
    <span class="icon-holder" >
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
                    ></span>
                ';
            }
        }
      ?>
      
    </span>
    <span class="dm-sans weight-500">stepbro <span class="primary-text">AI</span></span>
  </button> 

  <md-menu id="menu-app-options" class="style-modern" style="min-width:264px;" anchor="toggler-menu-app-options">
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
  class="nav-button" active 
  data-section="section-home" 
  onclick="toggleSection('section-home')"
  >
  <md-ripple></md-ripple>
  <span class="icon-holder" >
    <span class="material-symbols-rounded">forum</span>
  </span>
  <span>Chat</span>
</button>






<button 
  class="nav-button label-button quick-action-button top-margin-24 hide-on-mobile"  
  data-section="section-diary"
  >
  <span>Opciones</span>
</button>

<button 
  class="nav-button nav-action-button"  
  onclick="toggleDialog('dialog-new-chat-confirmation')"
  data-flip-id="animate"
  >
  <md-ripple></md-ripple>
  <span class="icon-holder" >
    <span class="material-symbols-rounded">add_comment</span>
  </span>
  <span>Nuevo chat</span>
</button>

<button 
  class="nav-button only-on-mobile" 
  data-flip-id="animate"
  onclick="toggleWindow('#window-settings')"
  >
  <md-ripple></md-ripple>
  <span class="icon-holder" >
    <span class="material-symbols-rounded">settings</span>
  </span>
  <span>Configuración</span>
</button>


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
  <span>Hacer feedback</span>
</button>


