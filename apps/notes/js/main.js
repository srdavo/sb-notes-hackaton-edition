import { SaveNote } from "./managers/SaveNote.js";
import { PrettyMenu } from "./components/PrettyMenu.js"

class Main {
    constructor() {

        new PrettyMenu({
            menu: document.getElementById("main-app-menu")
        })
        new PrettyMenu({
            menu: document.getElementById("new-note-menu")
        })

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