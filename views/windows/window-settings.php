<window 
    id="window-settings"
    class="increased semi-slim on-background-text"
    
    data-flip-id="animate"
    >
    <div class="simple-container padding-16 only-on-mobile b-padding-0">
        <md-icon-button onclick="toggleWindow()"><md-icon>close</md-icon></md-icon-button>
    </div>
    
    <holder class="padding-0 overflow-hidden direction-row w-section-holder" style="background:var(--md-sys-color-surface-container-low)">
        <!-- nav -->
        <div class="simple-container direction-column w-nav-parent flex-wrap" style="z-index:1">
            <!-- <span class="body-large bottom-margin-8 on-surface-variant-text">Configuración</span> -->
            <md-icon-button class="bottom-margin-16 hide-on-mobile" onclick="toggleWindow()"><md-icon>close</md-icon></md-icon-button>
            <button 
                class="w-nav-button"
                data-w-section="w-section-account"
                onclick="toggleWSection('w-section-account', this)"
                active
                >
                <md-ripple></md-ripple>
                <md-icon>account_circle</md-icon>
                <span>Cuenta</span>
            </button>
            <button 
                class="w-nav-button"
                data-w-section="w-section-appearance"
                onclick="toggleWSection('w-section-appearance', this)"
                >
                <md-ripple></md-ripple>
                <md-icon>palette</md-icon>
                <span>Apariencia</span>
            </button>
            <button 
                class="w-nav-button"
                data-w-section="w-section-information"
                onclick="toggleWSection('w-section-information', this)"
                >
                <md-ripple></md-ripple>
                <md-icon>info</md-icon>
                <span>Información</span>
            </button>
            <!-- <span class="label-medium hide-on-mobile dm-sans outline-text top-margin-16 bottom-margin-8 left-margin-16">Melon Mind</span> -->
            

            <span class="label-medium hide-on-mobile dm-sans outline-text top-margin-16 bottom-margin-8 left-margin-16">Melon Mind</span>

            <button 
                class="w-nav-button"
                id="button-open-appts-settings"
                data-w-section="settings-w-section-appts-settings"
                onclick="toggleWSection('settings-w-section-appts-settings', this)"
                >
                <md-ripple></md-ripple>
                <md-icon>schedule</md-icon>
                <span>Citas</span>
            </button>

            <button 
                class="w-nav-button"
                id="button-open-request-billing-system"
                data-w-section="settings-w-section-request-billing"
                onclick="toggleWSection('settings-w-section-request-billing', this)"
                >
                <md-ripple></md-ripple>
                <md-icon>euro</md-icon>
                <span>Facturación</span>
            </button>
            <button 
                class="w-nav-button"
                data-w-section="settings-w-section-billing"
                onclick="toggleWSection('settings-w-section-billing', this)"
                name='button-open-billing-data'
                data-feature="billing"
                >
                <md-ripple></md-ripple>
                <md-icon>euro</md-icon>
                <span>Facturación</span>
            </button>
        </div>

        <!-- Accout -->
        <div class="w-section padding-24 overflow-auto simple-container direction-column grow-1 gap-8" active id="w-section-account">
            <div class="simple-container direction-row justify-center">
                <?php 
                    if(isset($_SESSION["additional_data"])){
                        if($_SESSION["additional_data"]["profile_picture"] != ""){
                            $picture = $_SESSION["additional_data"]["profile_picture"];
                            echo "<span class='simple-container overflow-hidden border-radius-64'><img class='width-100' src='$picture'></span>";
                        }else{
                            echo '
                                <div class="simple-container padding-40 border-radius-64 surface-variant relative user-select-none">
                                    <span id="response-settings-account-username-first-letter" name="account-first-letter" class="display-large absolute-centered bricolage weight-600">...</span>
                                </div>
                            ';
                        }
                    }
                ?>
                
            </div>
            <div class="simple-container justify-center">
                <span id="response-settings-account-username-title" name="account-username" class="body-large dm-sans weight-500">...</span>
            </div>
            <div class="simple-container direction-column v-margin gap-8 grow-1">
                
                <div class="content-box direction-row light-color padding-24 border-radius-16 justify-between">
                    <div class="simple-container"><span class="label-large">Correo</span></div>
                    <div class="simple-container"><span id="response-settings-account-email" name="account-email" class="body-large">...</span></div>
                </div>
                <div class="content-box direction-column light-color padding-24 border-radius-16 justify-between">
                    <div class="simple-container justify-between">
                        <div class="simple-container"><span class="label-large">Nombre de usuario</span></div>
                        <div class="simple-container"><span id="response-settings-account-username" name="account-username" class="body-large">...</span></div>
                    </div>
                    <div class="simple-container justify-right">
                        <span 
                            class="label-small data-line interactive"
                            onclick="toggleDialog('dialog-account')"    
                            >
                            <md-ripple aria-hidden="true"></md-ripple>
                            Editar
                        </span>
                    </div>
                </div>
                <!-- <div
                    class="content-box outline-with-shadow padding-16 border-radius-16 align-center user-select-none cursor-pointer primary-text"
                    >
                    <md-ripple></md-ripple>
                    <span class="simple-container align-center gap-8"><md-icon class="filled">rocket_launch</md-icon>Mi suscripción</span>
                </div> -->
                <!-- <div
                    data-flip-id="animate"
                    name="button-open-subscription-sub-section"
                    style="box-shadow: 0 16px 24px -6px rgba(255, 255, 255, 0.3) inset;"
                    class="content-box primary-container on-primary-container-text outline-with-shadow padding-16 border-radius-16 align-center user-select-none cursor-pointer "
                    >
                    <md-ripple></md-ripple>
                    <span class="simple-container align-center gap-8 dm-sans weight-600"><md-icon class="filled">rocket_launch</md-icon>Mi suscripción</span>
                </div> -->
                <div
                    data-flip-id="animate"
                    name="button-open-subscription-sub-section"
                    class="content-box padding-16 border-radius-16 align-center user-select-none cursor-pointer hover-outline"
                    >
                    <md-ripple></md-ripple>
                    <span class="simple-container align-center gap-8 inter">Administrar suscripción</span>
                </div>
                <!-- <div class="simple-container grow-1"></div> -->
                <?php 
                    if(isset($_SESSION["additional_data"])){
                        if($_SESSION['additional_data']['permissions'] == 7){
                            echo '
                                <div
                                    data-flip-id="animate"
                                    id="open-admin-panel-button"
                                    class="content-box padding-16 border-radius-16 align-center user-select-none cursor-pointer hover-outline"
                                    >
                                    <md-ripple></md-ripple>
                                    <div class="simple-container gap-8 align-center">
                                        <md-icon class="dynamic">admin_panel_settings</md-icon>
                                        <span class="simple-container align-center gap-8 inter">Panel de admin</span>
                                    </div>
                                </div>
                            
                            ';
                        }
                    }
                ?>
                <div 
                    class="content-box direction-row light-color padding-16 border-radius-16 justify-center user-select-none cursor-pointer"
                    onclick="toggleDialog('dialog-logout-confirmation')"
                    >
                    <md-ripple></md-ripple>
                    <span class="body-medium error-text inter">Cerrar sesión</span>
                </div>

                <?php 
                    // if(isset($_SESSION["additional_data"])){
                    //     if($_SESSION['additional_data']['permissions'] == 7){
                    //         echo '
                    //             <div class="content-box background outline-light-1 overflow-auto">
                    //                 <span class="body-large weight-500 outline-text">Depuración de sesión (solo admins)</span>
                    //                 <span class="label-small outline-text">
                    //                     '.print_r($_SESSION, true).'
                    //                 </span>
                    //             </div>
                    //         ';
                    //     }
                    // }
                ?>

            </div>
        </div>

        <!-- Appearance -->
        <div class="w-section padding-24 overflow-auto simple-container direction-column grow-1" id="w-section-appearance">
            <div class="simple-container direction-column grow-1 gap-16">
                <div class="simple-container gpa-8 direction-column">
                    <span class="headline-medium dm-sans weight-500">Apariencia</span>
                    <span class="body-large outline-text dm-sans">Modifica la apariencia de la app a un color de tu preferencia</span>
                </div>
                <div class="theme-selector-parent v-margin" id="app-theme-selector-parent">
                    <div 
                        class="ball" 
                        data-theme="black"
                        onclick="changeTheme(this)" 
                        >
                        <span style="background:#000000;"></span>
                        <span style="background:#122644;"></span>
                        <span style="background:#b4c7ed;"></span>
                        <md-ripple></md-ripple>
                    </div>
                    <div 
                        class="ball" 
                        data-theme="blue"
                        onclick="changeTheme(this)"
                        >
                        <span style="background:#0045b2;"></span>
                        <span style="background:#0066ff;"></span>
                        <span style="background:#b3c5ff;"></span>
                        <md-ripple></md-ripple>
                    </div>
                    <div 
                        class="ball" 
                        data-theme="green"
                        onclick="changeTheme(this)"
                        >
                        <span style="background:#006d34;"></span>
                        <span style="background:#5de989;"></span>
                        <span style="background:#9fffb3;"></span>
                        <md-ripple></md-ripple>
                    </div>
                    <div 
                        class="ball" 
                        data-theme="brown"
                        onclick="changeTheme(this)"
                        >
                        <span style="background:#944b00;"></span>
                        <span style="background:#ff9947;"></span>
                        <span style="background:#ffbc8d;"></span>
                        <md-ripple></md-ripple>
                    </div>
                    <div 
                        class="ball" 
                        data-theme="cold-blue"
                        onclick="changeTheme(this)"
                        >
                        <span style="background:#006590;"></span>
                        <span style="background:#55c0ff;"></span>
                        <span style="background:#96d3ff;"></span>
                        <md-ripple></md-ripple>
                    </div>
                    <div 
                        class="ball" 
                        data-theme="pink"
                        onclick="changeTheme(this)"
                        >
                        <span style="background:#8900a3;"></span>
                        <span style="background:#c400e8;"></span>
                        <span style="background:#f7acff;"></span>
                        <md-ripple></md-ripple>
                    </div>
                    <div 
                        class="ball" 
                        data-theme="purple"
                        onclick="changeTheme(this)"
                        >
                        <span style="background:#5e00d0;"></span>
                        <span style="background:#853fff;"></span>
                        <span style="background:#d2bcff;"></span>
                        <md-ripple></md-ripple>
                    </div>
                    <div 
                        class="ball" 
                        data-theme="oled"
                        onclick="changeTheme(this)"
                        active
                        >
                        <span style="background:#000000;"></span>
                        <span style="background:#0f0f0f;"></span>
                        <span style="background:#0a0a0a;"></span>
                        <md-ripple></md-ripple>
                    </div>
                    <div 
                        class="ball" 
                        data-theme="super-blue"
                        onclick="changeTheme(this)"
                        >
                        <span style="background:#0028db;"></span>
                        <span style="background:#4058ff;"></span>
                        <span style="background:#afb8ff;"></span>
                        <md-ripple></md-ripple>
                    </div>
                    <div 
                        class="ball" 
                        data-theme="red"
                        onclick="changeTheme(this)"
                        >
                        <span style="background:#a50012;"></span>
                        <span style="background:#db3331;"></span>
                        <span style="background:#ff958b;"></span>
                        <md-ripple></md-ripple>
                    </div>
                    <div 
                        class="ball" 
                        data-theme="orange"
                        onclick="changeTheme(this)"
                        >
                        <span style="background:#F47700;"></span>
                        <span style="background:#FFB347;"></span>
                        <span style="background:#B9A598;"></span>
                        <md-ripple></md-ripple>
                    </div>
                    <!-- <div 
                        class="ball" 
                        data-theme="frutiger-aero"
                        onclick="changeTheme(this)"
                        >
                        <span style="background:blue;"></span>
                        <span style="background:cyan;"></span>
                        <span style="background:red;"></span>
                        <md-ripple></md-ripple>
                    </div> -->
                    <div 
                        class="ball" 
                        data-theme="modern-1"
                        onclick="changeTheme(this)"
                        >
                        <span style="background:linear-gradient(45deg   , #E7A4DC 0%, #D56CC5 53.2%, #6042E1 100%)"></span>
                        <span style="background:linear-gradient(180deg, #E7A4DC 0%, #D56CC5 53.2%, #6042E1 100%)"></span>
                        <span style="background:linear-gradient(0deg, #E7A4DC 0%, #D56CC5 10.2%, #6042E1 100%)"></span>
                        <md-ripple></md-ripple>
                    </div>
                    <div 
                        class="ball" 
                        data-theme="pastel-pink"
                        onclick="changeTheme(this)"
                        >
                        <span style="background:#C76BAE;"></span>
                        <span style="background:#E893D3;"></span>
                        <span style="background:#E8C2E3;"></span>
                        <md-ripple></md-ripple>
                    </div>
                    <div 
                        class="ball" 
                        data-theme="funny"
                        onclick="changeTheme(this)"
                        >
                        <span style="background:#006874;"></span>
                        <span style="background:#4fd8eb;"></span>
                        <span style="background:#9af0ff;"></span>
                        <md-ripple></md-ripple>
                    </div>
                    <!-- <div 
                        class="ball" 
                        data-theme="new"
                        onclick="changeTheme(this)"
                        >
                        <span style="background:#F4442E;"></span>
                        <span style="background:#758BFD;"></span>
                        <span style="background:#03045E;"></span>
                        <md-ripple></md-ripple>
                    </div>
                    <div 
                        class="ball" 
                        data-theme="new2"
                        onclick="changeTheme(this)"
                        >
                        <span style="background:#758BFD;"></span>
                        <span style="background:#F4442E;"></span>
                        <span style="background:#03045E;"></span>
                        <md-ripple></md-ripple>
                    </div> -->
                </div>
                <div class="simple-container">
                    <div 
                        class="content-box direction-row padding-16 border-radius-16 justify-center user-select-none cursor-pointer"
                        onclick="resetTheme()"
                        >
                        <md-ripple></md-ripple>
                        <span class="body-medium">Restablecer tema</span>
                    </div>
                </div>
                <div class="simple-container direction-column gap-16">
                    <div class="simple-container gpa-8 direction-column">
                        <span class="headline-small">Navegación</span>
                        <span class="body-large on-surface-variant-text">Elige el estilo de navegación que más te guste </span>
                    </div>
                    <div class="simple-container flex-wrap gap-8 nav-selector-parent" id="nav-selector-parent">
                        <div 
                            class="nav-option hide-on-mobile" 
                            data-nav-option="1"
                            onclick="changeNav(this)"
                            >
                            <md-ripple></md-ripple>
                            Clásica
                        </div>
                        <div 
                            class="nav-option"
                            data-nav-option="2"
                            onclick="changeNav(this)" 
                            active
                            >
                            <md-ripple></md-ripple>
                            Moderna
                        </div>
                        <div 
                            class="nav-option hide-on-mobile"
                            data-nav-option="3"
                            onclick="changeNav(this)"
                            >
                            <md-ripple></md-ripple>
                            Inferior
                        </div>
                        <div 
                            class="nav-option hide-on-mobile"
                            data-nav-option="2 glass-nav"
                            onclick="changeNav(this)"
                            >
                            <md-ripple></md-ripple>
                            Detallada
                        </div>
                        <div 
                            class="nav-option hide-on-mobile"
                            data-nav-option="6"
                            onclick="changeNav(this)"
                            >
                            <md-ripple></md-ripple>
                            Interesante
                        </div>
                        <div 
                            class="nav-option"
                            data-nav-option="7"
                            onclick="changeNav(this)"
                            >
                            <md-ripple></md-ripple>
                            Dock
                        </div>
                        <div 
                            class="nav-option hide-on-mobile"
                            data-nav-option="8"
                            onclick="changeNav(this)"
                            >
                            <md-ripple></md-ripple>
                            Bonita
                        </div>
                        <div 
                            class="nav-option hide-on-mobile"
                            data-nav-option="9"
                            onclick="changeNav(this)"
                            >
                            <md-ripple></md-ripple>
                            Minimalista
                        </div>
                        <div 
                            class="nav-option hide-on-mobile"
                            data-nav-option="10"
                            onclick="changeNav(this)"
                            >
                            <md-ripple></md-ripple>
                            Neutral
                        </div>
                    </div>
                    <div class="simple-container">
                        <span class="label-large outline-text">
                            Los cambios solo se verán reflejados dentro de una aplicación
                        </span>
                    </div>
                </div>
                
            </div>
        </div>

        <!-- Appointments Settings -->
        <div class="w-section padding-24 overflow-auto simple-container direction-column grow-1 dm-sans-all" id="settings-w-section-appts-settings">

        </div>

        <!-- Billing -->
        <div class="w-section padding-24 overflow-auto simple-container direction-column grow-1" id="settings-w-section-billing">
            <?php include_once $_SERVER['DOCUMENT_ROOT'] . BASE_URL .'apps/mind/views/partials/billing-page.php'; ?>
        </div>
        
        <div class="w-section padding-24 overflow-auto simple-container direction-column grow-1 dm-sans-all on-background-text" id="settings-w-section-request-billing">
            <?php include_once $_SERVER['DOCUMENT_ROOT'] . BASE_URL .'apps/mind/views/partials/request-billing-page.php'; ?>
        </div>

        <!-- Info -->
        <div class="w-section padding-24 overflow-auto simple-container direction-column gap-16 grow-1" id="w-section-information">
            <div class="simple-container gpa-8 direction-column">
                <span class="headline-medium" data-shared_element_info_title>Información</span>
                <span class="body-large outline-text" data-shared_element_stepbro_notes_subtitle>Información sobre Stepbro Apps y Desarrolladores</span>
            </div>

            <div class="simple-container direction-column gap-8 on-background-text">
                <div 
                    class="
                        content-box 
                        align-center 
                        direction-row
                        padding-24 
                        border-radius-16 
                        justify-between 
                        cursor-pointer
                        hover-outline
                    "
                    data-shared_element_stepbro_build_info_container
                    onclick="toggleWSection('#w-sub-section-stepbro_build_info')"
                    >
                    <md-ripple></md-ripple>
                    <div class="label-large">Codemelon Build</div>
                    <span class="label-large simple-container align-center gap-8">
                        Información
                        <md-icon class=" filled">arrow_circle_right</md-icon>
                    </span>
                </div>

                <div 
                    class="
                        content-box 
                        align-center 
                        direction-row
                        padding-24 
                        border-radius-16 
                        justify-between 
                        cursor-pointer
                        hover-outline
                    "
                    data-shared_element_stepbro_notes_app_info_container
                    onclick="toggleWSection('#w-sub-section-notes_app_info')"
                    >
                    <md-ripple></md-ripple>
                    <div class="label-large">Melon Mind</div>
                    <span class="label-large simple-container align-center gap-8">
                        Información
                        <md-icon class=" filled">arrow_circle_right</md-icon>
                    </span>
                </div>

                <div 
                    class="
                        content-box 
                        align-center 
                        direction-row
                        padding-24 
                        border-radius-16 
                        justify-between 
                        cursor-pointer
                        hover-outline
                    "
                    onclick="window.open('https://api.whatsapp.com/send?phone=34644675909&text=%C2%A1Hola!%20Estoy%20interesado%20en%20recibir%20m%C3%A1s%20informaci%C3%B3n%20sobre%20Melon%20Mind.', '_blank');"
                    >
                    <md-ripple></md-ripple>
                    <div class="label-large simple-container aling-center gap-4"><md-icon class="dynamic">support_agent</md-icon>Soporte técnico</div>
                    <span class="label-large simple-container align-center gap-8">                    
                        <md-icon class=" filled">arrow_circle_right</md-icon>
                    </span>
                </div>

                <!-- <div 
                    class="
                        content-box 
                        align-center 
                        direction-row
                        padding-24 
                        border-radius-16 
                        justify-between 
                        cursor-pointer
                        hover-outline
                    "
                    onclick="toggleWSection('#w-sub-section-terms_of_use')"
                    >
                    <md-ripple></md-ripple>
                    <div class="label-large">Términos de uso</div>
                    <span class="label-large simple-container align-center gap-8">
                        <md-icon class=" filled">arrow_circle_right</md-icon>
                    </span>
                </div> -->
                
            </div>
            
            
            

        </div>

        <!-- Info subsections -->
        <div class="w-section padding-24 overflow-auto simple-container direction-column gap-16  grow-1" id="w-sub-section-notes_app_info">
            
            <div class="simple-container">
                <md-icon-button onclick="toggleWSection('#w-section-information')"><md-icon>arrow_back</md-icon></md-icon-button>
            </div>
            <div class="simple-container gpa-8 direction-column">
                <span class="headline-medium fit-content dm sans" data-shared_element_info_title>Melon Mind</span>
                <span class="body-large outline-text">Información sobre la app y el desarrollador</span>
            </div>
            <div class="simple-container direction-column gap-8" data-shared_element_stepbro_notes_app_info_container>
                <div class="content-box direction-row padding-24 border-radius-16 justify-between">
                    <div class="simple-container"><span class="label-large">Versión</span></div>
                    <div class="simple-container"><span class="body-large
                    ">Beta 1</span></div>
                </div>

                <div class="content-box padding-8 border-radius-16 on-background-tex">
                    <div class="simple-container direction-column gap-8 b-padding-8 padding-16">
                        <span class="label-large">Créditos</span>
                    </div>
                    
                    <div class="content-box light-color padding-24 border-radius-8 justify-between">
                        <div class="simple-container direction-column gap-8">
                            <div class="simple-container direction-column gap-4">
                                <span class="headline-small bricolage weight-500">Luis David Elizarraraz Mondaca</span>
                                <span class="body-medium outline-text">Desarrollador Full Stack | Arquitecto de Software | Diseñador de UI/UX | Fundador del proyecto Melon Mind con iniciativa como Stepbro Mind</span>
                            </div>

                            <div class="simple-container top-margin-8 gap-8">

                                <a href="https://www.youtube.com/@stepbro_davo" target="_blank" class="content-box outline-light-1 width-auto cursor-pointer border-radius-8 padding-16">
                                    <md-ripple></md-ripple>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M23.498 6.18598C23.3624 5.67526 23.095 5.20912 22.7226 4.83425C22.3502 4.45937 21.8858 4.18892 21.376 4.04998C19.505 3.54498 12 3.54498 12 3.54498C12 3.54498 4.495 3.54498 2.623 4.04998C2.11341 4.18917 1.64929 4.45972 1.27708 4.83456C0.904861 5.20941 0.637591 5.67542 0.502 6.18598C0 8.06998 0 12 0 12C0 12 0 15.93 0.502 17.814C0.637586 18.3247 0.904975 18.7908 1.27739 19.1657C1.64981 19.5406 2.11418 19.811 2.624 19.95C4.495 20.455 12 20.455 12 20.455C12 20.455 19.505 20.455 21.377 19.95C21.8869 19.8111 22.3513 19.5407 22.7237 19.1658C23.0961 18.7909 23.3635 18.3248 23.499 17.814C24 15.93 24 12 24 12C24 12 24 8.06998 23.498 6.18598ZM9.545 15.568V8.43198L15.818 12L9.545 15.568Z" fill="var(--md-sys-color-on-background)"/>
                                    </svg>
                                </a>
                                <a href="mailto:luisdavid.gris@gmail.com" target="_blank" class="content-box outline-light-1 width-auto cursor-pointer border-radius-8 padding-16">
                                    <md-ripple></md-ripple>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <g clip-path="url(#clip0_59_10)">
                                        <path d="M24 5.45703V19.366C24 20.27 23.268 21.002 22.364 21.002H18.545V11.73L12 16.64L5.455 11.73V21.003H1.636C1.42107 21.003 1.20825 20.9607 1.0097 20.8784C0.811145 20.7961 0.63075 20.6755 0.47882 20.5235C0.32689 20.3715 0.206404 20.191 0.124246 19.9924C0.0420884 19.7938 -0.000131068 19.581 3.05652e-07 19.366V5.45703C3.05652e-07 3.43403 2.309 2.27903 3.927 3.49303L5.455 4.64003L12 9.54803L18.545 4.63803L20.073 3.49303C21.69 2.28003 24 3.43403 24 5.45703Z" fill="var(--md-sys-color-on-background)"/>
                                        </g>
                                        <defs>
                                        <clipPath id="clip0_59_10">
                                        <rect width="24" height="24" fill="white"/>
                                        </clipPath>
                                        </defs>
                                    </svg>
                                </a>
                                
                            </div>

                        </div>    
                    </div>

                    <div class="content-box light-color padding-24 border-radius-8 justify-between">
                        <div class="simple-container direction-column gap-8">
                            <div class="simple-container direction-column gap-4">
                                <span class="headline-small bricolage weight-500">Álvaro Pérez March</span>
                                <span class="body-medium outline-text">Cofundador de Melon Mind | Estrategia, Marketing y Conexión con Psicólogos</span>
                            </div>


                        </div>    
                    </div>

                    
                </div>
                

            </div>
            
        </div>

        <div class="w-section padding-24 overflow-auto simple-container direction-column gap-16  grow-1" id="w-sub-section-stepbro_build_info">
            <div class="simple-container">
                <md-icon-button onclick="toggleWSection('#w-section-information')"><md-icon>arrow_back</md-icon></md-icon-button>
            </div>
            <div class="simple-container gpa-8 direction-column">
                <span class="headline-medium fit-content" data-shared_element_info_title>Codemelon Build</span>
                <span class="body-large outline-text">Información sobre la app y el desarrollador</span>
            </div>
            <div class="simple-container direction-column gap-8" data-shared_element_stepbro_build_info_container>
                <div class="content-box direction-row padding-24 border-radius-16 justify-between">
                    <div class="simple-container"><span class="label-large">Versión</span></div>
                    <div class="simple-container"><span class="body-large
                    ">Beta 1</span></div>
                </div>   
            </div>    
        </div>

        <div class="w-section padding-24 overflow-auto simple-container direction-column grow-1" style="padding-bottom:100px" id="w-sub-section-terms_of_use">
            <div class="simple-container bottom-margin-8">
                <md-filled-icon-button onclick="toggleWSection('#w-section-information')"><md-icon>arrow_back</md-icon></md-filled-icon-button>
            </div>
            <span class="headline-small dm-sans on-background-text weight-500 bottom-margin-8">Términos de uso</span>
            
            <div class="body-large on-background-text">Uso del software</div>
            <ul class="body-medium outline-text bottom-margin-8">
                <li>El usuario se compromete a utilizar el software únicamente para fines lícitos y de acuerdo con estos términos de uso.</li>
                <li>El usuario no podrá utilizar el software para fines ilegales, dañinos o que infrinjan los derechos de terceros.</li>
                <li>El usuario no podrá acceder al software de forma no autorizada ni intentar vulnerar sus medidas de seguridad.</li> 
            </ul>

            <div class="body-large on-background-text">Responsabilidad</div>
            <ul class="body-medium outline-text bottom-margin-8">
                <li>El autor no se hace responsable por los daños y perjuicios que puedan derivarse del uso del software, incluyendo la pérdida de datos, interrupción del servicio o errores en el funcionamiento.</li>
                <li>El usuario es el único responsable del uso que haga del software y de las consecuencias que puedan derivarse.</li>
            </ul>

            <div class="body-large on-background-text">Uso del software</div>
            <ul class="body-medium outline-text bottom-margin-8">
                <li>El autor se reserva el derecho de modificar estos términos de uso en cualquier momento y sin previo aviso.</li>
                <li>El usuario se compromete a revisar periódicamente estos términos de uso para estar informado de los cambios.</li>
            </ul>
        </div>

            <!-- Subscription subsection -->
    
    </holder>

    <div
        data-sub-section
        data-flip-id="animate"
        id="sub-section-subscription"
        class="simple-container direction-column absolute-screen full-width on-background-text top-padding-safe-area align-center"
        style="background:var(--md-sys-color-background);"
        >
        <div class="simple-container width-100">
                <md-icon-button name="button-close-subscription-sub-section"><md-icon>arrow_back</md-icon></md-icon-button>
            </div>
        <div class="simple-container direction-column gap-24 width-100 max-width-600">
            

            <div class="simple-container direction-column">
                <span class="display-large dm-sans top-margin-8">Suscripción</span>
            </div>

            <div class="simple-container gap-8 flex-wrap">
                <button 
                    active
                    data-w-section="w-section-subscriptions"
                    onclick="toggleWSection('#w-section-subscriptions')" 
                    class="style-2"
                    >
                    <md-ripple></md-ripple>
                    Suscripciones
                </button>
                <button 
                    data-w-section="w-section-invoices"
                    onclick="toggleWSection('#w-section-invoices')" 
                    class="style-2"
                    >
                    <md-ripple></md-ripple>
                    Facturas
                </button>

            </div>


            <div active class="w-section simple-container direction-column grow-1" id="w-section-subscriptions">
                <div name="table-subscriptions" class="simple-container direction-column gap-8"></div>
                <div class="simple-container"></div>
            </div>

            <div  class="w-section simple-container direction-column grow-1" id="w-section-invoices">
                <div name="table-invoices" class="simple-container direction-column gap-8"></div>
                <div class="simple-container"></div>
            </div>
            

            
        </div>
    </div>

    <md-dialog id="dialog-account" style="min-width: calc(-1600px + 100vw)">
        <div slot="headline">Cuenta</div>
        <form id="form-dialog-account" slot="content" method="dialog">
            <md-list style="border-radius:16px;">
            <md-list-item>
                <md-icon slot="start">tag</md-icon>
                <div slot="headline" id="response-account-id" name="account-id">...</div>
            </md-list-item>
            <md-list-item>
                <md-icon slot="start">mail</md-icon>
                <div slot="headline" id="response-account-email" name="account-email">...</div>
            </md-list-item>
            </md-list>
            <div class="simple-container direction-column gap-8 v-margin">

            <md-outlined-text-field 
                id="modify-account-username"
                name="account-username"
                label="Nombre de usuario" 
                role="presentation"
                style="margin-top:8px;"
                >
            </md-outlined-text-field>
            </div>
        </form>
        <div slot="actions">
            <md-text-button form="form-dialog-account" value="cancel">Cancelar</md-text-button>
            <md-filled-button name="button-modify-user-data" value="save">Guardar</md-filled-button>
        </div>
    </md-dialog>

    <md-dialog id="dialog-logout-confirmation">
        <div slot="headline">Cerrar sesión</div>
        <md-icon slot="icon" aria-hidden="true">logout</md-icon>
        <form id="form-dialog-logout-confirmation" slot="content" method="dialog">
            ¿Estas seguro de que quieres cerrar sesión?
        </form>
        <div slot="actions">
            <md-text-button form="form-dialog-logout-confirmation" value="cancel">Cancelar</md-text-button>
            <md-filled-tonal-button class="delete" value="save" name="button-logout">Cerrar sesión</md-filled-tonal-button>
        </div>
    </md-dialog>

</window>




<!-- <script>
    document.addEventListener("DOMContentLoaded", function(event) {
        // getUserData();
        syncUserData();
    });
</script> -->