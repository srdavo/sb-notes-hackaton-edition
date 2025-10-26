import adminService from './../services/adminService.js?v=3';

const AdminManager = (() =>{


    const adminPanelWindow = document.getElementById("window-admin-panel");

    async function openAdminPanel(){
        changeWindow("#window-admin-panel");
        await getUsers();
        await displayPaidUsers();
        await getAccess();
        await getSuggestions();
        await getTherapists();
        await displayMelonMindActions();
    }

    // Users table
    const usersTableContainer = document.getElementById("response-users-table");
    const usersTablePagination = usersTableContainer.nextElementSibling;
    const totalUsersContainer = document.getElementById("response-admin-panel-total-users");

    async function getUsers(page = 0){
        const users = await adminService.getUsers({page});
        displayUsersTable(users, page);
    }

    function displayUsersTable(data, page = 0){
        if(!usersTableContainer){
            message("No se ha encontrado el contenedor de la tabla de usuarios", "error");
            return;
        }

        const fragment = document.createDocumentFragment();
        const rows = buildUsersTable(data.data, page);

        rows.forEach(row => fragment.appendChild(row));
        usersTableContainer.innerHTML = "";
        usersTableContainer.appendChild(fragment);

        buildAdminPagination(data.pagination, page);
        flowChilds(usersTableContainer, {betweenDelay: 0.03});
        totalUsersContainer.textContent = data.pagination.total_rows;
    }

    function buildUsersTable(users){

        const rows = [];
        if(users.length <= 0){
            const row = document.createElement("div");
            row.className = "content-box align-center justify-center user-select-none";
            row.innerHTML = `<span class="body-large outline-text">No hay usuarios</span>`;
            rows.push(row);
            return rows;
        }

        const header = document.createElement("tr");
        header.innerHTML = `
            <td>Id</td>
            <td></td>
            <td>Nombre</td>
            <td>Email</td>
            <td>Token</td>
            <td>Fecha de creación</td>
        `;
        rows.push(header);

        users.forEach(user => {
            const row = document.createElement("tr");
            if(Number(user.permissions) === 7){
                row.classList.add("secondary-container")
            }

            const profilePicture = user.profile_picture ? `<span class='simple-container overflow-hidden border-radius-64' style='width:24px;'><img class='width-100' src='${user.profile_picture}'></span>` : `<span class='simple-container outline-text overflow-hidden border-radius-64' style='width:24px;'><md-icon class='filled'>account_circle</md-icon></span>` 
            
            row.innerHTML = `
                <td>${user.id}</td>
                <td>${profilePicture}</td>
                <td>${user.name}</td>
                <td>${user.email}</td>
                <td>${user.user_token}</td>
                <td>${user.creation_datetime}</td>
            `;
            rows.push(row)
        });
        return rows;
    }

    function buildAdminPagination(paginationData, page, dataType = "users") {
        const totalRows = paginationData.total_rows;
        const limit = paginationData.limit;
    
        const pageCount = Math.ceil(totalRows / limit);
        if (pageCount <= 1) {
            if (dataType === "users") usersTablePagination.innerHTML = "";
            if (dataType === "access") pageAccessTablePagination.innerHTML = "";
            if (dataType === "suggestions") suggestionsTablePagination.innerHTML = "";
            return;
        }
    
        const currentPage = page; 
        const pagesToShow = new Set();
        pagesToShow.add(0); // First page
        const rangeStart = Math.max(0, currentPage - 2);
        const rangeEnd = Math.min(pageCount - 1, currentPage + 2);
        for (let i = rangeStart; i <= rangeEnd; i++) pagesToShow.add(i);
        pagesToShow.add(pageCount - 1); 
        const pagesArray = Array.from(pagesToShow).sort((a, b) => a - b);
    
        let paginationHTML = `<span class='user-select-none simple-container width-100 flex-wrap members-table-rows' style='min-height:48px;max-height:80px;overflow:auto;content-visibility: auto;'>`;
        let previousPage = null;
    
        for (const pageNumber of pagesArray) {
            if (previousPage !== null && pageNumber - previousPage > 1) {
                paginationHTML += `<span class="pagination-ellipsis" style="display: inline-flex;align-items: center;padding: 0 8px;color: #666;">...</span>`;
            }
    
            if (pageNumber === currentPage) {
                paginationHTML += `<md-filled-icon-button data-page='${pageNumber}'>${pageNumber + 1}</md-filled-icon-button>`;
            } else {
                paginationHTML += `<md-icon-button style="content-visibility: auto;" data-page='${pageNumber}'>${pageNumber + 1}</md-icon-button>`;
            }
    
            previousPage = pageNumber;
        }
        paginationHTML += `</span>`;
    
        // Update DOM and add event listeners
        const paginationContainer = dataType === "users" 
            ? usersTablePagination 
            : dataType === "access"
            ? pageAccessTablePagination
            : dataType === "therapists"
            ? therapistsTablePagination
            : suggestionsTablePagination;
        paginationContainer.innerHTML = paginationHTML;
    
        const buttons = paginationContainer.querySelectorAll("[data-page]");
        buttons.forEach(button => {
            button.addEventListener("click", () => {
                const newPage = parseInt(button.getAttribute("data-page"));
                const changePage = dataType === "users" 
                    ? changePageUsersTable 
                    : dataType === "access"
                    ? changePageAccessTable
                    : dataType === "therapists"
                    ? changePageTherapistsTable
                    : changePageSuggestionsTable;
                changePage(newPage);
            });
        });
    }

    async function changePageUsersTable(page){
        const users = await adminService.getUsers({page});
        displayUsersTable(users, page);
        
        adminPanelWindow.querySelector("HOLDER").scrollTo({
            top: 0,
            left: 0,
            behavior: 'smooth'
        });
    }


    // Access table
    const pageAccessTableContainer = document.getElementById("response-admin-panel-access-table");
    const pageAccessTablePagination = pageAccessTableContainer.nextElementSibling;
    const totalPageAccessContainer = document.getElementById("response-admin-panel-total-access");

    async function getAccess(page = 0){
        const access = await adminService.getAccess({page});
        displayAccessTable(access, page);
    }

    function displayAccessTable(data, page = 0){
        if(!pageAccessTableContainer){
            message("No se ha encontrado el contenedor de la tabla de accesos", "error");
            return;
        }

        const fragment = document.createDocumentFragment();
        const rows = buildAccessTable(data.data, page);

        rows.forEach(row => fragment.appendChild(row));
        pageAccessTableContainer.innerHTML = "";
        pageAccessTableContainer.appendChild(fragment);

        buildAdminPagination(data.pagination, page, "access");
        flowChilds(pageAccessTableContainer, {betweenDelay: 0.03});
        totalPageAccessContainer.textContent = data.pagination.total_rows;
    }

    function buildAccessTable(access){

        const rows = [];
        if(access.length <= 0){
            const row = document.createElement("div");
            row.className = "content-box align-center justify-center user-select-none";
            row.innerHTML = `<span class="body-large outline-text">No ha accesos</span>`;
            rows.push(row);
            return rows;
        }

        const header = document.createElement("tr");
        header.innerHTML = `
            <td></td>
            <td>Id</td>
            <td>Usuario</td>
            <td>App</td>
            <td>Dispositivo</td>
            <td>Ip</td>
            <td>Fecha de acceso</td>
        `;
        rows.push(header);

        access.forEach(access => {
            const row = document.createElement("tr");

            const profilePicture = access.profile_picture ? `<span class='simple-container overflow-hidden border-radius-64' style='width:24px;'><img class='width-100' src='${access.profile_picture}'></span>` : `<span class='simple-container outline-text overflow-hidden border-radius-64' style='width:24px;'><md-icon class='filled'>account_circle</md-icon></span>` 

            row.innerHTML = `
                <td>${profilePicture}</td>
                <td>${access.user_id}</td>
                <td>${access.name}</td>
                <td>${access.page_name}</td>
                <td>${access.device_type}</td>
                <td>${access.ip_address}</td>
                <td>${access.access_timestamp}</td>
            `;
            rows.push(row)
        });
        return rows;
    }

    async function changePageAccessTable(page){
        const access = await adminService.getAccess({page});
        displayAccessTable(access, page);
        
        adminPanelWindow.querySelector("HOLDER").scrollTo({
            top: 0,
            left: 0,
            behavior: 'smooth'
        });
    }


    const suggestionsTableContainer = document.getElementById("response-admin-panel-suggestions-table");
    const suggestionsTablePagination = suggestionsTableContainer.nextElementSibling;
    const totalSuggestionsContainer = document.getElementById("response-admin-panel-total-suggestions");

    async function getSuggestions(page = 0){
        const suggestions = await adminService.getSuggestions({page});
        displaySuggestionsTable(suggestions, page);
    }

    function displaySuggestionsTable(data, page = 0){
        if(!suggestionsTableContainer){
            message("No se ha encontrado el contenedor de la tabla de sugerencias", "error");
            return;
        }

        const fragment = document.createDocumentFragment();
        const rows = buildSuggestionsTable(data.data, page);

        rows.forEach(row => fragment.appendChild(row));
        suggestionsTableContainer.innerHTML = "";
        suggestionsTableContainer.appendChild(fragment);

        buildAdminPagination(data.pagination, page, "suggestions");
        flowChilds(suggestionsTableContainer, {betweenDelay: 0.03});
        totalSuggestionsContainer.textContent = data.pagination.total_rows;
    }

    function buildSuggestionsTable(suggestions){

        const rows = [];
        if(suggestions.length <= 0){
            const row = document.createElement("div");
            row.className = "content-box align-center justify-center user-select-none";
            row.innerHTML = `<span class="body-large outline-text">No ha sugerencias</span>`;
            rows.push(row);
            return rows;
        }

        const header = document.createElement("tr");
        header.innerHTML = `
            <td></td>
            <td>Usuario</td>
            <td>App</td>
            <td>Sugerencia</td>
        `;
        rows.push(header);

        suggestions.forEach(suggestion => {
            const row = document.createElement("tr");

            const profilePicture = suggestion.profile_picture ? `<span class='simple-container overflow-hidden border-radius-64' style='width:24px;'><img class='width-100' src='${suggestion.profile_picture}'></span>` : `<span class='simple-container outline-text overflow-hidden border-radius-64' style='width:24px;'><md-icon class='filled'>account_circle</md-icon></span>` 

            row.innerHTML = `
                <td>${profilePicture}</td>
                <td>${suggestion.name}</td>
                <td>${suggestion.page_name}</td>
                <td>${suggestion.suggestion}</td>
            `;
            rows.push(row)
        });
        return rows;
    }

    async function changePageSuggestionsTable(page){
        const suggestions = await adminService.getSuggestions({page});
        displaySuggestionsTable(suggestions, page);
        
        adminPanelWindow.querySelector("HOLDER").scrollTo({
            top: 0,
            left: 0,
            behavior: 'smooth'
        });
    }

    

    // Actions
    const actionsContainer = adminPanelWindow.querySelector("#w-section-admin-panel-actions");
    const actionsDateStart = actionsContainer.querySelector("[name='date_start']");
    const actionsDateEnd = actionsContainer.querySelector("[name='date_end']");

    actionsDateStart.addEventListener("change", async () => {
        await displayMelonMindActions();
    });

    actionsDateEnd.addEventListener("change", async () => {
        await displayMelonMindActions();
    });

    async function displayMelonMindActions(){
        

        const actions = await adminService.getMelonMindActionsStats({date_start: actionsDateStart.value, date_end: actionsDateEnd.value});

        
        actions.data.forEach(action => {
            const actionElement = actionsContainer.querySelector(`[name='${action.action_name}']`);
            if (actionElement) { actionElement.textContent = action.total; }
        });

        const totalActions = actions.data.reduce((suma, accion) => suma + accion.total, 0);
        actionsContainer.querySelector(`[name='total_actions']`).innerHTML = totalActions;

        

    }



    // paidusers

    const paidUsersSection = document.getElementById("w-section-admin-panel-paiduser");
    const paidUsersTableContainer = document.getElementById("response-admin-panel-paid-users-table-container");
    const subSectionPaidUserProfile = document.getElementById("sub-section-admin-panel-paid-user-profile");

    async function displayPaidUsers(page, container = paidUsersTableContainer, data = {}){

        const filtersContainer = container.querySelector("[name='filters-container']");
        const tableContainer = container.querySelector("[name='table-container']");

        if(tableContainer.children.length === 0 ){ 
            tableContainer.innerHTML = `<md-linear-progress indeterminate></md-linear-progress>`;
        } else{
            tableContainer.classList.add("animation-loading-1");
        }

        const paidUsers = await adminService.getPaidUsers({page, ...data});
        tableContainer.innerHTML = '';
        tableContainer.classList.remove("animation-loading-1");
        if(!paidUsers) return false;

        const fragment = document.createDocumentFragment();
        const rows = buildPaidUsersTable(paidUsers.data);
        rows.forEach(row => fragment.appendChild(row));
        tableContainer.appendChild(fragment);

        flowChilds(tableContainer);
        buildPagination(paidUsers.pagination, page, tableContainer.nextElementSibling, displayPaidUsers, {});

        paidUsersSection.querySelector("[name='total_paid_users']").textContent = paidUsers.pagination.total_rows ?? 0;
    }

    function buildPaidUsersTable(data){
        const rows = [];
        if(data.length <= 0){
            const row = document.createElement("div");
            row.className = "content-box align-center justify-center user-select-none";
            row.innerHTML = `<span class="body-large outline-text">No hay usuarios de paga</span>`;
            rows.push(row);
            return rows;
        }

        const header = document.createElement("tr");
        header.innerHTML = `
            <td>Id</td>
            <td></td>
            <td>Nombre</td>
            <td>Email</td>
            <td>Estado de suscripción</td>
            <td></td>
        `;
        rows.push(header);

        data.forEach(user => {
            const row = document.createElement("tr");
            const profilePicture = user.profile_picture ? `<span class='simple-container overflow-hidden border-radius-64' style='width:24px;'><img class='width-100' src='${user.profile_picture}'></span>` : `<span class='simple-container outline-variant-text overflow-hidden border-radius-64' style='width:24px;'><md-icon class='filled'>account_circle</md-icon></span>` 
            const subscriptionStatus = user.subscription_status == "active" ? "<div class='simple-container padding-4 border-radius-8 primary-container'></div>" : "<div class='simple-container padding-4 border-radius-8 secondary-container'></div>";

            let subscriptionStatusCircle = "";
            if(user.subscription_status == "active"){
                subscriptionStatusCircle = `<div class='simple-container padding-4 border-radius-8 primary'></div>`;
            }
            if(user.subscription_status == "trialing"){
                subscriptionStatusCircle = `<div class='simple-container padding-4 border-radius-8 primary'></div>`;
            }
            if(user.subscription_status == "canceled"){
                subscriptionStatusCircle = `<div class='simple-container padding-4 border-radius-8 error'></div>`;
            }


            row.innerHTML = `
                <td>${user.id}</td>
                <td>${profilePicture}</td>
                <td>${user.name}</td>
                <td>${user.email}</td>
                <td><div class="simple-container align-center gap-8">${subscriptionStatusCircle} ${user.subscription_status}</div></td>
                <td>
                    <div class="simple-container justify-right h-padding-8">
                        <button class="style-7 background text-wrap-nowrap" data-flip-id="animate">
                            <md-ripple></md-ripple>
                            <md-icon class="dynamic">north_east</md-icon>
                            Abrir perfil
                        </button>
                    </div>
                </td>
            `;

            row.querySelector("button").addEventListener("click", () => {
                openUserProfile(user.id);
            });

            rows.push(row)
        });
        return rows;
    }

    async function openUserProfile(userId){

        subSectionPaidUserProfile.classList.add("animation-loading-1");

        toggleSubSection('#sub-section-admin-panel-paid-user-profile', {exclusive: true, action: 'open', animationType: "from-origin"});

        const userData = await adminService.getPaidUserdata({user_id: userId});
        displaySystemUserData(userData);
        subSectionPaidUserProfile.classList.remove("animation-loading-1");

        const userActionsCount = await adminService.getMelonMindActionsByUser({user_id: userId});
        displayUserActionsCount(userActionsCount);


        
        
    }
    
    function displaySystemUserData(userData){
        
                subSectionPaidUserProfile.querySelector("[name='user_id']").textContent = `#${userData.data.user_id}`;
                const userName = userData.data.user_name;
                if(!userName || userName == ""){ subSectionPaidUserProfile.querySelector("[name='user_name']").innerHTML = `<i class="outline-text">Sin nombre de usuario</i>`; } else {subSectionPaidUserProfile.querySelector("[name='user_name']").textContent = userData.data.user_name;}
                subSectionPaidUserProfile.querySelector("[name='user_email']").textContent = userData.data.user_email;
        
                const userProfilePicture = userData.data.profile_picture;
                if(!userProfilePicture || userProfilePicture == ""){
                    subSectionPaidUserProfile.querySelector("[name='user_profile_picture']").innerHTML = `<md-icon class="pretty-minimal outline-variant-text filled">account_circle</md-icon>`;
                } else {
                    subSectionPaidUserProfile.querySelector("[name='user_profile_picture']").innerHTML = `<img style="widht:120px;" src="${userProfilePicture}" class="border-radius-64">`;
                }
        
                subSectionPaidUserProfile.querySelector("[name='user_creation_datetime']").innerHTML = `Cuenta creada: ${dateToShort(userData.data.creation_datetime, true)}, ${timeToAmPm(userData.data.creation_datetime)} UTC`;
                
                const lastAccessDevice = subSectionPaidUserProfile.querySelector("[name='last_access_device_type']");
                lastAccessDevice.innerHTML = "laptop_chromebook";
                if(userData.data.last_access_device_type == "Desktop"){lastAccessDevice.innerHTML = "laptop_chromebook";} 
                if(userData.data.last_access_device_type == "Android"){lastAccessDevice.innerHTML = "phone_android";} 
                if(userData.data.last_access_device_type == "iOS (iPhone/iPad)"){lastAccessDevice.innerHTML = "phone_iphone";}
                // Calculate time difference between now and last access
        
                
                subSectionPaidUserProfile.querySelector("[name='last_access_time_ago']").innerHTML = `${calculateTimeSince(userData.data.last_access_timestamp)}`;
                subSectionPaidUserProfile.querySelector("[name='last_access_ip_address']").textContent = `${userData.data.last_access_ip_address}`;
                subSectionPaidUserProfile.querySelector("[name='last_access_timestamp']").textContent = `${dateToShort(userData.data.last_access_timestamp, true)}, ${timeToAmPm(userData.data.last_access_timestamp)} UTC`;
        
        
                const subscriptionStatus = subSectionPaidUserProfile.querySelector("[name='subscription_status']");
                subscriptionStatus.innerHTML = `<md-icon class='dynamic'>radio_button_unchecked</md-icon>`;
                if(userData.data.subscription_status == "active") subscriptionStatus.innerHTML = `<span class="data-line icon primary-container on-primary-container-text"><md-icon class='dynamic filled'>check_circle</md-icon> Activa</span>`;
                if(userData.data.subscription_status == "trialing") subscriptionStatus.innerHTML = `<span class="data-line icon primary-container on-primary-container-text"><md-icon class='dynamic'>check_circle</md-icon> Prueba</span>`;
                if(userData.data.subscription_status == "canceled") subscriptionStatus.innerHTML = `<span class="data-line icon error-container on-error-container-text"><md-icon class='dynamic filled error-text'>cancel</md-icon> Cancelada</span>`;
        
                subSectionPaidUserProfile.querySelector("[name='current_period_start']").textContent = `${dateToShort(userData.data.current_period_start, true)}`;
                subSectionPaidUserProfile.querySelector("[name='current_period_end']").textContent = `${dateToShort(userData.data.current_period_end, true)}`;

    }

    function displayUserActionsCount(userActionsCount){
     
        subSectionPaidUserProfile.querySelector("[name='actions_total_today']").textContent = userActionsCount.data.total_today ?? 0;
        subSectionPaidUserProfile.querySelector("[name='actions_total_this_week']").textContent = userActionsCount.data.total_this_week ?? 0; 
        subSectionPaidUserProfile.querySelector("[name='actions_total_all_time']").textContent = userActionsCount.data.total_all_time ?? 0;
        

    }

    function calculateTimeSince(timestamp){
        const now = new Date();
        const nowUTC = Date.UTC(now.getUTCFullYear(), now.getUTCMonth(), now.getUTCDate(), 
                      now.getUTCHours(), now.getUTCMinutes(), now.getUTCSeconds());
        const accessTime = new Date(timestamp);
        const diffMs = nowUTC - accessTime;
        
        const diffSec = Math.floor(diffMs / 1000);
        const diffMin = Math.floor(diffSec / 60);
        const diffHours = Math.floor(diffMin / 60);
        const diffDays = Math.floor(diffHours / 24);
        const diffMonths = Math.floor(diffDays / 30);
        
        if (diffMonths > 0) return `hace ${diffMonths} ${diffMonths === 1 ? 'mes' : 'meses'}`;
        if (diffDays > 0) return `hace ${diffDays} ${diffDays === 1 ? 'día' : 'días'}`;
        if (diffHours > 0) return `hace ${diffHours} ${diffHours === 1 ? 'hora' : 'horas'}`;
        if (diffMin > 0) return `hace ${diffMin} ${diffMin === 1 ? 'minuto' : 'minutos'}`;
        return `hace unos segundos`;
    }

    
    const therapistsTableContainer = document.getElementById("response-admin-panel-therapists-table");
    const therapistsTablePagination = therapistsTableContainer.nextElementSibling;
    const totalTherapistsContainer = document.getElementById("response-admin-panel-total-therapists");

    async function getTherapists(page = 0){
        const therapists = await adminService.getTherapists({page});
        displayTherapistsTable(therapists, page);
    }

    function displayTherapistsTable(data, page = 0){
        if(!therapistsTableContainer){
            message("No se ha encontrado el contenedor de la tabla de terapeutas", "error");
            return;
        }

        const fragment = document.createDocumentFragment();
        const rows = buildTherapistsTable(data.data, page);

        rows.forEach(row => fragment.appendChild(row));
        therapistsTableContainer.innerHTML = "";
        therapistsTableContainer.appendChild(fragment);

        buildAdminPagination(data.pagination, page, "therapists");
        flowChilds(therapistsTableContainer, {betweenDelay: 0.03});
        totalTherapistsContainer.textContent = data.pagination.total_rows;
    }

    function buildTherapistsTable(therapists){

        const rows = [];
        if(therapists.length <= 0){
            const emptyRow = document.createElement("tr");
            emptyRow.innerHTML = `<td colspan="8" style="text-align:center;">No hay terapeutas registrados</td>`;
            rows.push(emptyRow);
            return rows;
        }

        const header = document.createElement("tr");
        header.innerHTML = `
            <td>Id</td>
            <td></td>
            <td>Nombre</td>
            <td>Email</td>
            <td>Teléfono</td>
            <td>País</td>
            <td>Ciudad</td>
            <td>Especialidad</td>
            <td>Sistema de facturación</td>
        `;
        rows.push(header);

        therapists.forEach(therapist => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${therapist.user_id || '-'}</td>
                <td>
                    <div class="profile-picture-small" style="background-image:url('${therapist.profile_picture || ''}');"></div>
                </td>
                <td>${therapist.name || '-'}</td>
                <td>${therapist.email || '-'}</td>
                <td>${therapist.user_phone || '-'}</td>
                <td>${therapist.user_country || '-'}</td>
                <td>${therapist.user_city || '-'}</td>
                <td>${therapist.user_speciality || '-'}</td>
                <td>${therapist.billing_system == 1 ? 'Activo' : 'Inactivo'}</td>
            `;
            rows.push(row);
        });
        return rows;
    }

    async function changePageTherapistsTable(page){
        const therapists = await adminService.getTherapists({page});
        displayTherapistsTable(therapists, page);
        
        adminPanelWindow.querySelector("HOLDER").scrollTo({
            top: 0,
            left: 0,
            behavior: 'smooth'
        });
    }

    

    return{
        openAdminPanel
    }

})();

export default AdminManager;