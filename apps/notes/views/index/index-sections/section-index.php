<section 
  id="section-index" 
  active 
  class="landing-page align-center on-background-text" 
  >

  <!-- row 1 -->

  <div class="simple-container direction-column height-100  align-center grow-1 width-100 justify-center">

    <div class="simple-container primary position-absolute" style="padding:64px; filter:blur(100px)">

    </div>
    
    <div class="simple-container direction-column ">
      <div class="simple-container direction-column align-center gap-24">

        <div class="simple-container align-center" style="">
          <div class="content-box padding-24 border-radius-24 hover-scale-small" style="background: linear-gradient(to bottom, var(--md-sys-color-background), var(--md-sys-color-surface-container-highest));">
            <md-icon class="filled pretty-minimal primary-container-text">star_shine</md-icon>
          </div>
        </div>

        <h1 class="main-title margin-0 text-center-on-mobile text-center text-wrap-pretty">stepbro AI</h1>
      </div>
    </div>

    <div class="simple-container top-margin-16 flex-wrap justify-center gap-8 align-center top-margin-24">
      <?php
        if(isset($_SESSION['id'])){
          echo "
            <button 
              class='style-3 dm-sans primary-container on-primary-container-text '
              onclick='window.location=\"home\"'
              >
              <md-ripple></md-ripple>
              Abrir chat
            </button>
          ";
        } else{
          echo "
              <button 
                class='style-3 dm-sans primary-container on-primary-container-text dm-sans weight-500 '
                data-flip-id='animate'
                name='button-open-login-window'
                >
                <md-ripple></md-ripple>
                Abrir chat
              </button>
          ";
        }
      ?>
    </div>

  </div>

  <!-- <div class="simple-container direction-column width-100 max-width-600 align-center height-100 grow-1">
    <div class="simple-container direction-column ">
      <div class="simple-container direction-column align-center gap-24">

        <div class="simple-container align-center" style="">
          <div class="content-box padding-16 border-radius-24 hover-scale-small" style="background: linear-gradient(to bottom, var(--md-sys-color-background), var(--md-sys-color-surface-container-highest));">
            <md-icon class="filled pretty-minimal primary-container-text">star_shine</md-icon>
          </div>
        </div>

        <h1 class="main-title margin-0 text-center-on-mobile text-center text-wrap-pretty">stepbro AI</h1>
      </div>
    </div>
    <div class="simple-container max-width-600 top-margin-16 bottom-margin-16">
      <span class="title-text outline-text text-center">
        ¿Qué quieres?, preguntale a stepbro AI.
      </span>
    </div>
    <div class="simple-container top-margin-16 flex-wrap justify-center gap-8">
      <?php
        if(isset($_SESSION['id'])){
          echo "
            <button 
              class='style-3 primary-container on-primary-container-text hover-shadow'
              onclick='window.location=\"home\"'
              >
              <md-ripple></md-ripple>
              Abrir chat
            </button>
          ";
        } else{
          echo "
              <button 
                class='style-3 primary-container on-primary-container-text dm-sans weight-500 hover-scale-small'
                data-flip-id='animate'
                name='button-open-login-window'
                >
                <md-ripple></md-ripple>
                Abrir chat
              </button>
          ";
        }
      ?>
    </div>
  </div> -->



  <div class="simple-container width-100 max-width-1200 gap-8 direction-column">

  
        
    <div class="simple-container direction-column padding-32">
      <span class="headline-medium dm-sans weight-600">¿Qué es stepbro AI?</span>
      <p class="headline-small dm-sans outline-text r">
        stepbro AI es una inteligencia artificial diseñada para asistirte en la gestión de tus tareas, completamente integrada con stepbro Notes para una experiencia sincronizada y eficiente.
      </p>
    </div>

    <div class="simple-container direction-column padding-32">
      <span class="headline-medium dm-sans weight-600">¿Por qué existe?</span>
      <p class="headline-small dm-sans outline-text r">
      stepbro AI nace de la necesidad de pasar la materia de Agentes inteligentes y Reconocimiento de voz.
      </p>
    </div>

    <!-- <div class="content-box align-center top-margin-24 background-blured-8">
      <span class="display-small dm-sans weight-500">¿Por qué existe?</span>
      <p class="headline-small dm-sans outline-text text-center">
        stepbro AI nace de la necesidad de pasar la materia de Agentes inteligentes y Reconocimiento de voz.
      </p>
    </div> -->




  </div>
  
  

  <div class="simple-container direction-column top-margin-64 width-100 justify-center align-center on-background-text">
      <div class="simple-container width-100 max-width-1200 flex-wrap gap-16 padding-24 " style="box-sizing:border-box">
        
        <div class="simple-container grow-1 basis-normal direction-column h-padding-16">
          <div class="simple-container align-center gap-8">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 16 24" fill="none">
              <path d="M0.421875 1.56524C0.421875 0.700783 1.12266 0 1.98712 0H13.0088C14.2478 0 14.9956 1.37112 14.3248 2.41274L1.97573 21.5876C1.3049 22.6292 2.05273 24.0003 3.29168 24.0003H14.3134C15.1778 24.0003 15.8786 23.2996 15.8786 22.4351V11.4784C15.8786 10.614 15.1778 9.91319 14.3134 9.91319H1.98711C1.12266 9.91319 0.421875 9.21241 0.421875 8.34795V1.56524Z" fill="var(--md-sys-color-on-background)"/>
            </svg>
            <span class="bricolage weight-600 headline-medium">stepbro</span>
          </div>
          <p class="outline-text dm-sans">Tu empresa de desarrollo web de confianza.</p>
        </div>


        <div class="simple-container grow-1 basis-normal direction-column">
          <span class="headline-small poppin weight-600 left-margin-16 top-margin-8">Contacto</span>
          <div class="simple-container direction-column">
            <button class="style-4 background on-background-text dm-sans" onclick="window.location.href='mailto:stepbro.corp@gmail.com'; return false;">
              <md-icon class="filled primary-text">mail</md-icon>
              <span id="copy-contact-email-value">stepbro.corp@gmail.com</span>
              <md-ripple></md-ripple>
            </button>
            <button class="style-4 background on-background-text dm-sans" onclick="window.location.href='mailto:luisdavid.gris@gmail.com'; return false;">
              <md-icon class="filled primary-text">mail</md-icon>
              <span id="copy-contact-email-value">luisdavid.gris@gmail.com</span>
              <md-ripple></md-ripple>
            </button>
          </div>
        </div>

        <div class="simple-container grow-1 basis-normal direction-column bottom-margin-48">
          <span class="headline-small poppin weight-600 left-margin-16 top-margin-8">Acciones</span>

          <div class="simple-container">
            <button class="style-4 background on-background-text dm-sans" onclick="window.location.href='mailto:stepbro.corp@gmail.com'; return false;" data-flip-id="animate">
              <md-icon class="filled primary-text">forum</md-icon>
              <span id="copy-contact-email-value">Contáctanos</span>
              <md-ripple></md-ripple>
            </button>
          </div>



          <?php
            if(!isset($_SESSION['id'])){
              echo '
                <div class="simple-container">
                  <button class="style-4 background on-background-text dm-sans" name="button-open-login-window">
                    <md-icon class="filled primary-text">login</md-icon>
                    <span>Iniciar sesión</span>
                    <md-ripple></md-ripple>
                  </button>  
                </div>
              ';
            }
            ?>
            
        </div>

      </div>
    </div>


    
  

  <style>
    holder{
      border-radius:0;
    }
    section#section-index::-webkit-scrollbar {
      display:block;
      width: 4px;
    }

    section#section-index::-webkit-scrollbar-track {
      background: var(--md-sys-color-background);
    }

    section#section-index::-webkit-scrollbar-thumb {
      background: var(--md-sys-color-outline-variant);
      border-radius: 10px;
    }

    section#section-index::-webkit-scrollbar-thumb:hover {
      background: var(--md-sys-color-outline);
    }

    .row-1{margin-top:120px;}

    .landing-page .title-text{
      font-size:20px;
      font-family: 'DM Sans', sans-serif;
      user-select: none;
      font-weight:400;
    }

    .landing-page .main-title{
      
      font-size:48px !important;
      /* font-family: "Bricolage Grotesque", system-ui !important; */
      /* font-family: 'DM Sans', sans-serif !important; */
      font-family: 'DM Sans', sans-serif !important;
      color:var(--md-sys-color-on-background);
      user-select: none;
      font-weight:500;
      line-height:1;
    } 
    .landing-page .main-image{
      width:100%;
      border-radius:64px;
      background: var(--md-sys-color-surface-container-lowest)
    }
    
    .landing-page .other-title-container{
      left:64px;
      top:64px
      /* left: 50%; */
      /* top: 50%; */
      /* transform: translate(-50%, -50%); */
    }
    .landing-page .other-title{
      font-size:8vw;
      mix-blend-mode: difference;
      color: var(--md-sys-color-background);
    }
    .translucid-background{
      background: rgba(255,255,255,0.8);
      backdrop-filter: blur(16px);
    }

    .transparent-surface{background: rgba(0,0,0,0.08) !important;}
    .transparent-surface-inverted{background: rgba(255,255,255,0.08) !important;}


    @media (prefers-color-scheme: dark) {
      .landing-page .other-title{
        color: var(--md-sys-color-on-background) !important;
      }

      .transparent-surface{background: rgba(255,255,255,0.16) !important;}
      .transparent-surface-inverted{background: rgba(0,0,0,0.08) !important;}

      .translucid-background{
        background: rgba(0,0,0,0.5);
      }
    }

    

    [only-on-mobile]{display:none;}
    [hide-on-mobile]{display:flex;}
    [hide-on-mobile][dark-mode]{display:none;}
    @media only screen and (max-width: 680px){
      [data-element-problematic-title]{font-size:32px;}
      .row-1{margin-top:24px}

      .manual-height-grow{
        min-height:400px;
      }
      .direction-column-on-mobile{
        flex-direction:column;
      }
      .text-center-on-mobile{
        text-align:center;
      }
      .justify-center-on-mobile{
        justify-content:center;
      }
      .landing-page .other-title-container{
        left:0;
        top:0;
      }
      .landing-page .other-title{
        font-size:16vw;
        text-align:center;
      }

      [only-on-mobile]{display:flex;}
      [hide-on-mobile]{display:none;}

      .main-title-parent{
        text-align:center;
        align-items:center;
      }

      .landing-page .main-title{
        font-size:40px !important;
        line-height:1;
      }
    

      .landing-page .main-image{
        border-radius:16px;
      }
    }

    @media only screen and (max-width: 680px) and (prefers-color-scheme: light){
      [only-on-mobile][dark-mode]{display:none ;}
    }
    @media only screen and (min-width: 680px) and (prefers-color-scheme: dark){
      [hide-on-mobile][dark-mode]{display:flex;}
      [hide-on-mobile][light-mode]{display:none;}
    }
    @media only screen and (max-width: 680px) and (prefers-color-scheme: dark){
      [only-on-mobile][light-mode]{display:none;}
    }

  </style>
 
</section>


