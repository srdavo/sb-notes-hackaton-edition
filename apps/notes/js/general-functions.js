const CSRF_TOKEN = document.querySelector("meta[name='csrf-token']").getAttribute("content");

async function request(data = {}) {
    if (!data.API_URL) {
        console.error("API_URL is required");
        return null;
    }
    if (!data.op && data.returnHtml !== true) {
        console.error("OP is required");
        return null;
    }
    data.user_timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
    const controller = new AbortController();
    const timeoutId = setTimeout(() => controller.abort(), 60000); // Abort after 60 seconds
    try {
        const response = await fetch(data.API_URL, {
            method: 'POST',
            headers: {
                'X-CSRF-Token': CSRF_TOKEN,
                'Content-Type': 'application/json'
            },
            credentials: 'same-origin',
            body: JSON.stringify(data),
            signal: controller.signal
        });
        clearTimeout(timeoutId);

        // Si se manda data.returnHtml === true, regresa el HTML como texto
        if (data.returnHtml === true) {
            const html = await response.text();
            if (!response.ok) {
                throw new Error(`Error: ${response.status} ${response.statusText}`);
            }
            return html;
        }

        if (!response.ok) {
            throw new Error(`Error: ${response.status} ${response.statusText}`);
        }
        const result = await response.json();
        if (!result.success) {
            const error = new Error(result.message || "Unknown error in response");
            // Preserve additional properties from the server response
            Object.keys(result).forEach(key => {
                if (key !== 'message' && key !== 'success') {
                    error[key] = result[key];
                }
            });
            throw error;
        }
        return result;
    } catch (error) {
        clearTimeout(timeoutId);

        if (data.returnOnError) {
            return error.message || "Unknown error";
        }
        if (data.throwOnError) {
            throw error;
        }

        if (error.name === 'AbortError') {
            message("Request timed out", "error");
        } else {
            message(`An error occurred: ${error.message}`, "error");
        }
        return null;
    }
}


async function displayAnyTable(page = 0, container, dataFunction, buildFunction, additionalData = {}){
    if(!container) return false;
    if(!dataFunction) return false;
    if(!buildFunction) return false;
    //
    // Define the container elements
    const containerFilters = container.querySelector("[name='container-filters']");
    const containerTable = container.querySelector("[name='container-table']");
    const containerPagination = container.querySelector("[name='container-pagination']");

    // Loading animation and reset
    var flowAnimation = true;
    if(containerTable.children.length === 0){
        containerTable.innerHTML = `<md-linear-progress indeterminate></md-linear-progress>`
    } else {
        flowAnimation = false;
        containerTable.classList.add("animation-loading-1");
    }
    
    // Get data from the server
    const data = await dataFunction({page: page, ...additionalData});
    if(!data) return false;

    // Reset the table
    containerTable.innerHTML = "";
    containerTable.classList.remove("animation-loading-1");

    const fragment = document.createDocumentFragment();
    const rows = buildFunction(data.data);
    rows.forEach(row => fragment.appendChild(row));
    containerTable.appendChild(fragment);

    if(flowAnimation) flowChilds(containerTable, {betweenDelay: 0.02});
    buildPagination(data.pagination, page, containerPagination, additionalData.paginationFunction, {container, data});
}


async function loadView({ url, container }) {
    container.classList.add("animation-loading-1");
    try {
        const content = await request({ API_URL: url, returnHtml: true });
        container.innerHTML = content;
        return true; // Éxito
    } catch (error) {
        console.error("Failed to load view:", error);
        container.innerHTML = "<p>Error al cargar el contenido.</p>";
        return false; // Fracaso
    } finally {
        container.classList.remove("animation-loading-1");
    }
}