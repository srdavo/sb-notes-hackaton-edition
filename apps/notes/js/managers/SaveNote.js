import { TextEditor } from "./TextEditor.js";


export class SaveNote {
    constructor(config = {}) {
        
        this.API_URL = config.API_URL || 'back-end/controllers/notes.controller.php';
        this.section = config.window || document.getElementById("section-home");

        this.isInit = false;
        this.currentNoteId = null;
        this.currentNoteData = null;
        this.saveTimeout = null; // Para controlar el debounce del auto-guardado
        this.saveDelay = 1000; // Delay en milisegundos (1 segundo)
        this.textEditor = null; // Instancia del editor
        
        this.dom = {

        }

    }

    async init(noteData, origin){
        if(!noteData){
            console.error("SaveNote: No note data provided for initialization.");
            return;
        }

        this.currentNoteId = noteData.id || null;
        this.currentNoteData = noteData;

        if(!this.isInit){
            this.isInit = true;
            this.#setupEditor();
        }
    }

    #setupEditor() {
        // Crear instancia del TextEditor con auto-guardado
        this.textEditor = new TextEditor('#editor-container', {
            content: this.currentNoteData?.note_content || '',
            onUpdate: ({ editor }) => {
                // Obtener el contenido HTML del editor
                const content = editor.getHTML();
                // Activar auto-guardado con debounce
                this.#autoSave(content);
            }
        });
    }

    #autoSave(content) {
        // Limpiar el timeout anterior si existe
        if (this.saveTimeout) {
            clearTimeout(this.saveTimeout);
        }
        
        // Crear nuevo timeout
        this.saveTimeout = setTimeout(() => {
            this.saveNote({ content });
        }, this.saveDelay);
    }

    async saveNote(props){
        try {
            const { content } = props;
            
            // Si tenemos un noteId, actualizamos la nota existente
            if (this.currentNoteId) {
                console.log('Actualizando nota con ID:', this.currentNoteId);
                const result = await request({
                    API_URL: this.API_URL,
                    op: 'note_update',
                    id: this.currentNoteId,
                    note_content: content,
                    throwOnError: true,
                });
                console.log('Nota actualizada automáticamente:', result);
            } else {
                // Si no tenemos noteId, creamos una nueva nota
                console.log('Creando nueva nota...');
                const result = await request({
                    API_URL: this.API_URL,
                    op: 'note_create',
                    note_name: this.currentNoteData?.note_name || 'Nueva nota',
                    note_content: content,
                    throwOnError: true,
                });
                
                // Guardamos el ID de la nota recién creada
                if (result?.note_id) {
                    this.currentNoteId = result.note_id;
                    console.log('Nota creada con ID:', this.currentNoteId);
                } else {
                    console.error('No se pudo obtener el note_id de la respuesta:', result);
                }
            }
            
        } catch (error) {
            console.error('Error al guardar la nota:', error.message || error);
            console.error('Detalles del error:', error);
            // Opcionalmente puedes mostrar un mensaje al usuario
            // message(`Error al guardar: ${error.message}`, 'error');
        }
    }
}