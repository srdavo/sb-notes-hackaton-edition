import { SaveNote } from "./managers/SaveNote.js";

class Main {
    constructor() {

        this.noteComponents = {
            saveNote: new SaveNote(),
        }
        
        // Inicializar con una nota nueva vacía
        this.noteComponents.saveNote.init({
            id: null,
            note_name: 'Nueva nota',
            note_content: ''
        });


    }
}

export const main = new Main();