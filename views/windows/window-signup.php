<window
    id="window-signup"
    class="increased on-background-text"
    data-flip-id="animate"
    >
    <div class="simple-container padding-16">
        <md-icon-button type="button" onclick="toggleWindow()"><md-icon>close</md-icon></md-icon-button>
    </div>
    <holder class="justify-center justify-center-0 align-center">

        <div class="simple-container direction-column gap-8 width-100 max-width-400">
            <div class="simple-container">
                <!-- <div class="codemelon-box">
                    <md-icon class="filled" aria-hidden="true">cognition</md-icon>
                    Melon Mind
                </div> -->
                <div class="simple-container align-center gap-4 dm-sans body-large weight-500 user-select-none">
                    <md-icon class="filled dynamic" aria-hidden="true">cognition</md-icon>
                    Melon Mind
                </div>
            </div>

            <span class="display-small dm-sans weight-600">Crea tu cuenta</span>

            <form class="simple-container direction-column gap-8 top-margin-16" autocomplete="off">
                <span class="label-normal outline-text left-margin-8 dm-sans">Correo</span>
                <input name="email" type="email" placeholder="Escribe tu correo">

                <span class="label-normal outline-text left-margin-8 top-margin-8 dm-sans">Contraseña</span>
                <input name="password" type="password" placeholder="Escoge una contraseña">
                <input name="repeat-password" type="password" placeholder="Repite tu contraseña">

                <div class="simple-container direction-column top-margin-8 bottom-margin-64">
                    <!-- <button class="style-3 hidden primary-container on-primary-container-text"><md-ripple></md-ripple>Crear cuenta</button> -->
                    <md-filled-button class="squared primary-primary" type="submit" id="crear-cuenta">Crear cuenta</md-filled-button>


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
                    <!-- <div class="simple-container top-margin-8">
                        <button class="style-2 outline-light-1 simple-container align-center gap-4" type="button">
                            <md-ripple></md-ripple>
                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="16" height="16" viewBox="0 0 32 32">
                                <path fill="var(--md-sys-color-on-background)" d="M 16.003906 14.0625 L 16.003906 18.265625 L 21.992188 18.265625 C 21.210938 20.8125 19.082031 22.636719 16.003906 22.636719 C 12.339844 22.636719 9.367188 19.664063 9.367188 16 C 9.367188 12.335938 12.335938 9.363281 16.003906 9.363281 C 17.652344 9.363281 19.15625 9.96875 20.316406 10.964844 L 23.410156 7.867188 C 21.457031 6.085938 18.855469 5 16.003906 5 C 9.925781 5 5 9.925781 5 16 C 5 22.074219 9.925781 27 16.003906 27 C 25.238281 27 27.277344 18.363281 26.371094 14.078125 Z"></path>
                            </svg>
                            Continuar con Google
                        </button>
                    </div> -->
                </div>
            </form>


        </div>
        
    </holder>
</window>