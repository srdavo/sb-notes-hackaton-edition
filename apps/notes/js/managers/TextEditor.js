import { Editor } from 'https://esm.sh/@tiptap/core'
import StarterKit from 'https://esm.sh/@tiptap/starter-kit'
import Placeholder from 'https://esm.sh/@tiptap/extension-placeholder'

export class TextEditor {
    
    // Propiedades de la instancia
    editor = null;
    buttons = [];
    container = null;
    menuElement = null;

    /**
     * Inicializa una nueva instancia del editor en el elemento especificado.
     * @param {string} element - El selector CSS para el contenedor del editor.
     * @param {object} options - Opciones de configuración.
     * @param {string} [options.content=""] - Contenido HTML inicial.
     * @param {function} [options.onUpdate] - Callback que se ejecuta en cada actualización.
     * @param {string} [options.customMenuContainer] - Un selector CSS para un contenedor de menú externo.
     */
    constructor(element, options = {}) {
        if (!element) {
            console.error("TextEditor: No se proporcionó un selector de elemento.");
            return;
        }

        this.container = document.querySelector(element);
        if (!this.container) {
            console.error(`TextEditor: Elemento no encontrado para el selector "${element}".`);
            return;
        }

        // Limpiar el contenedor
        while (this.container.firstChild) {
            this.container.removeChild(this.container.firstChild);
        }

        const editorContent = document.createElement('div');
        editorContent.className = "text-editor";

        // Guardar el callback original del usuario
        const onUpdateCallback = options.onUpdate || (() => {});

        this.editor = new Editor({
            element: editorContent,
            content: options.content || "",
            extensions: [
                StarterKit,
                Placeholder.configure({
                    placeholder: 'Escribe aquí...',
                }),
            ],
            autofocus: true,
            onUpdate: (props) => {
                onUpdateCallback(props); // Ejecutar el callback del usuario
                this.#updateAllButtons(); // Actualizar nuestros botones
            },
            onSelectionUpdate: () => {
                this.#updateAllButtons(); // Actualizar botones en cambio de selección
            },
        });

        // Construir el menú
        this.menuElement = this.#buildMenu();

        // Colocar el menú (ya sea en un contenedor personalizado o en el principal)
        if (options && options.customMenuContainer) {
            const customMenuContainer = document.querySelector(`${options.customMenuContainer}`);
            if (customMenuContainer) {
                customMenuContainer.innerHTML = ""; // Limpiar contenedor personalizado
                customMenuContainer.appendChild(this.menuElement);
            } else {
                this.container.appendChild(this.menuElement);
            }
        } else {
            this.container.appendChild(this.menuElement);
        }

        // Agregar el contenido del editor
        this.container.appendChild(editorContent);
    }

    /**
     * Construye el DOM del menú y define la configuración de los botones.
     * @private
     */
    #buildMenu() {
        const menuGroupHeadings = [
            { icon: 'subject', label: 'Texto normal', command: () => this.editor.chain().focus().setParagraph().run(), isActive: () => this.editor.isActive('paragraph') },
            ...[1, 2, 3, 4].map(level => ({
                icon: `format_H${level}`, label: `Encabezado ${level}`,
                command: () => this.editor.chain().focus().toggleHeading({ level }).run(),
                isActive: () => this.editor.isActive('heading', { level })
            })),
        ];

        this.buttons = [
            { type: 'menu', group: menuGroupHeadings },
            { icon: 'format_bold', label: 'Bold', command: () => this.editor.chain().focus().toggleBold().run(), isActive: () => this.editor.isActive('bold') },
            { icon: 'format_italic', label: 'Italic', command: () => this.editor.chain().focus().toggleItalic().run(), isActive: () => this.editor.isActive('italic') },
            { icon: 'strikethrough_s', label: 'Strike', command: () => this.editor.chain().focus().toggleStrike().run(), isActive: () => this.editor.isActive('strike') },
            { icon: 'format_list_bulleted', label: 'Bullet list', command: () => this.editor.chain().focus().toggleBulletList().run(), isActive: () => this.editor.isActive('bulletList') },
            { icon: 'format_list_numbered', label: 'Ordered list', command: () => this.editor.chain().focus().toggleOrderedList().run(), isActive: () => this.editor.isActive('orderedList') },
            { icon: 'format_quote', label: 'Blockquote', command: () => this.editor.chain().focus().toggleBlockquote().run(), isActive: () => this.editor.isActive('blockquote') },
            { icon: 'horizontal_rule', label: 'Horizontal rule', command: () => this.editor.chain().focus().setHorizontalRule().run() },
            { type: 'separator' },
            { icon: 'undo', label: 'Undo', command: () => this.editor.chain().focus().undo().run(), canRun: () => this.editor.can().chain().focus().undo().run() },
            { icon: 'redo', label: 'Redo', command: () => this.editor.chain().focus().redo().run(), canRun: () => this.editor.can().chain().focus().redo().run() },
        ];

        const menu = document.createElement('div');
        menu.className = "simple-container flex-wrap gap-4";

        const fragment = document.createDocumentFragment();
        const buttonElements = this.#buildMenuButtons();
        buttonElements.forEach(button => fragment.appendChild(button));
        menu.appendChild(fragment);

        return menu;
    }

    /**
     * Crea los elementos DOM para cada botón del menú.
     * @private
     */
    #buildMenuButtons() {
        if (!this.buttons || this.buttons.length === 0) return [];

        const buttonElements = [];

        this.buttons.forEach(button => {
            if (button.type === 'menu') {
                const menuWrapper = document.createElement("div");
                menuWrapper.className = "position-relative";
                menuWrapper.innerHTML = `
                    <md-filled-select class='style-7 style-modern'>
                        ${button.group.map(subButton =>
                            `<md-select-option value="${subButton.label}">${subButton.label}</md-select-option>`
                        ).join("")}
                    </md-filled-select>
                `;
                
                menuWrapper.querySelector("md-filled-select").selectedIndex = 0;

                menuWrapper.querySelectorAll("md-select-option").forEach(menuItem => {
                    menuItem.addEventListener("click", () => {
                        const subButton = button.group.find(sub => sub.label === menuItem.getAttribute("value"));
                        if (subButton) {
                            subButton.command();
                            this.#updateAllButtons(); // Actualizar estado
                        }
                    });
                });

                buttonElements.push(menuWrapper);
                button._element = menuWrapper.querySelector("md-filled-select"); // Guardar referencia al elemento
                return;
            }

            if (button.type === 'separator') {
                const separator = document.createElement("div");
                separator.className = "simple-container grow-1";
                buttonElements.push(separator);
                return;
            }

            const buttonElement = document.createElement("button");
            buttonElement.className = "style-7 for-icon transparent on-background-text";
            buttonElement.innerHTML = `
                <md-ripple></md-ripple>
                <md-icon>${(button.icon ?? button.label)}</md-icon>
            `;
            buttonElement.setAttribute("title", button.label);

            buttonElements.push(buttonElement);
            button._element = buttonElement; // Guardar referencia al elemento

            buttonElement.addEventListener("click", () => {
                button.command();
                this.#updateAllButtons(); // Actualizar estado
            });
        });

        return buttonElements;
    }

    /**
     * Actualiza el estado (activo/deshabilitado) de todos los botones del menú.
     * @private
     */
    #updateAllButtons() {
        if (!this.buttons || this.buttons.length === 0) return false;

        this.buttons.forEach(button => {
            if (button.type === "menu" && button.group) {
                const selectedOption = button.group.find(subButton => subButton.isActive && subButton.isActive());
                if (selectedOption && button._element) {
                    button._element.value = selectedOption.label;
                }
            }

            if (button._element && button.isActive) {
                if (button.isActive()) {
                    button._element.setAttribute("active", "");
                } else {
                    button._element.removeAttribute("active");
                }
            }
            if (button._element && button.canRun) {
                button._element.disabled = !button.canRun();
            }
        });
    }

    // --- Métodos Públicos ---

    /**
     * Obtiene el contenido actual del editor como HTML.
     * @returns {string}
     */
    getContentHTML() {
        return this.editor ? this.editor.getHTML() : "";
    }

    /**
     * Obtiene el contenido actual del editor como JSON.
     * @returns {object}
     */
    getContentJSON() {
        return this.editor ? this.editor.getJSON() : {};
    }

    /**
     * Destruye la instancia del editor y limpia el contenedor.
     */
    destroy() {
        if (this.editor) {
            this.editor.destroy();
            this.editor = null;
        }
        if (this.container) {
            this.container.innerHTML = "";
        }
        this.buttons = [];
        this.container = null;
        this.menuElement = null;
    }

    // --- Método Estático ---

    /**
     * Convierte una cadena de contenido (como JSON o HTML) a HTML sin crear una instancia completa.
     * @param {object} options
     * @param {string} [options.content=""] - Contenido a convertir.
     * @returns {string}
     */
    static getHTML(options = {}) {
        const editor = new Editor({
            content: options.content || "",
            extensions: [StarterKit]
        });
        const html = editor.getHTML();
        editor.destroy();
        return html;
    }
}