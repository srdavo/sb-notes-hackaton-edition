<section id="section-home" active class="direction-row padding-16 ">


    
    <div class="simple-container direction-column grow-1 basis-large" style="max-width:100%">

        <?php
            include_once '../notes/views/sections/section-todo.php'
        ?>

    </div>


    <script>
        document.getElementById("section-todo").style.display = "flex";
        document.getElementById("section-todo").style.padding = "0";
        document.getElementById("section-todo").querySelector("md-text-button").remove();
    </script>

    <div
        data-sub-section
        active
        id="main-chat-container"
        style="box-shadow:none; z-index: 2;"
        class="simple-container padding-1 background padding-16 border-radius-16 justify-center basis-large outline-light-1"
        data-flip-id="animate"
        >


        <!-- Chat -->
        <div  class="simple-container direction-column width-100 gap-24 padding-0">
            
            <div class="simple-container grow-1 direction-column parent-chat-container position-relative">

                <div class="simple-container z-index-1" style="position:fixed; top:16px;">
                    <button onclick="toggleSubSection('#main-chat-container')" class="style-7 padding-16 surface on-background-text"><md-ripple></md-ripple><md-icon>close</md-icon></button>
                </div>

                <div class="simple-container grow-1 chat-container position-relative" data-chat-container>
                    <span class="headline-medium dm-sans outline-text top-margin-64 message-container">Hola</span>
                    <span class="display-medium dm-sans weight-600 message-container bottom-margin-64">¿Qué quieres?</span>
                    <!-- <div class="message-container">
                        <div class="message-buble">
                            <span class="message-text">Hola, ¿en qué puedo ayudarte?</span>
                        </div>
                    </div> -->

            
                </div>

            </div>
            <form class="chat-send-container" style="pointer-events: none;" data-chat-form>

                <div class="simple-container grow-1 direction-column">
                    <input class="chat-input" name="message" placeholder="Escribe tu mensaje aquí..." maxlength="1000" autocomplete="off">
                </div>

                <button type="button" name="button-voice" class="button-send-message primary-text" data-flip-id="animate">
                    <md-ripple></md-ripple>
                    <md-icon class="filled">mic</md-icon>
                </button>

                <button type="submit" class="button-send-message primary-text" data-flip-id="animate">
                    <md-ripple></md-ripple>
                    <md-icon class="filled">send</md-icon>
                </button>
            
            </form>

        </div>

    </div>

    





    




</section>

<md-dialog id="dialog-new-chat-confirmation">
  <div slot="headline" class="dm-sans display-small weight-500">Nuevo chat</div>
  <md-icon slot="icon" aria-hidden="true" class="pretty-minimal">add_comment</md-icon>
  <form id="form-dialog-new-chat-confirmation" slot="content" method="dialog" class="dm-sans body-large" style="max-width:320px;">
    Al iniciar un nuevo chat, se perderá la conversación actual. ¿Estás seguro de que deseas continuar?
  </form>
  <div slot="actions">
    <md-text-button form="form-dialog-new-chat-confirmation" value="cancel">Cancelar</md-text-button>
    <md-filled-button name="button-new-chat" trailing-icon onclick="toggleDialog()">
      <md-icon slot="icon" class="filled">arrow_forward</md-icon>
      Continuar
    </md-filled-button>
  </div>
</md-dialog>

<style>
    /* * {
        outline: 1px solid rgba(0, 0, 0, 0.1);
    } */



</style>