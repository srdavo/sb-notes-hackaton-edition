const adminService = (() => {

    const API_URL = `${BASE_URL}back-end/controllers/admin.controller.php`;
    const CSRF_TOKEN = document.querySelector("meta[name='csrf-token']").getAttribute("content");

    async function getUsers(data = {}){
        data.op = "get_users_list";
        const controller = new AbortController();
        const timeoutId = setTimeout(() => controller.abort(), 10000); // Abort after 10 seconds
        try {
            const response = await fetch(API_URL, {
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
            if (!response.ok) {
                throw new Error(`Error: ${response.status} ${response.statusText}`);
            }
            const result = await response.json();
            if (!result.success) {
                throw new Error(result.message || "Unknown error in response");
            }
            return result;
        } catch (error) {
            clearTimeout(timeoutId);
            if (error.name === 'AbortError') {
                message("Request timed out", "error");
            } else {
                message(`An error occurred: ${error.message}`, "error");
            }
            return null;
        }
    }

    async function getAccess(data = {}){
        data.op = "get_access_list";
        const controller = new AbortController();
        const timeoutId = setTimeout(() => controller.abort(), 10000); // Abort after 10 seconds
        try {
            const response = await fetch(API_URL, {
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
            if (!response.ok) {
                throw new Error(`Error: ${response.status} ${response.statusText}`);
            }
            const result = await response.json();
            if (!result.success) {
                throw new Error(result.message || "Unknown error in response");
            }
            return result;
        } catch (error) {
            clearTimeout(timeoutId);
            if (error.name === 'AbortError') {
                message("Request timed out", "error");
            } else {
                message(`An error occurred: ${error.message}`, "error");
            }
            return null;
        }
    }

    async function getSuggestions(data = {}){
        data.op = "get_suggestions_list";
        const controller = new AbortController();
        const timeoutId = setTimeout(() => controller.abort(), 10000); // Abort after 10 seconds
        try {
            const response = await fetch(API_URL, {
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
            if (!response.ok) {
                throw new Error(`Error: ${response.status} ${response.statusText}`);
            }
            const result = await response.json();
            if (!result.success) {
                throw new Error(result.message || "Unknown error in response");
            }
            return result;
        } catch (error) {
            clearTimeout(timeoutId);
            if (error.name === 'AbortError') {
                message("Request timed out", "error");
            } else {
                message(`An error occurred: ${error.message}`, "error");
            }
            return null;
        }
    }

    async function getMelonMindActionsStats(data = {}){
        data.op = "get_stats";
        const controller = new AbortController();
        const timeoutId = setTimeout(() => controller.abort(), 10000); // Abort after 10 seconds
        try {
            const response = await fetch(`${BASE_URL}apps/mind/back-end/controllers/actions.controller.php`, {
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
            if (!response.ok) {
                throw new Error(`Error: ${response.status} ${response.statusText}`);
            }
            const result = await response.json();
            if (!result.success) {
                throw new Error(result.message || "Unknown error in response");
            }
            return result;
        } catch (error) {
            clearTimeout(timeoutId);
            if (error.name === 'AbortError') {
                message("Request timed out", "error");
            } else {
                message(`An error occurred: ${error.message}`, "error");
            }
            return null;
        }
    }

    async function getMelonMindActionsByUser(data = {}){
        data.op = "get_actions_by_user";
        const controller = new AbortController();
        const timeoutId = setTimeout(() => controller.abort(), 10000); // Abort after 10 seconds
        try {
            const response = await fetch(`${BASE_URL}apps/mind/back-end/controllers/actions.controller.php`, {
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
            if (!response.ok) {
                throw new Error(`Error: ${response.status} ${response.statusText}`);
            }
            const result = await response.json();
            if (!result.success) {
                throw new Error(result.message || "Unknown error in response");
            }
            return result;
        } catch (error) {
            clearTimeout(timeoutId);
            if (error.name === 'AbortError') {
                message("Request timed out", "error");
            } else {
                message(`An error occurred: ${error.message}`, "error");
            }
            return null;
        }
    }

    async function getPaidUsers(data = {}){
        data.op = "get_paid_users_list";
        const controller = new AbortController();
        const timeoutId = setTimeout(() => controller.abort(), 10000); // Abort after 10 seconds
        try {
            const response = await fetch(API_URL, {
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
            if (!response.ok) {
                throw new Error(`Error: ${response.status} ${response.statusText}`);
            }
            const result = await response.json();
            if (!result.success) {
                throw new Error(result.message || "Unknown error in response");
            }
            return result;
        } catch (error) {
            clearTimeout(timeoutId);
            if (error.name === 'AbortError') {
                message("Request timed out", "error");
            } else {
                message(`An error occurred: ${error.message}`, "error");
            }
            return null;
        }
    }

    async function getPaidUserdata(data = {}){
        data.op = "get_paid_user_data";
        const controller = new AbortController();
        const timeoutId = setTimeout(() => controller.abort(), 10000); // Abort after 10 seconds
        try {
            const response = await fetch(API_URL, {
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
            if (!response.ok) {
                throw new Error(`Error: ${response.status} ${response.statusText}`);
            }
            const result = await response.json();
            if (!result.success) {
                throw new Error(result.message || "Unknown error in response");
            }
            return result;
        } catch (error) {
            clearTimeout(timeoutId);
            if (error.name === 'AbortError') {
                message("Request timed out", "error");
            } else {
                message(`An error occurred: ${error.message}`, "error");
            }
            return null;
        }
    }

    async function getTherapists(data = {}){
        data.op = "get_therapists_list";
        const controller = new AbortController();
        const timeoutId = setTimeout(() => controller.abort(), 10000); // Abort after 10 seconds
        try {
            const response = await fetch(API_URL, {
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
            if (!response.ok) {
                throw new Error(`Error: ${response.status} ${response.statusText}`);
            }
            const result = await response.json();
            if (!result.success) {
                throw new Error(result.message || "Unknown error in response");
            }
            return result;
        } catch (error) {
            clearTimeout(timeoutId);
            if (error.name === 'AbortError') {
                message("Request timed out", "error");
            } else {
                message(`An error occurred: ${error.message}`, "error");
            }
            return null;
        }
    }

    return{
        getUsers,
        getAccess,
        getSuggestions,
        getMelonMindActionsStats,
        getMelonMindActionsByUser,
        getPaidUsers,
        getPaidUserdata,
        getTherapists,
    }

})();

export default adminService;