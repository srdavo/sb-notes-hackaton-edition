<md-dialog id="dialog-move-to-trash-confirmation">
  <div slot="headline">Mover a papelera</div>
  <md-icon slot="icon" aria-hidden="true">delete</md-icon>
  <form id="form-dialog-move-to-trash-confirmation" slot="content" method="dialog">
    ¿Estás seguro(a) de que quieres mover <span name="item-name"></span> a la papelera?<br>
  </form>
  <div slot="actions">
    <md-text-button form="form-dialog-move-to-trash-confirmation" value="cancel" role="presentation">Cancelar</md-text-button>
    <md-filled-tonal-button name="button-confirm-move-to-trash" class="delete" value="confirm">
      <md-icon slot="icon" aria-hidden="true">delete</md-icon>
      Mover a papelera
    </md-filled-tonal-button>
  </div>
</md-dialog>


<md-dialog id="dialog-recover-from-trash-confirmation">
  <div slot="headline">Recuperar</div>
  <md-icon slot="icon" aria-hidden="true">restart_alt</md-icon>
  <form id="form-dialog-recover-from-trash-confirmation" slot="content" method="dialog">
    ¿Estás seguro(a) de que quieres recuperar <span name="item-name"></span>?<br>
  </form>
  <div slot="actions">
    <md-text-button form="form-dialog-recover-from-trash-confirmation" value="cancel" role="presentation">Cancelar</md-text-button>
    <md-filled-button name="button-confirm-recover-from-trash" class="" value="confirm">
      <md-icon slot="icon" aria-hidden="true">restart_alt</md-icon>
      Recuperar
    </md-filled-button>
  </div>
</md-dialog>

<md-dialog id="dialog-delete-forever-confirmation" type="alert">
  <div slot="headline">Eliminar permanentemente</div>
  <md-icon slot="icon" aria-hidden="true">delete_forever</md-icon>
  <form id="form-dialog-delete-forever-confirmation" slot="content" method="dialog">
    ¿Estás seguro(a) de que quieres <span class="error-text weight-600">eliminar permanentemente</span> <span name="item-name"></span>?<br>
    Esta acción <span class="error-text weight-600">no se puede deshacer</span>.
  </form>
  <div slot="actions" class="flex-wrap">
    <md-text-button form="form-dialog-delete-forever-confirmation" value="cancel" role="presentation">Cancelar</md-text-button>
    <md-filled-tonal-button name="button-confirm-delete-forever" class="delete" value="confirm">
      <md-icon slot="icon" aria-hidden="true">delete_forever</md-icon>
      Eliminar permanentemente
    </md-filled-tonal-button>
  </div>
</md-dialog>

<md-dialog id="dialog-appt-data" class="width-100 max-width-800-m-24 ">
  <div slot="headline">
    <md-icon-button form="form-dialog-appt-data" value="cancel"><md-icon>close</md-icon></md-icon-button>
    <span slot="headline">Cita</span>
  </div>
  <form id="form-dialog-appt-data" slot="content" method="dialog" class="simple-container direction-column gap-16 on-background-text">
    <div class="simple-container gap-16 flex-wrap">

      <!-- name column -->
      <div class="content-box light-color border-radius-16 padding-16 gap-8">
        <span class="label-normal outline-text">Paciente</span>
        <div class="simple-container gap-8">
          <span class="body-large data-line hover-outline cursor-pointer" name="patient-name"><span class="outline-text"><i>Nombre del paciente</i></span></span>
          <!-- <span class="data-line body-large simple-container align-center cursor-pointer light-color"><md-ripple></md-ripple><md-icon class="dynamic outline-text">arrow_outward</md-icon></span> -->
        </div>
      </div>

      <!-- second row column 1 -->
      <div class="simple-container direction-column gap-8 grow-1 basis-normal">

        <span class="label-normal outline-text left-margin-8">Fecha y hora</span>
        <div class="content-box border-radius-16 padding-16 gap-4">
          <span class="label-normal outline-text user-select-none">Fecha de la cita</span>
          <span class="body-large" name="appt-date">...</span>
        </div>
        <div class="content-box border-radius-16 padding-16 gap-4">
          <span class="label-normal outline-text user-select-none">Hora de la cita</span>
          <span class="body-large" name="appt-time">...</span>
        </div>

      </div>

      <!-- second row column 2 -->
      <div class="simple-container direction-column gap-8 grow-1 basis-normal">
        <span class="label-normal outline-text left-margin-8">Datos generales</span>
        <div class="content-box border-radius-16 padding-16 gap-4">
          <span class="label-normal outline-text user-select-none">Estado de la cita</span>
          <span class="body-large" name="appt-status">...</span>
        </div>
        <div class="content-box border-radius-16 padding-16 gap-4">
          <span class="label-normal outline-text user-select-none">Nota de la cita</span>
          <span class="body-large" name="appt-concept">...</span>
        </div>
      </div>
    </div>

    <div class="simple-container gap-16 flex-wrap">

      <div class="simple-container direction-column gap-8 grow-1 basis-normal">
        <span class="label-normal outline-text left-margin-8">Finanzas</span>
        <div class="content-box border-radius-16 padding-16 gap-4">
          <span class="label-normal outline-text user-select-none">Cobro por cita</span>
          <span class="body-large" name="appt-price">...</span>
        </div>
        <div class="content-box border-radius-16 padding-16 gap-4">
          <span class="label-normal outline-text user-select-none">Estado del pago</span>
          <span class="body-large" name="appt-payment-status">...</span>
        </div>
      </div>

      <div class="simple-container direction-column gap-8 grow-1 basis-normal">
        <span class="label-normal outline-text left-margin-8">Modalidad</span>
        <div class="content-box border-radius-16 padding-16 gap-4">
          <span class="label-normal outline-text user-select-none">Modalidad</span>
          <span class="body-large" name="appt-mode">...</span>
        </div>
      </div>

    </div>


  </form>
  <div slot="actions" class="flex-wrap">
    <md-filled-tonal-button name="button-delete-forever" class="delete"><md-icon slot="icon">delete_forever</md-icon>Eliminar permanentemente</md-filled-tonal-button>
    <md-filled-button name="button-recover" ><md-icon slot="icon">restart_alt</md-icon>Recuperar cita</md-filled-button>
  </div>
</md-dialog>

<md-dialog id="dialog-patient-profile" class="width-100 max-width-800-m-24" >
  <div slot="headline">
    <md-icon-button form="form-dialog-patient-profile" value="cancel"><md-icon>close</md-icon></md-icon-button>
    <span slot="headline">Paciente</span>
  </div>
  <form id="form-dialog-patient-profile" slot="content" method="dialog" class="simple-container direction-column on-background-text gap-8">
    
    <!-- row 1 -->
    <div class="content-box light-color border-radius-16 padding-16 gap-8">
      <span class="label-normal outline-text">Paciente</span>
      <div class="simple-container gap-8 flex-wrap">
        <span class="body-large data-line hover-outline cursor-pointer" name="patient-name"><span class="outline-text"><i>Nombre del paciente</i></span></span>
        <span class="body-large data-line hover-outline cursor-pointer" name="patient-gender"><span class="outline-text"><i>...</i></span></span>
        <span class="body-large data-line hover-outline cursor-pointer" name="patient-age"><span class="outline-text"><i>...</i></span></span>
        <span class="body-large data-line hover-outline cursor-pointer" name="patient-birthdate"><span class="outline-text"><i>...</i></span></span>
      </div>
    </div>
    <!-- row 2 -->
    <div class="content-box border-radius-16 padding-16 gap-8">
      <span class="label-normal outline-text user-select-none weight-500">Estado del paciente</span>
      <span class="body-large" name="patient-status">...</span>
    </div>
    <!-- row 3 -->
    <div class="content-box border-radius-16 padding-16 gap-8">
      <span class="label-normal outline-text user-select-none weight-500">Contacto</span>
      <span class="body-large" name="patient-contact_phone">...</span>
      <span class="body-large" name="patient-contact_email">...</span>
    </div>
    <!-- row 4 -->
    <div class="simple-container gap-8 flex-wrap">
      <div class="content-box border-radius-16 padding-16 gap-4 grow-1 basis-normal">
        <span class="label-normal outline-text user-select-none">Escuela</span>
        <span class="body-large" name="patient-school">...</span>
      </div>
      <div class="content-box border-radius-16 padding-16 gap-4 grow-1 basis-normal">
        <span class="label-normal outline-text user-select-none">Grado escolar</span>
        <span class="body-large" name="patient-school_grade">...</span>
      </div>
    </div>
    <!-- row 5 -->
    <div class="simple-container gap-8 flex-wrap">
      <div class="content-box border-radius-16 padding-16 gap-4 grow-1 basis-normal">
        <span class="label-normal outline-text user-select-none">Precio por cita</span>
        <span class="body-large" name="patient-appt_price">...</span>
      </div>
    </div>
    <!-- row 6 -->
    <div class="simple-container direction-column">
      <md-filled-text-field
        disabled
        label="Notas del paciente" 
        type="textarea"
        name="patient-notes"
      ></md-filled-text-field>
    </div>
  </form>
  <div slot="actions" class="flex-wrap">
    <md-filled-tonal-button name="button-delete-forever" class="delete"><md-icon slot="icon">delete_forever</md-icon>Eliminar permanentemente</md-filled-tonal-button>
    <md-filled-button name="button-recover" ><md-icon slot="icon">restart_alt</md-icon>Recuperar paciente</md-filled-button>
  </div>
</md-dialog>



<md-dialog id="dialog-appt-created-message">
  <div slot="headline">Cita agendada</div>
  <md-icon slot="icon" class="filled" aria-hidden="true">verified</md-icon>
  <form id="form-dialog-appt-created-message" style="display:none;" slot="content" method="dialog">
  </form>
  <div slot="actions" class="flex-wrap">
    <md-text-button form="form-dialog-appt-created-message" data-flip-id="animate" onclick="ApptsManager.openCreateApptWindow()"><md-icon slot="icon">calendar_add_on</md-icon>Agendar otra cita</md-text-button>
    <md-filled-button form="form-dialog-appt-created-message">Aceptar</md-filled-button>
    <!-- <md-filled-tonal-button name="button-delete-forever" class="delete"><md-icon slot="icon">delete_forever</md-icon>Eliminar permanentemente</md-filled-tonal-button> -->
    <!-- <md-filled-button name="button-recover" ><md-icon slot="icon">restart_alt</md-icon>Recuperar cita</md-filled-button> -->
  </div>
</md-dialog>

<md-dialog id="dialog-appt-taken">
  <div slot="headline">Ya hay una cita</div>
  <md-icon slot="icon" aria-hidden="true" class="filled">warning</md-icon>
  <form id="form-dialog-appt-taken" slot="content" method="dialog">
    Ya existe una cita en la Fecha y Hora seleccionada<br>
    ¿Deseas continar?
  </form>
  <div slot="actions">
    <md-text-button form="form-dialog-appt-taken" value="cancel" role="presentation">Cancelar</md-text-button>
    <md-filled-tonal-button name="button-confirm-create-appt" form="form-dialog-appt-taken" onclick="" class="delete" value="confirm">
      Continuar
    </md-filled-tonal-button>
  </div>
</md-dialog>