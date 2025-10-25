<window
    id="window-forgot-password"
    class="increased"
    >
    <holder class="align-center justify-center position-relative">

        <div data-step="1" active class="simple-container align-center direction-column width-100 max-width-400 gap-16">
    
            <md-icon class="pretty-minimal outline-text">lock_reset</md-icon>
            <span class="headline-large dm-sans weight-500 text-center">
                Restablecer contraseña
            </span>
    
            <form id="form-forgot-password" class="simple-container gap-16 direction-column width-100">
    
                <div class="simple-container direction-column gap-8">
                    <span class="label-normal outline-text dm-sans">Correo</span>
                    <input name="email" class="background outline-1 focus-primary" type="email" placeholder="Escribe tu correo"  >
                </div>

                <div class="simple-container justify-between">
                    <md-filled-tonal-button class="solid dm-sans" type="button" onclick="changeWindow('#window-login')">Cancelar</md-filled-tonal-button>
                    <md-filled-button class="primary-container dm-sans" trailing-icon type="submit"><md-icon slot="icon">arrow_forward</md-icon>Enviar código</md-filled-button>
                    <!-- <button class="style-7 primary-container on-primary-container-text">
                        Enviar código
                    </button> -->
                </div>
    
            </form>
        </div>

        <div data-step="2" class="simple-container align-center direction-column width-100 max-width-400 gap-16">
    
            <md-icon class="pretty-minimal outline-text">numbers</md-icon>
            <span class="headline-large dm-sans weight-500 text-center">
                Código de verificación
            </span>
            <span class="body-large dm-sans outline-text">
                Hemos enviado un código a <span name="container-email" class="primary-text"></span>. Por favor, ingrésalo a continuación para continuar con el restablecimiento de tu contraseña.
            </span>
    
            <form id="form-send-forgot-password-token" class="simple-container gap-16 direction-column width-100">
    
                <div class="simple-container direction-column gap-8">
                    <span class="label-normal outline-text dm-sans">Código</span>
                    <input name="token" class="background outline-1 focus-primary" type="text" placeholder="Escribe el código" maxlength="8">
                </div>

                <div class="simple-container justify-right">
                    <md-filled-button class="primary-container dm-sans" type="submit">Verificar</md-filled-button>

                </div>
    
            </form>
        </div>

        <div data-step="3" class="simple-container align-center direction-column width-100 max-width-400 gap-16">
    
            <md-icon class="pretty-minimal outline-text">password</md-icon>
            <span class="headline-large dm-sans weight-500 text-center">
                Establecer nueva contraseña
            </span>
            <span class="body-large dm-sans outline-text">
                Ingresa una nueva contraseña segura para tu cuenta.
                Asegúrate de que sea fácil de recordar para ti, pero difícil de adivinar para otros.
            </span>
    
            <form id="form-update-password" class="simple-container gap-16 direction-column width-100">
    
                <div class="simple-container direction-column gap-8">
                    <span class="label-normal outline-text dm-sans">Nueva contraseña</span>
                    <input name="password" class="background outline-1 focus-primary" type="password" placeholder="Escribe tu nueva contraseña" maxlength="200">
                </div>

                <div class="simple-container direction-column gap-8">
                    <span class="label-normal outline-text dm-sans">Confirmar contraseña</span>
                    <input name="repeat_password" class="background outline-1 focus-primary" type="password" placeholder="Repite la contraseña" maxlength="200">
                </div>

                <div class="simple-container justify-between">
                    <md-filled-tonal-button class="solid dm-sans" type="button" onclick="changeWindow('#window-login')">Cancelar</md-filled-tonal-button>
                    <md-filled-button class="primary-container dm-sans" type="submit">Verificar</md-filled-button>
                </div>
    
            </form>
        </div>

        <div data-step="4" class="simple-container align-center direction-column width-100 max-width-400 gap-16">
    
            <md-icon class="pretty-minimal outline-text">check_circle</md-icon>
            <span class="headline-large dm-sans weight-500 text-center text-wrap-pretty">
                Contraseña actualizada con éxito
            </span>
            <span class="body-large dm-sans outline-text text-center text-wrap-pretty">
                Tu contraseña ha sido restablecida correctamente.
                Ahora puedes iniciar sesión utilizando tus nuevas credenciales.
            </span>
    
            <div class="simple-container direction-column width-100">
                <md-filled-button class="squared primary-container dm-sans" type="button" onclick="changeWindow('#window-login')">Iniciar sesión</md-filled-button>

            </div>
      
        </div>

        <style>
            [data-step]:not([active]) {display: none;}
        </style>

    </holder>
</window>