<section 
    id="section-home" 
    class="on-background-text dm-sans-all"
    active 
    >

    <!-- top header -->
    <div class="simple-container justify-between" style="min-height:42px; z-index:2;">

        <div class="simiple-container flex-1">
            <div 
                class="simple-container sb-menu" 
                id="main-app-menu"
                >
                <md-filled-tonal-icon-button 
                    class="solid"
                    data-menu-step-name="origin"
                    data-menu-step-target="menu"
                    data-menu-step-active
                    data-menu-animation-style="elastic"
                    >
                    <md-icon>more_horiz</md-icon>
                </md-filled-tonal-icon-button>
                <div 
                    class="content-box position-absolute width-auto padding-8 gap-0 border-radius-32"
                    data-menu-step-name="menu"
                    
                    >
    
                    <div class="simple-container">
                        <button 
                            class="style-7 transparent for-icon rounded"
                            data-menu-step-target="origin"
                            >
                            <md-ripple></md-ripple>
                            <md-icon>arrow_back</md-icon>
                        </button>
    
                    </div>
    
                    <button 
                        class="style-7 transparent rounded"
                        data-menu-step-target="origin"
                        onclick="toggleSection('section-home')"
                        >
                        <md-ripple></md-ripple>
                        <md-icon>text_fields</md-icon>
                        <span>Editor</span>
                    </button>
    
                    <button 
                        class="style-7 transparent rounded"
                        data-menu-step-target="origin"
                        onclick="toggleSection('section-notes')"
                        >
                        <md-ripple></md-ripple>
                        <md-icon>notes</md-icon>
                        <span class="white-space-no-wrap">Mis notas</span>
                    </button>
                    <button 
                        class="style-7 transparent rounded"
                        data-menu-step-target="origin"
                        onclick="toggleSection('section-dashboard')"
                        >
                        <md-ripple></md-ripple>
                        <md-icon>money_bag</md-icon>
                        <span class="white-space-no-wrap">Mis finanzas</span>
                    </button>
    
                </div>
            </div>
        </div>

        <div class="simple-container flex-1 justify-right position-relative">
            <div 
                class="simple-container position-absolute sb-menu" 
                id="new-note-menu"
                >
                <md-filled-icon-button 
                    class="solid"
                    data-menu-step-name="origin"
                    data-menu-step-target="menu"
                    data-menu-step-active
                    >
                    <md-icon>add</md-icon>
                </md-filled-icon-button>
                <div 
                    class="content-box padding-8 outline-light-1 light-color gap-0 border-radius-32"
                    data-menu-step-name="menu"
                    
                    >
    
           
    
                    <button 
                        class="style-7 transparent rounded"
                        id="button-new-note"
                        data-menu-step-target="origin"
                        >
                        <md-ripple></md-ripple>
                        <md-icon>add</md-icon>
                        <span class="white-space-no-wrap">Nueva nota</span>
                    </button>
    
                   
    
                </div>
            </div>
        </div>



        
    </div>

    <div class="simple-container grow-1 gap-8">
        <div class="position-relative simple-container grow-1">
            <div 
                class="content-box background outline-light-1 grow-1"
                id="editor-container"
                >
            </div>
            <md-icon 
                id="save-status-icon"
                class="position-absolute"
                style="bottom: 16px; right: 16px; opacity: 0.5; z-index: 999;"
                >
                cloud_done
            </md-icon>
        </div>
        <div class="content-box border-radius-32 padding-8 background outline-light-1 width-auto ">
            <div class="content-box grow-1 basis-small">
                <span class="headline-small">Movimientos</span>
            </div>
            <div class="content-box grow-1 basis-small">
                <span class="headline-small">Sentimientos</span>
            </div>
            <div class="content-box grow-1 basis-small">
                <span class="headline-small">Por desarrollar</span>
            </div>
        </div>
    </div>




</section>

