<window
    id="window-read"
    data-flip-id="animate"
    class="increased full-size-window"
    
    >
    <div class="simple-container padding-16">
        <md-icon-button onclick="togglePrettyWindow();"><md-icon>close</md-icon></md-icon-button>
    </div>
    <holder class="align-center justify-center">
        <span class="dm-sans headline-large">
            Escanea el código QR para asistir
        </span>
        <div class="content-box grow-1" id="qr-code-reader-container"></div>
    </holder>
    <style>
        /* #qr-code-reader-container video{ width:unset !important; height:100% !important;} */
    </style>
</window>