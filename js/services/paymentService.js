const paymentService = (() => {
    const API_URL = `${BASE_URL}back-end/controllers/payment.controller.php`;
    const CSRF_TOKEN = document.querySelector("meta[name='csrf-token']").getAttribute("content");


    async function fetchClientSecret(){
        const data = { op: "get_client_secret" };
        const controller = new AbortController();
        const timeoutId = setTimeout(() => controller.abort(), 100000); // Abort after 10 seconds
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
            return result.clientSecret;
        } catch (error) {
            clearTimeout(timeoutId);
            if(error.message === "user_already_has_subscription"){ return error.message;}

            if (error.name === 'AbortError') {
                message("Request timed out", "error");
            } else {
                message(`An error occurred: ${error.message}`, "error");
            }
            return null;
        }
    }

    async function checkPaymentStatus(sessionId) {
        const data = { op: "check_payment_status", session_id: sessionId };
        
        try {
            const response = await fetch(API_URL, {
                method: 'POST',
                headers: {
                    'X-CSRF-Token': CSRF_TOKEN,
                    'Content-Type': 'application/json'
                },
                credentials: 'same-origin',
                body: JSON.stringify(data)
            });
            
            if (!response.ok) {
                throw new Error(`Error: ${response.status} ${response.statusText}`);
            }
            
            return await response.json();
        } catch (error) {
            message(`Error al verificar el pago: ${error.message}`, "error");
            throw error;
        }
    }
    

    // return { createCheckoutSession, checkPaymentStatus };

    return{
        fetchClientSecret,
        checkPaymentStatus
    }
})();

export default paymentService;