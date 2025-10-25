<window 
    id="window-sb-signup"
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
            id="signup-form"
            onsubmit="signUp(event)" 
            class="simple-container direction-column height-auto grow-1 overflow-hidden h-padding-4"
            >
            <div class="simple-container direction-column grow-1 width-100 height-100 align-center" data-form-step-1>
                <div class="simple-container justify-center grow-1 gap-24 direction-column width-100 max-width-600" >
                    <div class="simple-container direction-column gap-8">
                        <div class="sbcorp-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="16" viewBox="0 0 24 16" fill="none">
                                <rect y="0.696289" width="14.6076" height="14.6076" rx="7.30381" fill="var(--md-sys-color-on-background)"/>
                                <rect x="16.5786" y="0.696289" width="7.42162" height="14.6076" rx="3.71081" fill="var(--md-sys-color-on-background)"/>
                            </svg> 
                            Codemelon
                        </div>
                        <span class="display-small bricolage weight-600 on-background-text" style="white-space:nowrap">
                            Crea tu cuenta
                        </span>
                    </div>
                    <div class="simple-container direction-column position-relative" >
                        <label for="user-login-email" class="input-pretty-label headline-medium weight-500">Correo</label>
                        <input 
                            name="user-email" 
                            placeholder="Escribe tu correo" 
                            class="pretty prepared"
                            id="user-signup-email"
                        >
                        <md-filled-button type="button" onclick="validateFormStep1()" class="input-pretty-button">Continuar</md-filled-button>
                    </div>
                    <div class="simple-container bottom-margin-64 justify-between">
                        <md-filled-tonal-button type="button" onclick="changeWindow('#window-sb-login')" class="solid-light">Ya tengo una cuenta</md-filled-tonal-button>

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
                            <div class="pro-data hidden"></div>
                        </div>
                        
                    </div>
                </div>
            </div>

            <div class="simple-container direction-column grow-1 width-100 height-100 align-center" data-form-step-2>
                <div class="simple-container justify-center grow-1 gap-8 direction-column width-100 max-width-600 bottom-margin-64" >
                    <span class="display-small bricolage weight-500 on-background-text" >
                        Configura tu contraseña
                    </span>
                    <div class="simple-container direction-column position-relative">
                        <input 
                            type="password" 
                            placeholder="Escribe una contraseña" 
                            class="pretty"
                            id="user-signup-password"
                        >
                    </div>

                    <div class="simple-container direction-column position-relative">

                        <input 
                            type="password" 
                            placeholder="Confirma tu contraseña" 
                            class="pretty bottom-prepared"
                            id="user-signup-password-repeat"
                        >
                        <md-filled-button type="submit" class="input-pretty-button">Confirmar</md-filled-button>
                    </div>
                    
                </div>
            </div>
        </form>
        
    </holder>
</window>


