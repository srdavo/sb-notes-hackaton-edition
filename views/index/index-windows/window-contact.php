<window 
    id="window-contact" 
    data-flip-id="animate"
    class="increased semi-slim"
    >
    <div class="simple-container padding-16">
        <md-icon-button onclick="toggleWindow()"><md-icon>close</md-icon></md-icon-button>
    </div>
    <holder class="align-center">
        <form id="form-contact-us" onsubmit="" class="simple-container direction-column width-100 max-width-600 grow-1 gap-24 justify-center">

            <div class="simple-container direction-column width-100 user-select-none gap-8">
                <span class="display-small dm-sans weight-500 line-height-0-95 on-background-text">Contáctanos</span>
                <span class="body-large outline-text bottom-margin-8">
                    Nos pondremos en contacto contigo en menos de 24 horas
                </span>
            </div>

            <div class="simple-container direction-column gap-8">

                <div class="simple-container direction-column gap-8" name="minimum-data" id="create-patient-form-minimum-data">
                    <md-filled-text-field label="Nombre completo" name="name" role="presentation" inputmode="" type="text" autocomplete="off"></md-filled-text-field>
                    <md-filled-text-field label="Empresa" name="company" role="presentation" inputmode="" type="text" autocomplete="off"></md-filled-text-field>
                    <md-filled-text-field label="Teléfono" name="phone" role="presentation" inputmode="" type="tel" autocomplete="off"></md-filled-text-field>
                    <md-filled-text-field label="Correo" name="email" role="presentation" inputmode="" type="email" autocomplete="off"></md-filled-text-field>
                    <md-filled-text-field label="Mensaje" name="message" role="presentation" inputmode="" type="textarea" autocomplete="off" style="height:140px;"></md-filled-text-field>
                    
                </div>

            

                <div class="simple-container justify-right">
                    <md-filled-button role="presentation" value="" has-icon="">
                        <md-icon slot="icon" aria-hidden="true">send</md-icon>
                        <span data-text-content="">Enviar</span>
                    </md-filled-button>
                </div>

            </div>

            </form>
    </holder>
</window>