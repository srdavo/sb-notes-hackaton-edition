
(function(){
    let adminPanel = document.querySelector("#window-admin-panel");
    let emailUsers = [];
    document.addEventListener('DOMContentLoaded', () => {
        // Se le asigna las funciones de las funciones Email a los botones
        const btnSendEmail = document.getElementById('sendEmail')
        btnSendEmail.onclick = () => {
            if(!checkEmpty("#admin-panel-form-send-user-email", "input")){return;}

            if(verifyContentEmail() && emailUsers.length) {
                const EmailContent = getEmailContent();
                sendEmail(EmailContent.header, EmailContent.content, emailUsers);
            }else {
                message("rellena todos los campos")
            }
            

        }

        const btnSendEmailAllUsers = document.getElementById('sendEmailAllUsers')
        btnSendEmailAllUsers.ondblclick = () => {
            if(verifyContentEmail()) {
                const EmailContent = getEmailContent();
                sendEmailAllUsers(EmailContent.header, EmailContent.content);
            }else {
                // console.log('Completa los campos')
            }
        }


        document.getElementById('email-options').addEventListener('change', (e) => {
            // Selección de los elementos que se mostrarán
            const option1 = document.getElementById('emailOption1');
            const option2 = document.getElementById('emailOption2');
            const emailLabel = document.getElementById('Email-label');
            // Ocultar todos los divs
            option1.classList.add('hidden');
            option2.classList.add('hidden');
    
            // Mostrar el div correspondiente a la selección
            if (e.target.value == "1") {
                option1.classList.remove('hidden');
                emailLabel.textContent = "Enviar a usarios"
            } else if (e.target.value == "2") {
                option2.classList.remove('hidden');
                emailLabel.textContent = "-- Enviar a TODOS LOS USUARIOS -- "

            }
        });

    });

    async function syncAdminPanel(){
        // users
        buildUsersTable();
        // access
        buildPageAccessTable();
        // suggestions
        buildSuggestionsTable();

    }

    window.AdminPanel = {
        syncAdminPanel,
        buildUsersTable,
        buildPageAccessTable,
        buildSuggestionsTable
    }

    // Users
    async function getUsers(page = 0){
        const data = {
            op: "get_users",
            page:page
        }
        const url = `${BASE_URL}back-end/controllers/admin.controller.php`;
        try{
            const response = await fetch(url, {
                method: 'POST',
                body: JSON.stringify(data),
                headers: { 'Content-Type': 'application/json'}
            });
            if (response.ok) {
                const result = await response.json();
                if(result.success){ 
                    return result;
                } else { 
                    message(`Hubo un error: ${result.message}`, "error"); 
                }
            } else {
                message("Hubo un error en la solicitud", "error");
            }
        } catch (error) {
            message("Error: " + error.message, "error");
        }
        return false;
    }
    async function buildUsersTable(page = 0){
        const result = await getUsers(page);
        if(!result) return false;
        const tableContainer = adminPanel.querySelector("#response-users-table");
        emptyTableIndicator = tableContainer.nextElementSibling;
        emptyTableIndicator = "";

        if(!result.data || result.data.length === 0){
            emptyTableIndicator.innerHTML = `
                <div class="content-box on-background-text align-center info-table-empty">
                    <md-icon class="pretty medium" aria-hidden="true">sentiment_content</md-icon>
                    <span class="headline-small">No hay registros</span>
                </div>
            `;
            return false;
        }


        tableContainer.innerHTML = `
            <tr>
                <td>Id</td>
                <td></td>
                <td>Nombre</td>
                <td>Correo</td>
                <td>Token</td>
                <td>Google Id</td>
                <td>Nivel de permisos</td>
                <td>Fecha de creación</td>
            </tr>
            ${result.data.map(user => {
                googleId = user.google_id ? user.google_id : "-";
                profilePicture = user.profile_picture ? `<span class='simple-container overflow-hidden border-radius-64' style='width:24px;'><img class='width-100' src='${user.profile_picture}'></span>` : `<span class='simple-container outline-variant-text overflow-hidden border-radius-64' style='width:24px;'><md-icon class='filled'>account_circle</md-icon></span>` 
                permissions = (user.permissions == "7") ? "<span class='data-line primary-text'>Administrador</span>" : "<span class='data-line'>Usuario</span>";

                return `
                    <tr>                       
                        <td>${user.user_id}</td>
                        <td>${profilePicture}</td>
                        <td>${user.name}</td>
                        <td>${user.email}</td>
                        <td>${user.user_token}</td>
                        <td>${googleId}</td>
                        <td>${permissions}</td>
                        <td>${formatDateTime(user.creation_datetime)}</td>
                    </tr>
                `;
            }).join("")}
        `;
        displayTotalUsers(result.total_rows);
        buildUsersTablePagination(result.total_rows, result.limit, page);
    }
    function buildUsersTablePagination(totalRows, limit, currentPage = 0){
        const container = adminPanel.querySelector("#pagination-users-table");
        const pageCount = Math.ceil(totalRows / limit);
        if(pageCount <= 1){container.innerHTML = "";return;}
    
        let paginationHTML = `<span class='simple-container width-100 flex-wrap members-table-rows' style='min-height:48px;max-height:80px;overflow:auto'>`;
        for (let i = 0; i < pageCount; i++) {
            if (i === currentPage) {
                paginationHTML += `<md-filled-icon-button onclick='AdminPanel.buildUsersTable(${i})'>${i+1}</md-filled-icon-button>`;
            } else {
                paginationHTML += `<md-icon-button onclick='AdminPanel.buildUsersTable(${i})'>${i + 1}</md-icon-button>`;
            }
        }
        paginationHTML += `</span>`;
        container.innerHTML = paginationHTML;
    }
    async function displayTotalUsers(totalRows = false){
        if(!totalRows) return false;
        const container = adminPanel.querySelector("#response-admin-panel-total-users");
        container.textContent = totalRows;
    }
    
    // Access
    async function getPageAccess(page = 0){
        const data = {
            op: "get_page_access",
            page:page
        }
        const url = `${BASE_URL}back-end/controllers/admin.controller.php`;
        try{
            const response = await fetch(url, {
                method: 'POST',
                body: JSON.stringify(data),
                headers: { 'Content-Type': 'application/json'}
            });
            if (response.ok) {
                const result = await response.json();
                if(result.success){ 
                    return result;
                } else { 
                    message(`Hubo un error: ${result.message}`, "error"); 
                }
            } else {
                message("Hubo un error en la solicitud", "error");
            }
        } catch (error) {
            message("Error: " + error.message, "error");
        }
        return false;
    }
    async function buildPageAccessTable(page = 0){
        const result = await getPageAccess(page);
        if(!result) return false;
        const tableContainer = adminPanel.querySelector("#response-admin-panel-access-table");
        emptyTableIndicator = tableContainer.nextElementSibling;
        emptyTableIndicator = "";

        if(!result.data || result.data.length === 0){
            emptyTableIndicator.innerHTML = `
                <div class="content-box on-background-text align-center info-table-empty">
                    <md-icon class="pretty medium" aria-hidden="true">sentiment_content</md-icon>
                    <span class="headline-small">No hay registros</span>
                </div>
            `;
            return false;
        }

        tableContainer.innerHTML = `
            <tr>
                <td></td>
                <td>Usuario</td>
                <td>Id de usuario</td>
                <td>App</td>
                <td>Dispositivo</td>
                <td>Ip</td>
                <td>Fecha de acceso</td>
            </tr>
            ${result.data.map(access => {
                profilePicture = access.profile_picture ? `<span class='simple-container overflow-hidden border-radius-64' style='width:24px;'><img class='width-100' src='${access.profile_picture}'></span>` : `<span class='simple-container outline-variant-text overflow-hidden border-radius-64' style='width:24px;'><md-icon class='filled'>account_circle</md-icon></span>` 

                return `
                    <tr>                       
                        <td>${profilePicture}</td>
                        <td>${access.name}</td>
                        <td>${access.user_id}</td>
                        <td>${access.page_name}</td>
                        <td>${access.device_type}</td>
                        <td>${access.ip_address}</td>
                        <td>${formatDateTime(access.access_timestamp)}</td>
                    </tr>
                `;
            }).join("")}
        `;
        displayTotalAccess(result.total_rows);
        buildPageAccessTablePagination(result.total_rows, result.limit, page);
    }
    function buildPageAccessTablePagination(totalRows, limit, currentPage = 0){
        const container = adminPanel.querySelector("#pagination-admin-panel-access-table");
        const pageCount = Math.ceil(totalRows / limit);
        if(pageCount <= 1){container.innerHTML = "";return;}
    
        let paginationHTML = `<span class='simple-container width-100 flex-wrap members-table-rows' style='min-height:48px;max-height:80px;overflow:auto'>`;
        for (let i = 0; i < pageCount; i++) {
            if (i === currentPage) {
                paginationHTML += `<md-filled-icon-button onclick='AdminPanel.buildPageAccessTable(${i})'>${i+1}</md-filled-icon-button>`;
            } else {
                paginationHTML += `<md-icon-button onclick='AdminPanel.buildPageAccessTable(${i})'>${i + 1}</md-icon-button>`;
            }
        }
        paginationHTML += `</span>`;
        container.innerHTML = paginationHTML;
    }
    function displayTotalAccess(totalRows = false){
        if(!totalRows) return false;
        const container = adminPanel.querySelector("#response-admin-panel-total-access");
        container.textContent = totalRows;
    }

    // suggestions
    async function getSuggestions(page = 0){
        const data = {
            op: "get_suggestions",
            page:page
        }
        const url = `${BASE_URL}back-end/controllers/admin.controller.php`;
        try{
            const response = await fetch(url, {
                method: 'POST',
                body: JSON.stringify(data),
                headers: { 'Content-Type': 'application/json'}
            });
            if (response.ok) {
                const result = await response.json();
                if(result.success){ 
                    return result;
                } else { 
                    message(`Hubo un error: ${result.message}`, "error"); 
                }
            } else {
                message("Hubo un error en la solicitud", "error");
            }
        } catch (error) {
            message("Error: " + error.message, "error");
        }
        return false;
    }
    async function buildSuggestionsTable(page = 0){
        const result = await getSuggestions(page);
        if(!result) return false;
        const tableContainer = adminPanel.querySelector("#response-admin-panel-suggestions-table");
        emptyTableIndicator = tableContainer.nextElementSibling;
        emptyTableIndicator = "";

        if(!result.data || result.data.length === 0){
            emptyTableIndicator.innerHTML = `
                <div class="content-box on-background-text align-center info-table-empty">
                    <md-icon class="pretty medium" aria-hidden="true">sentiment_content</md-icon>
                    <span class="headline-small">No hay registros</span>
                </div>
            `;
            return false;
        }

        tableContainer.innerHTML = `
            <tr>
                <td></td>
                <td>Usuario</td>
                <td>App</td>
                <td>Sugerencia</td>
            </tr>
            ${result.data.map(suggestion => {
                profilePicture = suggestion.profile_picture ? `<span class='simple-container overflow-hidden border-radius-64' style='width:24px;'><img class='width-100' src='${suggestion.profile_picture}'></span>` : `<span class='simple-container outline-variant-text overflow-hidden border-radius-64' style='width:24px;'><md-icon class='filled'>account_circle</md-icon></span>` 
                const userName = suggestion.name ? suggestion.name : suggestion.email;

                return `
                    <tr>                       
                        <td>${profilePicture}</td>
                        <td>${userName}</td>
                        <td>${suggestion.page_name}</td>
                        <td>${suggestion.suggestion}</td>
                    </tr>
                `;
            }).join("")}
        `;
        displayTotalSuggestions(result.total_rows);
        buildSuggestionsTablePagination(result.total_rows, result.limit, page);
    }
    function buildSuggestionsTablePagination(totalRows, limit, currentPage = 0){
        const container = adminPanel.querySelector("#pagination-admin-panel-suggestions-table");
        const pageCount = Math.ceil(totalRows / limit);
        if(pageCount <= 1){container.innerHTML = "";return;}
    
        let paginationHTML = `<span class='simple-container width-100 flex-wrap members-table-rows' style='min-height:48px;max-height:80px;overflow:auto'>`;
        for (let i = 0; i < pageCount; i++) {
            if (i === currentPage) {
                paginationHTML += `<md-filled-icon-button onclick='AdminPanel.buildSuggestionsTable(${i})'>${i+1}</md-filled-icon-button>`;
            } else {
                paginationHTML += `<md-icon-button onclick='AdminPanel.buildSuggestionsTable(${i})'>${i + 1}</md-icon-button>`;
            }
        }
        paginationHTML += `</span>`;
        container.innerHTML = paginationHTML;
    }
    function displayTotalSuggestions(totalRows = false){
        if(!totalRows) return false;
        const container = adminPanel.querySelector("#response-admin-panel-total-suggestions");
        container.textContent = totalRows;
    }

    function formatDateTime(datetime){
        const date = new Date(datetime);
        return `${date.toLocaleDateString()} ${date.toLocaleTimeString()}`;
    }

        

        document.getElementById('admin-panel-email-user-search').addEventListener('input', async (event) => {
            const term = event.target.value;
            const data = {
                op: "get_usersLike",
                term
            }
            const url = `${BASE_URL}back-end/controllers/admin.controller.php`;
            if (term.length >= 3) {
                try {
                    const response = await fetch(url, {
                        method: 'POST',
                        body: JSON.stringify(data),
                        headers: { 'Content-Type': 'application/json'}
                    });
                    const result = await response.json();
                    const users = result.data
                    
                    // Mostrar resultados en la página
                    const results = document.getElementById('admin-panel-email-user-search-result');
                    results.innerHTML = ''; // Limpiar resultados anteriores
                    
                    users.forEach(user => {
                        const item = document.createElement('div');
                        item.className = "content-box padding-16 cursor-pointer border-radius-16 on-background-text hover-outline"
                        const mdRipple = document.createElement("md-ripple");
                        

                        if (user.name) {
                            item.textContent = `${user.name} - ${user.email}`;
                        } else {
                            item.textContent = user.email;
                        }

                        item.appendChild(mdRipple);

                        item.addEventListener('click', () => {
                            addUsersSelected(user);
                        });
                        
                        results.appendChild(item);
                    });
                } catch (error) {
                    console.error('Error al buscar usuarios:', error);
                }
            }
        });

        function addUsersSelected(user) {
            const alreadyExistsEmail = emailUsers.some(e => e === user.email);
            if (alreadyExistsEmail) return;


            emailUsers.push(user.email)
            const selectedUsers = document.getElementById('admin-panel-email-selected-users');
        
            // Crear un elemento para el usuario seleccionado
            const selected = document.createElement('div');
            selected.className = "content-box padding-16 cursor-pointer border-radius-16 on-background-text hover-outline"
            const mdRipple = document.createElement("md-ripple");

            selected.textContent = user.name ? `${user.name} - ${user.email}` : user.email;
            selected.dataset.email = user.email;
            selected.classList.add('seleccionado'); // Clase para estilo, si es necesario
        
            // Añadir evento de doble clic para eliminar
            selected.addEventListener('dblclick', () => {
                emailUsers = emailUsers.filter(email => email !== selected.dataset.email);
                selected.remove();
                
            });
        
            selectedUsers.appendChild(selected);
        }

        // Email Functions

        function verifyContentEmail(){
            // verifica si el header y el mensaje del Email tienen contenido (Devuelve un boolean)
            const header = document.getElementById('headerEmail');
            const content = document.getElementById('contentEmail');

            if (header.value.trim() === '' || content.value.trim() === '') return false;
            return true;
        }

   
        async function sendEmail(header,content,users){
                
            const data = {
                op: "sendEmail",
                header,
                content,
                users
            }
            const url = `${BASE_URL}back-end/controllers/email.controller.php`;
                try {
                    const response = await fetch(url, {
                        method: 'POST',
                        body: JSON.stringify(data),
                        headers: { 'Content-Type': 'application/json'}
                    });
                    const result = await response.json();
                } catch (error) {
                    console.error('Error al enviar el correo:', error);
                }
        }

        async function sendEmailAllUsers(header,content){
                
            const data = {
                op: "sendEmailAllUsers",
                header,
                content,
            }
            // console.log('Enviando correo');
            // console.log(data);

            const url = `${BASE_URL}back-end/controllers/email.controller.php`;
                try {
                    const response = await fetch(url, {
                        method: 'POST',
                        body: JSON.stringify(data),
                        headers: { 'Content-Type': 'application/json'}
                    });
                    const result = await response.json();
                    // console.log(result);
                } catch (error) {
                    console.error('Error al enviar los correos:', error);
                }
        }

        function getEmailContent(){
            const header = document.getElementById('headerEmail').value;
            const content = document.getElementById('contentEmail').value;

            return {
                header,
                content
            }
        }
})();


