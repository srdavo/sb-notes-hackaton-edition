<window
    id="window-send-suggestion"
    data-flip-id="animate"
    class="on-background-text"
    >
    <div class="simple-container padding-16">
        <md-icon-button onclick="toggleWindow();">
            <md-icon>close</md-icon>
        </md-icon-button>
    </div>
    <holder class="gap-16">
        <div class="simple-container direction-column gap-8">
            <span class="display-small bricolage weight-600 line-height-1">Enviar sugerencia<br> o reportar error</span>
            <span class="body-large outline-text">
                Si ha encontrado algún error o tiene sugerencias para mejorar la aplicación, le agradecemos que nos lo comunique.
            </span>
        </div>
        <form onsubmit="sendSuggestion(event)" id="send-suggestion-form" class="simple-container direction-column gap-16">
            <md-outlined-text-field 
                type="textarea" 
                label="Escribe aquí tu sugerencia o reporte de error" 
                style="min-height:180px;"
                id="send-suggestion-suggestion"    
            ></md-outlined-text-field>
            <div class="simple-container justify-right">
                <md-filled-button>
                    <md-icon slot="icon">send</md-icon>
                    Enviar
                </md-filled-button>
            </div>
        </form>
    </holder>

</window>
