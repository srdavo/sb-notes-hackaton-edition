import EmailManager from "./managers/EmailManager.js";

(async function main() {

    try{

        window.EmailManager = EmailManager;

        setupGlobalEvents();

    }catch(error){
        console.error(error);
    }

})();

function setupGlobalEvents(){
    
    const sendEmailForm = document.getElementById("form-contact-us");
    sendEmailForm.addEventListener("submit", async (event) => {
        event.preventDefault();
        EmailManager.sendEmail();
    });

    const buttonCopyContactEmail = document.getElementById("copy-contact-email");
    buttonCopyContactEmail.addEventListener("click", async (event) => {
        EmailManager.copyContactEmail();
    });

}

/**
 * Desarrollado por Luis David Elizarraraz Mondaca ("Davo")
 * GitHub: https://github.com/srdavo
 * Basado en Stepbro Software: https://stepbro.site
 */