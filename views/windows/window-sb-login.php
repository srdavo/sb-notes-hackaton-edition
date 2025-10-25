<window 
    id="window-sb-login"
    class="increased box-shadow-none"
    data-flip-id="animate"
    >
    <div class="simple-container padding-16 b-padding-0">
        <md-icon-button onclick="toggleWindow(); resetFormSteps();">
            <md-icon>close</md-icon>
        </md-icon-button>
    </div>
    <holder>
        <form
            id="login-form"
            onsubmit="logIn(event)" 
            class="simple-container direction-column height-auto grow-1 overflow-hidden h-padding-4"
            >
            <div class="simple-container direction-column grow-1 width-100 height-100 align-center" data-form-step-1>
                <div class="simple-container justify-center grow-1 gap-24 direction-column width-100 max-width-600" >
                    <div class="simple-container direction-column">
                        <div class="sbcorp-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="16" viewBox="0 0 24 16" fill="none">
                                <rect y="0.696289" width="14.6076" height="14.6076" rx="7.30381" fill="var(--md-sys-color-on-background)"/>
                                <rect x="16.5786" y="0.696289" width="7.42162" height="14.6076" rx="3.71081" fill="var(--md-sys-color-on-background)"/>
                            </svg> 
                            Codemelon
                        </div>
                        <span class="display-small weight-600 top-margin-8 on-background-text bricolage">
                            Bienvenido(a)
                        </span>
                        <span class="body-medium outline-text">Inicia sesión para continuar</span>
                    </div>
                    <div class="simple-container direction-column position-relative" >
                        <label for="user-login-email" class="input-pretty-label headline-medium weight-500">Correo o Usuario</label>
                        <input 
                            name="user-email" 
                            placeholder="Escribe tu correo o usuario" 
                            class="pretty prepared"
                            id="user-login-email"
                        >
                        <md-filled-button type="button" onclick="validateFormStep1()" class="input-pretty-button">Continuar</md-filled-button>
                    </div>
                    <div class="simple-container gap-8 bottom-margin-64 justify-between">
                        <md-filled-tonal-button type="button" onclick="changeWindow('#window-sb-signup')" class="solid-light">Aún no tengo una cuenta</md-filled-tonal-button>
                        
                        <div class="simple-container overflow-hidden border-radius-64">
                            <!-- Sign In With Google button with HTML data attributes API -->
                            <div id="g_id_onload"
                                data-client_id="819722503345-qies2hv7hjl6ig525dtau8327qccj82a.apps.googleusercontent.com"
                                data-context="signin"
                                data-ux_mode="popup"
                                data-callback="handleCredentialResponse"
                                data-auto_prompt="false">
                            </div>

                            <div class="g_id_signin"
                                data-type="standard"
                                data-shape="pill"
                                data-theme="outline"
                                data-text="continue_with"
                                data-size="large"
                                data-logo_alignment="left">
                            </div>

                            <!-- Display the user's profile info -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="simple-container direction-column grow-1 width-100 height-100 align-center" data-form-step-2>
                <div class="simple-container justify-center grow-1 gap-8 direction-column width-100 max-width-600 bottom-margin-64" >

                    <div class="simple-container direction-column position-relative">
                        <label for="user-login-password" class="input-pretty-label headline-medium weight-500">Contraseña</label>

                        <input 
                            type="password" 
                            placeholder="Escribe tu contraseña" 
                            class="pretty prepared"
                            id="user-login-password"
                        >
                        <md-filled-button type="submit" class="input-pretty-button">Confirmar</md-filled-button>
                    </div>
                    
                </div>
            </div>
        </form>
        
    </holder>
</window>