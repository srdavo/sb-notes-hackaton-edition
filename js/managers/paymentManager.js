import paymentService from './../services/paymentService.js';
const PaymentManager = (() => {

    // var stripe = Stripe('pk_test_51QwzTfDcSR1yu2iFFCQyaXXe1VJoE4WHn63GejgyTJNAh8JX4t8FR4DIRgoYP6gzAxCMBh4WeipnX2jTmU2CgDLV00aaazkUoh');
    var stripe = Stripe('pk_live_51QwzTfDcSR1yu2iFC3UyZUTzdhNrRi9fdU2hFetWcrpQauxxahAvYYURgJAkcJHsE8H1yNWCMxnv3l8qJoln86yA00uAPX4mtN');

    async function initializeCheckout() {
        const clientSecret = await paymentService.fetchClientSecret();
        if(clientSecret === "user_already_has_subscription"){
            document.querySelector("#checkout").innerHTML = `
                <div class="simple-container grow-1 width-100 max-width-800 justify-center direction-column gap-16">
                    <md-icon class="pretty-minimal primary-text filled">sentiment_very_satisfied</md-icon>
                    <span class="display-small on-background-text weight-600 dm-sans">Tú ya tienes una suscripción</span>
                        <md-outlined-button class="width-100" href='./apps/mind/home'>Volver </md-outlined-button>
                </div>
                `;
            return;
        }

        const checkout = await stripe.initEmbeddedCheckout({
            clientSecret
        });


        // Mount Checkout
        checkout.mount('#checkout');
        return true;
    }

    async function checkPaymentStatus(sessionId){

        const result = await paymentService.checkPaymentStatus(sessionId);
        console.log(result)

        // if (result.status === 'complete') {
        //     document.getElementById('payment-status').innerHTML = `
        //         <p class="success">¡Pago exitoso! Tu cuenta ha sido actualizada a Pro.</p>
        //         <md-filled-button href='apps/mind/home'>Continuar a la app</md-filled-button>    
        //     `;
                 
        //     // Actualizar la interfaz para reflejar funcionalidades Pro
        //     // ...
            
        //     // Redirigir al dashboard después de unos segundos
        //     // setTimeout(() => {
        //     //     window.location.href = '/codemelon/dashboard';
        //     // }, 5000);
        // } else {
        //     document.getElementById('payment-status').innerHTML = 
        //         '<p class="error">Hubo un problema con el pago. Por favor, intenta nuevamente.</p>';
        // }
        return result;
    }
    return{
        initializeCheckout,
        checkPaymentStatus
    }
})();

export default PaymentManager;


