<window 
    id="window-admin-panel"
    class="increased full-size"
    data-flip-id="animate"
    >
    <div class="simple-container padding-16 align-center gap-8">
        <md-icon-button onclick="toggleWindow()"><md-icon>close</md-icon></md-icon-button>
        <span class="headline-small dm-sans">Panel de administrador</span>
        <!-- <md-text-button onclick="toggleWindow()"><md-icon slot="icon">exit_to_app</md-icon>Salir del panel</md-text-button> -->
    </div>
    <holder class="">
        
    <div class=" simple-container direction-column grow-1 align-center on-background-text gap-16">
            <div class="w-nav simple-container direction-column width-100 max-width-1200 overflow-hidden gap-16">
                
                <!-- <div class="simple-container direction-column">
                    <span class="display-small dm-sans weight-500 on-background-text">Panel de administrador</span>
                    <span class="body-large dm-sans outline-text">
                        Bienvenido al panel de administrador. Aquí podrás gestionar los usuarios y sus datos.
                    </span>
                </div> -->

                <div class="simple-container gap-8 overflow-auto border-radius-24">
                    <button 
                        class="simple-container align-center gap-4 style-2 rounded dm-sans"
                        data-w-section="w-section-admin-panel-users"
                        onclick="toggleWSection('w-section-admin-panel-users', this)"
                        active
                        >
                        <md-ripple></md-ripple>
                        <md-icon class="dynamic">group</md-icon>
                        <span>Usuarios</span>
                    </button>
                    <button 
                        class="simple-container align-center gap-4 style-2 rounded dm-sans"
                        data-w-section="w-section-admin-panel-paiduser"
                        onclick="toggleWSection('w-section-admin-panel-paiduser', this)"
                        >
                        <md-ripple></md-ripple>
                        <md-icon class="dynamic">rocket_launch</md-icon>
                        <span style="text-wrap:nowrap">Usuarios Pro</span>
                    </button>
                    <button 
                        class="simple-container align-center gap-4 style-2 rounded dm-sans"
                        data-w-section="w-section-admin-panel-app-access"
                        onclick="toggleWSection('w-section-admin-panel-app-access', this)"
                        >
                        <md-ripple></md-ripple>
                        <md-icon class="dynamic">open_in_phone</md-icon>
                        <span>Accesos</span>
                    </button>
                    <button 
                        class="simple-container align-center gap-4 style-2 rounded dm-sans"
                        data-w-section="w-section-admin-panel-suggestions"
                        onclick="toggleWSection('w-section-admin-panel-suggestions', this)"
                        >
                        <md-ripple></md-ripple>
                        <md-icon class="dynamic">feedback</md-icon>
                        <span>Sugerencias</span>
                    </button>
                    <button 
                        class="simple-container align-center gap-4 style-2 rounded dm-sans"
                        data-w-section="w-section-admin-panel-actions"
                        onclick="toggleWSection('w-section-admin-panel-actions', this)"
                        >
                        <md-ripple></md-ripple>
                        <md-icon class="dynamic">analytics</md-icon>
                        <span>Acciones</span>
                    </button>
                    <button 
                        class="simple-container align-center gap-4 style-2 rounded dm-sans"
                        data-w-section="w-section-admin-panel-therapists"
                        onclick="toggleWSection('w-section-admin-panel-therapists', this)"
                        >
                        <md-ripple></md-ripple>
                        <md-icon class="dynamic">psychology</md-icon>
                        <span style="white-space: nowrap;">Datos de terapeutas</span>
                    </button>
                    

                    <!-- <button 
                        class="w-nav-button style-2"
                        data-w-section="w-section-admin-panel-email"
                        onclick="toggleWSection('w-section-admin-panel-email', this)"
                        >
                        <md-ripple></md-ripple>
                        <md-icon>email</md-icon>
                        <span>Email</span>
                    </button> -->
                </div>
            </div>
            <div 
                class="w-section simple-container direction-column width-100 max-width-1200 overflow-hidden gap-16" 
                id="w-section-admin-panel-users"
                active
                >

                <div class="simple-container gap-8 flex-wrap">
                    <div class="content-box basis-normal grow-1 overflow-hidden rounded gap-0 outline-1-light-inset">
                        <span class="body-large">Usuarios totales</span>
                        <span class="display-large weight-bold" id="response-admin-panel-total-users">...</span>
                        <md-icon class="absolute-card" aria-hidden="true">person_add</md-icon>
                    </div>
                </div>
                
                <div class="simple-container direction-column overflow-auto padding-1">
                    <table 
                        class="style-2"
                        id="response-users-table"
                    >
                    </table>
                    <div class="simple-container" id="pagination-users-table"></div>  
                    <!-- <div class="simple-container width-100 container-info-empty-table grow-1"></div> -->
                </div>
                
                    
            </div>
            <div
                class="w-section simple-container direction-column width-100 max-width-1200 overflow-hidden gap-16" 
                id="w-section-admin-panel-app-access"
                >
                <div class="simple-container gap-8 flex-wrap">
                    <div class="content-box basis-normal grow-1 overflow-hidden rounded gap-0 outline-1-light-inset cursor-pointer">
                        <md-ripple></md-ripple>
                        <span class="body-large">Accesos totales</span>
                        <span class="display-large weight-bold" id="response-admin-panel-total-access">...</span>
                        <md-icon class="absolute-card" aria-hidden="true">open_in_phone</md-icon>
                    </div>
                </div>

                <div class="simple-container direction-column overflow-auto padding-1">
                    <table 
                        class="style-2"
                        id="response-admin-panel-access-table"
                    >
                    </table>
                    <div class="simple-container" id="pagination-admin-panel-access-table"></div>  
                </div>

            </div>
            <div
                class="w-section simple-container direction-column width-100 max-width-1200 overflow-hidden gap-16" 
                id="w-section-admin-panel-suggestions"
                >
                <div class="simple-container gap-8 flex-wrap">
                    <div class="content-box basis-normal grow-1 overflow-hidden rounded gap-0 outline-1-light-inset cursor-pointer">
                        <md-ripple></md-ripple>
                        <span class="body-large">Sugerencias totales</span>
                        <span class="display-large weight-bold" id="response-admin-panel-total-suggestions">...</span>
                        <md-icon class="absolute-card" aria-hidden="true">feedback</md-icon>
                    </div>
                </div>

                <div class="simple-container direction-column overflow-auto padding-1">
                    <table 
                        class="style-2"
                        id="response-admin-panel-suggestions-table"
                    >
                    </table>
                    <div class="simple-container" id="pagination-admin-panel-suggestions-table"></div>  
                </div>
            </div>
            <div
                class="w-section simple-container direction-column width-100 max-width-1200 overflow-hidden gap-16" 
                id="w-section-admin-panel-actions"
                >

                <span class="body-large dm-sans outline-text">Periodo de los datos</span>
                <div class="simple-container gap-8 align-center overflow-auto">
                    <input class="no-reset" type="date" onclick="this.showPicker()" name="date_start" id="date_start" class="input-text" value="<?= date('Y-m-01') ?>">

                        <md-icon>trending_flat</md-icon>

                    <input class="no-reset" type="date" onclick="this.showPicker()" name="date_end" id="date_end" class="input-text" value="<?= date('Y-m-t') ?>">
                </div>

                <div class="content-box background outline-light-1 padding-8">
                    <span class="body-large outline-text padding-16" style="padding-bottom:0px;">Acciones totales</span>
                    <div class="content-box light-color padding-16 h-padding-24 border-radius-16 ">
                        <span class="display-large dm-sans line-height-1 weight-600" name="total_actions">
                            <md-circular-progress indeterminate></md-circular-progress>
                        </span>
                    </div>
                </div>

                <div class="simple-container gap-8 flex-wrap">
                    <div class="content-box padding-8 background outline-light-1 width-auto grow-1 basis-normal">
                        <div class="simple-container padding-16">
                            <span class="headline-small dm-sans weight-500">Pacientes</span>
                        </div>

                        <div class="content-box direction-row light-color padding-24 border-radius-16 justify-between">
                            <span class="body-large">Creados</span>
                            <span class="body-large weight-500" name="patient_create">...</span>
                        </div>
                        <div class="content-box direction-row light-color padding-24 border-radius-16 justify-between">
                            <span class="body-large">Editados</span>
                            <span class="body-large weight-500" name="patient_edit">...</span>
                        </div>
                        <div class="content-box direction-row light-color padding-24 border-radius-16 justify-between">
                            <span class="body-large">Eliminados</span>
                            <span class="body-large weight-500" name="patient_delete">...</span>
                        </div>
                    </div>

                    <div class="content-box padding-8 background outline-light-1 width-auto grow-1 basis-normal">
                        <div class="simple-container padding-16">
                            <span class="headline-small dm-sans weight-500">Citas</span>
                        </div>

                        <div class="content-box direction-row light-color padding-24 border-radius-16 justify-between">
                            <span class="body-large">Creadas</span>
                            <span class="body-large weight-500" name="appt_create">...</span>
                        </div>
                        <div class="content-box direction-row light-color padding-24 border-radius-16 justify-between">
                            <span class="body-large">Editadas</span>
                            <span class="body-large weight-500" name="appt_edit">...</span>
                        </div>
                        <div class="content-box direction-row light-color padding-24 border-radius-16 justify-between">
                            <span class="body-large">Eliminadas</span>
                            <span class="body-large weight-500" name="appt_delete">...</span>
                        </div>
                    </div>

                    <div class="content-box padding-8 background outline-light-1 width-auto grow-1 basis-normal">
                        <div class="simple-container padding-16">
                            <span class="headline-small dm-sans weight-500">Documentos</span>
                        </div>

                        <div class="content-box direction-row light-color padding-24 border-radius-16 justify-between">
                            <span class="body-large">Creados</span>
                            <span class="body-large weight-500" name="consent_create">...</span>
                        </div>
                        <div class="content-box direction-row light-color padding-24 border-radius-16 justify-between">
                            <span class="body-large">Editados</span>
                            <span class="body-large weight-500" name="consent_edit">...</span>
                        </div>
                        <div class="content-box direction-row light-color padding-24 border-radius-16 justify-between">
                            <span class="body-large">Eliminados</span>
                            <span class="body-large weight-500" name="consent_delete">...</span>
                        </div>
                    </div>

                    <div class="content-box padding-8 background outline-light-1 width-auto grow-1 basis-normal">
                        <div class="simple-container padding-16">
                            <span class="headline-small dm-sans weight-500">Gastos</span>
                        </div>

                        <div class="content-box direction-row light-color padding-24 border-radius-16 justify-between">
                            <span class="body-large">Creados</span>
                            <span class="body-large weight-500" name="expense_create">...</span>
                        </div>
                        <div class="content-box direction-row light-color padding-24 border-radius-16 justify-between">
                            <span class="body-large">Editados</span>
                            <span class="body-large weight-500" name="expense_edit">...</span>
                        </div>
                        <div class="content-box direction-row light-color padding-24 border-radius-16 justify-between">
                            <span class="body-large">Eliminados</span>
                            <span class="body-large weight-500" name="expense_delete">...</span>
                        </div>
                    </div>


                </div>

                

    
                <!-- <span class="headline-large dm-sans weight-500">Pacientes</span>
                <div class="simple-container gap-8 flex-wrap">
                    <div class="content-box light-color outline-light-1 grow-1 basis-normal">
                        <span class="headline-small outline-text dm-sans">
                            Pacientes creados
                        </span>
                        <span class="display-large weight-600 dm-sans" name="patient_create">...</span>
                    </div>
                    <div class="content-box light-color outline-light-1 grow-1 basis-normal">
                        <span class="headline-small outline-text dm-sans">
                            Pacientes editados
                        </span>
                        <span class="display-large weight-600 dm-sans" name="patient_edit">...</span>
                    </div>
                    <div class="content-box light-color outline-light-1 grow-1 basis-normal">
                        <span class="headline-small outline-text dm-sans">
                            Pacientes eliminados
                        </span>
                        <span class="display-large weight-600 dm-sans" name="patient_delete">...</span>
                    </div>
                </div>
    
                <span class="headline-large dm-sans weight-500 top-margin-32">Citas</span>
                <div class="simple-container gap-8 flex-wrap">
                    <div class="content-box light-color outline-light-1 grow-1 basis-normal">
                        <span class="headline-small outline-text dm-sans">
                            Pacientes creados
                        </span>
                        <span class="display-large weight-600 dm-sans" name="appt_create">...</span>
                    </div>
                    <div class="content-box light-color outline-light-1 grow-1 basis-normal">
                        <span class="headline-small outline-text dm-sans">
                            Pacientes editados
                        </span>
                        <span class="display-large weight-600 dm-sans" name="appt_edit">...</span>
                    </div>
                    <div class="content-box light-color outline-light-1 grow-1 basis-normal">
                        <span class="headline-small outline-text dm-sans">
                            Pacientes eliminados
                        </span>
                        <span class="display-large weight-600 dm-sans" name="appt_delete">...</span>
                    </div>
                </div>
                 -->
                
    
            </div>


            <div
                class="w-section simple-container direction-column width-100 max-width-1200 gap-16" 
                id="w-section-admin-panel-paiduser"
                >

                <div class="content-box background outline-light-1 padding-8">
                    <span class="body-large outline-text padding-16" style="padding-bottom:0px;">Usuarios de suscritos (Activos, prueba y cancelados)</span>
                    <div class="content-box light-color padding-16 h-padding-24 border-radius-16 ">
                        <span class="display-large dm-sans line-height-1 weight-600" name="total_paid_users">...</span>
                    </div>
                </div>


                <div class="simple-container direction-column gap-8 overflow-auto padding-1" id="response-admin-panel-paid-users-table-container">

                    <div class="simple-container" name="filters-container"></div>
                    <table class="style-4" name="table-container"></table>
                    <div class="simple-container" name="pagination-container"></div>


                </div>

            </div>


            <div
                class="w-section simple-container direction-column width-100 max-width-1200 overflow-hidden gap-16" 
                id="w-section-admin-panel-therapists"
                >
                <div class="content-box background outline-light-1 padding-8">
                    <span class="body-large outline-text padding-16" style="padding-bottom:0px;">Total de datos de terapeutas reecopilados</span>
                    <div class="content-box light-color padding-16 h-padding-24 border-radius-16 ">
                        <span class="display-large dm-sans line-height-1 weight-600" id="response-admin-panel-total-therapists">
                            <md-circular-progress indeterminate></md-circular-progress>
                        </span>
                    </div>
                </div>

                <div class="simple-container direction-column overflow-auto padding-1">
                    <table 
                        class="style-4"
                        id="response-admin-panel-therapists-table"
                    >
                    </table>
                    <div class="simple-container" id="pagination-admin-panel-therapists-table"></div>  
                </div>

            </div>
          

            </div>
            
        </div>


    </holder>
    <div
        data-sub-section
        data-flip-id="animate"
        id="sub-section-admin-panel-paid-user-profile"
        class="simple-container direction-column absolute-screen gap-8 top-padding-safe-area on-background-text"
        style="padding:16px;"
        >

        

        <div class="content-box padding-8 border-radius-32 outline-light-1" style="background:transparent;">
            <div class="simple-container padding-8">
                <md-icon-button onclick="toggleSubSection('#sub-section-admin-panel-paid-user-profile', {action:'close'})"><md-icon>close</md-icon></md-icon-button>
            </div>
            <div class="simple-container justify-center top-margin-16 bottom-margin-24 hover-scale-small" name="user_profile_picture"></div>
            <div class="content-box surface">
                <i class="dm-sans body-large line-height-1" name="user_id">...</i>
                <span class="dm-sans headline-medium weight-600 line-height-1" name="user_name">...</span>
                <span class="dm-sans body-large line-height-1" name="user_email">...</span>
                <span class="dm-sans outline-text" name="user_creation_datetime">...</span>
            </div>

                <!-- <span class="display-medium dm-sans">luisdavid.gris@gmail.com</span> -->
        </div>

        <div class="content-box surface">
            <div class="simple-container justify-between align-center">
                <span class="headline-small dm-sans weight-500">Último acceso</span>
                <button class="style-4 border-radius-24 background outline-light-1 dm-sans on-background-text" onclick="message('Pronto disponible')">
                    <md-ripple></md-ripple>
                    Ver todos los accesos
                </button>
            </div>

            <div class="simple-container gap-4">
                <div class="content-box border-radius-32 width-auto padding-16 ">
                    <md-icon name="last_access_device_type">iphone</md-icon>
                </div>
                <div class="content-box border-radius-32 width-auto padding-16 dm-sans weight-500 justify-center h-padding-24 ">
                    <span name="last_access_time_ago"></span>
                </div>
            </div>

            <span class="dm-sans body-large outline-text" name="last_access_timestamp"></span>
            <span class="dm-sans body-large outline-text" name="last_access_ip_address"></span>

        </div>


        <div class="content-box surface">
            <div class="simple-container justify-between align-center">
                <span class="headline-small dm-sans weight-500">Suscripción</span>
                <button class="style-4 border-radius-24 background outline-light-1 dm-sans on-background-text" onclick="message('Pronto disponible')">
                    <md-ripple></md-ripple>
                    Ver facturas
                </button>
            </div>

            <span class="dm-sans body-large simple-container align-center gap-4" name="subscription_status"></span>


            <span class="body-large dm-sans">Período actual </span>
            <div class="simple-container gap-4">
                <span class="content-box padding-16 weight-500 dm-sans body-large simple-container align-center gap-4" name="current_period_start" style="border-radius: 64px 32px 32px 64px;" ></span>
                <div class="content-box padding-16 justify-center width-auto h-padding-24 hide-on-mobile border-radius-16"><md-icon class="dynamic">arrow_forward</md-icon></div>
                <span class="content-box padding-16 weight-500 dm-sans body-large simple-container align-center gap-4" name="current_period_end" style="border-radius: 32px 64px 64px 32px;"></span>
            </div>
        </div>

        <div class="content-box surface">
            <div class="simple-container justify-between align-center">
                <span class="headline-small dm-sans weight-500">Acciones</span>
                <button class="style-4 border-radius-24 background outline-light-1 dm-sans on-background-text" onclick="message('Pronto disponible')">
                    <md-ripple></md-ripple>
                    Ver detalle
                </button>
            </div>

            <div class="simple-container direction-column gap-8">
                <div class="simple-container gap-4 dm-sans weight-500 body-large line-height-1">
                    <div style="padding-left:32px; padding-right:32px;" class="content-box surface-variant on-surface-variant-text border-radius-64 width-auto" name="actions_total_today">24</div>
                    <div class="content-box surface-variant on-surface-variant-text border-radius-64 ">Hoy</div>
                </div>
                <div class="simple-container gap-4 dm-sans weight-500 body-large line-height-1">
                    <div class="content-box border-radius-64 width-auto" name="actions_total_this_week">24</div>
                    <div class="content-box border-radius-64 ">Esta semana</div>
                </div>
                <div class="simple-container gap-4 dm-sans weight-500 body-large line-height-1">
                    <div class="content-box border-radius-64 width-auto" name="actions_total_all_time">24</div>
                    <div class="content-box border-radius-64 ">Todo el tiempo</div>
                </div>
            </div>

            <!-- <div class="simple-container direction-column gap-8" name="user-actions-container">
                <div class="simple-container gap-4 dm-sans weight-500 body-large line-height-1">
                    <div class="content-box padding-8 width-auto h-padding-16" name="patient_create">4</div>
                    <div class="content-box padding-8 width-auto h-padding-16">Pacientes creados</div>
                </div>
            </div> -->

        </div>




    </div>


</window>
<script src="<?= BASE_URL ?>js/adminMain.js?v=5" type="module"></script>