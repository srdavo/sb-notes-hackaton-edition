<section id="section-index" class="top-padding-0-16" active>

  <div class="simple-container direction-column gap-8 grow-1 border-radius-24 overflow-auto scrollbar-hidden" id="index-scroll-target">
    <div class="simple-container height-100 position-relative overflow-hidden">
      <div class="simple-container position-absolute width-100 height-100 background-pattern"></div>
      <div class="content-box light-color justify-center align-center height-100 gap-16 container-1" style="padding:48px">
        

        <div class="simple-container" style="gap:-8px">
          <span class="index-letter">c</span>
          <span class="index-letter">o</span>
          <span class="index-letter">d</span>
          <span class="index-letter">e</span>
          <span class="index-letter">m</span>
          <span class="index-letter">e</span>
          <span class="index-letter">l</span>
          <span class="index-letter">o</span>
          <span class="index-letter">n</span>
        </div>
        <script>
          const letters = document.querySelectorAll('.index-letter');
            // Initial animation on page load
            letters.forEach((letter, index) => {
              letter.classList.add("hover-animation");
              letter.style.animationDelay = `${index * 25}ms`;
              letter.addEventListener("animationend", () => {
                letter.classList.remove("hover-animation");
              }, { once: true });
            });

            // Add click event to each letter
            // letters.forEach(letter => {
            //   letter.addEventListener("click", () => {
            //     letters.forEach((l, index) => {
            //       l.classList.remove("hover-animation");
            //       // Force reflow to restart animation
            //       void l.offsetWidth;
            //       l.classList.add("hover-animation");
            //       l.style.animationDelay = `${index * 25}ms`;
            //     });
            //   });
            // });
        </script>
        <style>
          .container-1{
            background: radial-gradient(50% 50% at 50% 50%, transparent 0%, var(--md-sys-color-surface-container-low) 100%) !important;
          }
          .container-2{
            background: radial-gradient(50% 50% at 50% 50%, transparent 0%, var(--md-sys-color-background) 100%) !important;
          }
  
          .background-pattern{
            border-radius:32px;
            background-color: var(--md-sys-color-surface-container-low) !important;
            opacity: 0.6;
            background-image:  linear-gradient(var(--md-sys-color-outline-variant) 1px, transparent 1px), linear-gradient(to right, var(--md-sys-color-outline-variant) 1px, var(--md-sys-color-surface-container-low) 1px) !important;
            background-size: 20px 20px !important;
          }
  
          @keyframes hover-animation {
              0%{
                  filter: blur(6px)
              }
              50%{
                  font-weight:600;
                  transform:scale(1.2);
                  /* color:var(--md-sys-color-primary-container); */
                  /* text-shadow: 0px 0px 128px var(--md-sys-color-primary-container); */
                  margin:0 4px;
              }
          }
          .hover-animation{
              animation: hover-animation 500ms cubic-bezier(.29,.64,0,1.5);
          }
  
          .index-letter{
            font-size: 10vw;
            font-weight: 500;
            color: var(--md-sys-color-on-background);
            line-height: 0.95;
            font-family: 'DM Sans', sans-serif ;
              /* font-family: 'Bricolage Grotesque', sans-serif; */
            transition: 
              font-weight 300ms cubic-bezier(.29,.64,0,1), 
              transform 300ms cubic-bezier(.29,.64,0,1), 
              color 300ms cubic-bezier(.29,.64,0,1), 
              margin 300ms cubic-bezier(.29,.64,0,1)
              /* text-shadow 500ms cubic-bezier(.29,.64,0,1); */
              
              ;
            cursor:default;
            user-select:none;
          }
  
          .index-letter:hover{
            font-weight:1000;
            transform:scale(1.2);
            /* color:var(--md-sys-color-primary-container); */
            /* text-shadow: 0px 0px 128px var(--md-sys-color-primary-container); */
            margin:0 4px;
          }
  
      
          
        </style>
  
        <p class="headline-medium user-select-none text-center" style="color:var(--md-sys-color-on-secondary-container); line-height:0.98">
          Transformamos ideas en software personalizado
        </p>
        <div class="simple-container v-margin">
          <md-filled-button data-flip-id="animate" onclick="toggleWindow('#window-contact')"><md-icon slot="icon">forum</md-icon>Contáctanos</md-filled-button>
        </div>
      </div>
      
    </div>


    <div class="simple-container justify-center user-select-none">
        <div class="simple-container width-100 max-width-1200">
          <div class="simple-container direction-column gap-16 on-background-text top-margin-64 bottom-margin-32 padding-32">
            <span class="display-small dm-sans weight-500">¿Qué somos?</span>
            <p class="headline-small outline-text line-height-1-5 text-wrap-pretty">
              Somos la empresa que <span class="primary-text">convierte tus ideas en herramientas digitales</span> que destacan por su diseño intuitivo, funcionalidad y accesibilidad. Creamos desde aplicaciones para uso personal hasta soluciones personalizadas para empresas, <span class="primary-text">priorizando siempre la calidad y una experiencia de usuario excepcional.</span>
            </p>
          </div>
        </div>
    </div>


    <div class="simple-container justify-center">
      <div class="simple-container width-100 max-width-1200 overflow-hidden position-relative">
        <div class="simple-container grow-1 justify-center padding-64 h-padding-24 container-2 z-index-1">
          <span class="display-large dm-sans on-background-text text-center user-select-none line-height-1">Lo que hacemos</span>
        </div>
        <div class="simple-container position-absolute width-100 height-100 background-pattern"></div>
      </div>
    </div>


    <div class="simple-container grow-1 height-100-0 gap-8 flex-wrap on-background-text">
      <div class="content-box width-auto grow-1 basis-normal direction-column justify-center align-center padding-48-32 light-color">
        <div class="simple-container direction-column width-100 max-width-600 gap-8">
          <md-icon class="pretty-minimal filled">code</md-icon>
          <span class="display-medium dm-sans line-height-1">Software a medida</span>
            <p class="outline-text headline-small text-wrap-pretty">Desarrollamos plataformas modernas, totalmente responsivas y multiplataforma, diseñadas específicamente para cumplir tus objetivos.</p>
          
          <div class="simple-container top-margin-16">
            <md-filled-button data-flip-id="animate" onclick="toggleWindow('#window-contact')"><md-icon slot="icon">forum</md-icon>Solicita un proyecto</md-filled-button>
            <!-- <button class="style-1 primary-container on-primary-container-text">Contáctanos</button> -->
          </div>
        </div>
      </div>

      <div class="content-box width-auto grow-1 basis-normal direction-column justify-center align-center padding-48-32 light-color">
        <div class="simple-container direction-column width-100 max-width-600 gap-8">
          <md-icon class="pretty-minimal filled">web</md-icon>
          <span class="display-medium dm-sans line-height-1">Páginas web</span>
          <p class="outline-text headline-small text-wrap-pretty">
            Diseñamos y desarrollamos sitios web modernos y funcionales, que se adaptan a cualquier dispositivo y cumplen con los estándares de accesibilidad.
          </p>
          
          <div class="simple-container top-margin-16">
          <md-filled-button data-flip-id="animate" onclick="toggleWindow('#window-contact')"><md-icon slot="icon">forum</md-icon>Solicita un proyecto</md-filled-button>
            <!-- <button class="style-1 primary-container on-primary-container-text">Ver proyectos</button> -->
          </div>
        </div>
      </div>

      <div class="content-box width-auto grow-1 basis-normal direction-column justify-center align-center padding-48-32 light-color">
        <div class="simple-container direction-column width-100 max-width-600 gap-8">
          <md-icon class="pretty-minimal filled">apps</md-icon>
          <span class="display-medium dm-sans line-height-1">Nuestros proyectos</span>
            <p class="outline-text headline-small text-wrap-pretty">Explora nuestras soluciones exitosas que demuestran nuestro compromiso con la calidad y la innovación.</p>
          
          <div class="simple-container top-margin-16">
            <md-filled-button data-flip-id="animate" onclick="toggleWindow('#window-projects')"><md-icon slot="icon">apps</md-icon>Ver proyectos</md-filled-button>
            <!-- <button class="style-1 primary-container on-primary-container-text">Ver proyectos</button> -->
          </div>
        </div>
      </div>
    </div>

    <div class="simple-container direction-column top-margin-64 align-center on-background-text">
      <div class="simple-container width-100 max-width-1200 flex-wrap gap-16 padding-24 " style="box-sizing:border-box">
        
        <div class="simple-container grow-1 basis-normal direction-column h-padding-16">
          <div class="simple-container align-center gap-8">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="24" viewBox="0 0 24 16" fill="none">
              <rect y="0.696289" width="14.6076" height="14.6076" rx="7.30381" fill="var(--md-sys-color-on-background)"/>
              <rect x="16.5786" y="0.696289" width="7.42162" height="14.6076" rx="3.71081" fill="var(--md-sys-color-on-background)"/>
            </svg>
            <span class="poppins weight-600 headline-medium">codemelon</span>
          </div>
          <p class="outline-text dm-sans">Tu empresa de desarrollo web de confianza.</p>
          <br>
          <p class="outline-text dm-sans"><md-icon class="dynamic filled">cookie</md-icon> Usamos cookies técnicas para el funcionamiento de la web y cookies de preferencias si aceptas 'Recordarme'. <br> <a href="<?= BASE_URL ?>cookiesdocument" class="on-background-text">Más información</a></p>
        </div>


        <div class="simple-container grow-1 basis-normal direction-column">
          <span class="headline-small poppin weight-600 left-margin-16 top-margin-8">Contacto</span>
          <div class="simple-container">
            <button class="style-4 background on-background-text dm-sans" id="copy-contact-email">
              <md-icon class="filled primary-text">mail</md-icon>
              <span id="copy-contact-email-value">codemelonsoftware@gmail.com</span>
              <md-ripple></md-ripple>
            </button>
          </div>
        </div>

        <div class="simple-container grow-1 basis-normal direction-column bottom-margin-48">
          <span class="headline-small poppin weight-600 left-margin-16 top-margin-8">Acciones</span>

          <div class="simple-container">
            <button class="style-4 background on-background-text dm-sans" onclick="toggleWindow('#window-contact')" data-flip-id="animate">
              <md-icon class="filled primary-text">forum</md-icon>
              <span id="copy-contact-email-value">Contáctanos</span>
              <md-ripple></md-ripple>
            </button>
          </div>
          <div class="simple-container">
            <button class="style-4 background on-background-text dm-sans" onclick="toggleWindow('#window-projects')" data-flip-id="animate">
              <md-icon class="filled primary-text">apps</md-icon>
              <span id="copy-contact-email-value">Proyectos</span>
              <md-ripple></md-ripple>
            </button>
          </div>
          <div class="simple-container">
            <button class="style-4 background on-background-text dm-sans" onclick="window.location=BASE_URL +'privacydocument'" data-flip-id="animate">
              <md-icon class="filled primary-text">policy</md-icon>
              <span id="copy-contact-email-value">Política de privacidad</span>
              <md-ripple></md-ripple>
            </button>
          </div>

          <div class="simple-container">
            <button class="style-4 background on-background-text dm-sans" onclick="toggleWindow('#window-credits')" data-flip-id="animate">
              <md-icon class="filled primary-text">info</md-icon>
              <span id="copy-contact-email-value">Ver créditos</span>
              <md-ripple></md-ripple>
            </button>
          </div>
            
        </div>

      </div>
    </div>

    
    
  </div>
  

    <script type="text/javascript"
        src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js">
    </script>
    <script type="text/javascript">
      (function(){
          emailjs.init({
            publicKey: "4Erxbmtc1uXxNlnr2",
          });
      })();
    </script>  
</section>