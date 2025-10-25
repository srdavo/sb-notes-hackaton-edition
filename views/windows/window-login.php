<window
    id="window-login"
    class="increased on-background-text"
    data-flip-id="animate"
    >
    <div class="simple-container padding-16">
        <md-icon-button type="button" onclick="toggleWindow()"><md-icon>close</md-icon></md-icon-button>
    </div>
    <holder class="justify-center justify-center-0 align-center">

        <div class="simple-container direction-column gap-8 width-100 max-width-400">
            <div class="simple-container">
                <div class="simple-container align-center gap-4 dm-sans body-large weight-500 user-select-none">
                    <md-icon class="filled dynamic" aria-hidden="true">cognition</md-icon>
                    Melon Mind
                </div>
            </div>

            <span class="display-small dm-sans weight-600">Inicia sesión</span>

            <form class="simple-container direction-column gap-8 top-margin-16" autocomplete="off">
                <span class="label-normal outline-text left-margin-8 dm-sans">Correo</span>
                <input name="email" type="email" placeholder="Escribe tu correo">

                <div class="simple-container justify-between" style="align-items: flex-end">
                    <span class="label-normal outline-text left-margin-8 top-margin-8 dm-sans">Contraseña</span>
                    <span name="button-forgot-password" class="label-small outline-text cursor-pointer data-line background hover-outline flex-end top-margin-8 dm-sans"><md-ripple></md-ripple>Olvidé mi contraseña</span>
                </div>
                <input name="password" type="password" placeholder="Escoge una contraseña">

                <div class="simple-container direction-column top-margin-8 bottom-margin-64">
                    <button class="style-3 hidden primary-container on-primary-container-text"><md-ripple></md-ripple>Iniciar sesión</button>
                    <md-filled-button class="squared primary-primary" type="submit">Iniciar sesión</md-filled-button>

                    <div class="simple-container">
                        <label class="simple-container align-center left-margin-8 top-margin-16 bottom-margin-16">
                            <md-checkbox name="terms" touch-target="wrapper" style="min-width:18px;"></md-checkbox>
                            <span class="label-medium left-margin-8" style="max-width:280px">He leído y acepto la <a href="<?= BASE_URL ?>privacydocument" class="on-background-text">Política de Privacidad</a> y los <a href="<?= BASE_URL ?>termsdocument" class="on-background-text">Términos y Condiciones</a></span>
                        </label>
                    </div>

                    <div class="simple-container gap-4 justify-between gap-8 align-center flex-wrap top-margin-16">

                        <label class="simple-container align-center gap-4 dm-sans body-large">
                            <md-checkbox touch-target="wrapper" checked="true" name="remember_me"></md-checkbox>
                            <span>Recordarme</span>
                        </label>
    
                        <div class="fit-content overflow-hidden border-radius-64">
                            <!-- Sign In With Google button with HTML data attributes API -->
                            <div id="g_id_onload"
                                data-client_id="185908672520-h0h9p1ns8uroltg9k93vovmb174feco3.apps.googleusercontent.com"
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
                                data-size="medium"
                                data-logo_alignment="left">
                            </div>
    
                            <!-- Display the user's profile info -->
                        </div>
                    </div>
                </div>
            </form>


        </div>
        
    </holder>
</window>