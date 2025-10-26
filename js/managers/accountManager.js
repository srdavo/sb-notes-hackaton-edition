import accountService from './../services/accountService.js?v=3';

const AccountManager = (() => {

    const signUpWindow = document.getElementById("window-signup");
    if(signUpWindow){ var signUpForm = signUpWindow.querySelector("form") }

    const logInWindow = document.getElementById("window-login");
    if(logInWindow){ var logInForm = logInWindow.querySelector("form") }

    let appLoadingIndicator = document.getElementById("main-app-loading-indicator");
    

    function openSignUpWindow(){
        toggleWindow("#window-signup");
        signUpForm.onsubmit = (event) => createAccount(event);
    }
    function openLogInWindow(){
        toggleWindow("#window-login");
        logInForm.onsubmit = (event) => logIn(event);
    }

    async function createAccount(event = false){
        if(!event) return;
        event.preventDefault();

        if(!checkEmpty(`#${signUpWindow.id}`, "input")) { return; }

        // const name = signUpForm.querySelector("[name='name']");
        const email = signUpForm.querySelector("[name='email']");
        const password = signUpForm.querySelector("[name='password']");
        const repeatPassword = signUpForm.querySelector("[name='repeat-password']");
        const buttonSubmit = signUpForm.querySelector("[type='submit']");
        const rememberMe = signUpForm.remember_me.checked;

        const terms = signUpForm.terms.checked;
        if(!terms){
            signUpForm.terms.classList.add("animation-shake");
            signUpForm.terms.addEventListener("animationend", () => {
                signUpForm.terms.classList.remove("animation-shake");
            }, {once: true});
            message(`Debes aceptar la Política de Privacidad y los Términos y Condiciones`, "error");
            return;
        }

        if(!validatePasswords(password, repeatPassword)) return;
        if(!validateEmail(email)) return;

        buttonSubmit.setAttribute("disabled", "true");
        
        const data = {
            // name: name.value,
            email: email.value,
            password: password.value,
            password_repeat: repeatPassword.value,
            remember_me: rememberMe,
            terms: terms,
        }

        const result = await accountService.signUp(data);
        buttonSubmit.removeAttribute("disabled");
        if(!result) return;

        if(result === "email_taken"){
            email.setAttribute("error", "");
            message("El correo ya esta en uso", "error");
            return;
        }

        if(result.success === false){
            message(result.message, "error");
            return;
        }
        
        window.location.href="home";
        return true;
    }

    function validatePasswords(password, repeatPassword){
        if(password.value !== repeatPassword.value){
            password.setAttribute("error", "");
            repeatPassword.setAttribute("error", "");
            message("Las contraseñas no coinciden", "error");
            return false;
        }
        return true;
    }

    function validateEmail(input) {
        const regex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        if (!regex.test(input.value)) {
            message("El correo no es valido", "error");
            input.setAttribute("error", "");
            return false;
        }
        return true;
    }


    async function logIn(event = false){
        if(!event) return;
        event.preventDefault();

        if(!checkEmpty(`#${logInWindow.id}`, "input")) { return; }

        const email = logInForm.querySelector("[name='email']");
        const password = logInForm.querySelector("[name='password']");
        const buttonSubmit = logInForm.querySelector("[type='submit']");
        const rememberMe = logInForm.remember_me.checked;

        const terms = logInForm.terms.checked;
        if(!terms){
            logInForm.terms.classList.add("animation-shake");
            logInForm.terms.addEventListener("animationend", () => {
                logInForm.terms.classList.remove("animation-shake");
            }, {once: true});
            message(`Debes aceptar la Política de Privacidad y los Términos y Condiciones`, "error");
            return;
        }

        if(!validateEmail(email)) return;

        buttonSubmit.setAttribute("disabled", "true");

        const data = {
            email: email.value,
            password: password.value,
            remember_me: rememberMe,
            terms: terms,
        }

        const result = await accountService.logIn(data);
        buttonSubmit.removeAttribute("disabled");
        if(!result) return;

        if(result === "invalid_credentials"){
            email.setAttribute("error", "");
            password.setAttribute("error", "");
            message("Credenciales invalidas", "error");
            return;
        }
        if(result === "google_account"){
            message("Inicia sesion con Google", "error");
            return;
        }

        if(result.success === false){
            message(result.message, "error");
            return;
        }

        message("Sesion iniciada", "success");
        window.location.href="home";
        return true;
        // location.reload();
    }

    async function rememberMe(){
        const rememberMeToken = getCookie("codemelon-remember_me_js_accessible");
        if(!rememberMeToken) return false;


        const path = window.location.pathname;
        const page = path.split("/").pop();
        const queryString = window.location.search;
        const fullPage = page + queryString;
        
        
        const checkSession = await accountService.checkSession();
        if(!checkSession) return false;
        if(checkSession.session === true) return false;

        const result = await accountService.rememberMe(rememberMeToken);
        if(result === "invalid_token_180"){
            message("<div class='simple-container gap-8 padding-8 direction-column'>Token de acceso invalido, por favor vuelve a iniciar sesión <md-outlined-button onclick='logOut(true);'>Cerrar sesión</md-outlined-button></div>", "error");
        }
        if(!result.success) return false;

        console.log(result);

        if(fullPage === "index?redirect"){
            window.location.href="home";
        } else if(fullPage === "index" || fullPage === ""){
            window.location.reload();
        }else if(fullPage === "login"){
            window.location.href="home";
        }
        
        return true;
    }

    function getCookie(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        if (parts.length === 2) {
            let cookieValue = parts.pop().split(';').shift();
            try {
                cookieValue = decodeURIComponent(cookieValue);
            } catch (e) {
                // Handle potential decoding error (e.g., malformed encoded value)
                console.error("Error decoding cookie value:", e);
                return null; 
            }
            return cookieValue;
        }
        return null;
    }

    async function logOut(goIndex = false){
        const result = await accountService.logOut();
        if(!result) return;
        if(goIndex) {
            window.location.href = "index";
            return;
        }
        window.location.reload();
    }


    async function handleCredentialResponse(response){
        const body = document.querySelector("body");

        body.style.pointerEvents = "none";
        body.style.transition = "opacity 1s";
        body.style.opacity = "0.3";

        const result = await accountService.handleCredentialResponse(response);
        body.style.pointerEvents = "initial";
        body.style.opacity = "1";
        
        if(!result) return;
        if(result.success){
            body.style.pointerEvents = "none";
            body.style.transition = "opacity 1s";
            window.location.href="home";
        }
        if(result === "not_a_google_account"){
            message("Credenciales invalidas", "error");
        }
        
        return;
    }

    async function syncUserData(){
        const windowSettings = document.getElementById("window-settings");
        if(!windowSettings){ return; }       
        
        const userData = await accountService.getUserData();
        if(!userData) return;

        const uernameFields = windowSettings.querySelectorAll("[name='account-username']");
        const emailFields = windowSettings.querySelectorAll("[name='account-email']");
        const idFields = windowSettings.querySelectorAll("[name='account-id']");
        const firstLetterFields = document.querySelectorAll("[name='account-first-letter']");

        uernameFields.forEach(field => {
            field.value = userData.name;
            field.innerHTML = (userData.name == "") ? "<i class='outline-text'>Sin nombre de usuario</i>" : userData.name;
        });

        emailFields.forEach(field => {
            field.value = userData.email;
            field.innerText = userData.email;
        });

        idFields.forEach(field => {
            field.value = userData.id;
            field.innerText = userData.id;
        });

        firstLetterFields.forEach(field => {
            if(userData.name){
                field.innerText = userData.name.charAt(0).toUpperCase();
            } else {
                field.innerText = userData.email.charAt(0).toUpperCase();
            }
        });
    }

    async function modidfyUserData(){
        
        const dialogAccount = document.getElementById("dialog-account");
        if(!dialogAccount){ return; }
        if(!checkEmpty(`#${dialogAccount.id}`, "input")) { return; }

        const name = dialogAccount.querySelector("[name='account-username']");
        if(name.value === document.getElementById("response-settings-account-username").innerText){
            message("No hay cambios que guardar", "error");
            return;
        }

        const data = {
            name: name.value,
        }

        const result = await accountService.modifyUserData(data);
        if(!result) return;

        if(result === "name_taken"){
            name.setAttribute("error", "");
            message("El nombre de usuario ya esta en uso", "error");
            return;
        }

        toggleDialog();
        message("Datos actualizados", "success");
        syncUserData();

        return true;
    }


    async function registerAccess(){
        const data = {
            app: getCurrentApp(),
            device: detectDevice()
        }
        const result = await accountService.registerAccess(data);
        if(!result) return;
        return result.success;
    }

    function getCurrentApp(){
        const path = window.location.pathname;
        const pathParts = path.split("/");
        const page = pathParts.pop();
        const folder = pathParts.pop() || 'root'; // Handle root case

        return folder;
    }

    function detectDevice() {
        const userAgent = navigator.userAgent || navigator.vendor || window.opera;
        if (/iPhone|iPad|iPod/i.test(userAgent)) { return "iOS (iPhone/iPad)";}
        if (/android/i.test(userAgent)) { return "Android";}
        if (/windows phone/i.test(userAgent)) { return "Windows Phone";}
        if (/tablet|ipad|playbook|silk/i.test(userAgent)) { return "Tablet";}
        if (/mobile|iphone|ipod|android|blackberry|opera mini|windows phone/i.test(userAgent)) {return "Mobile";}
        return "Desktop";
    }


    function openForgotPasswordWindow(){
        changeWindow("#window-forgot-password");
        flowStep(1, windowForgotPassword, false);
    }
  
    const windowForgotPassword = document.getElementById("window-forgot-password");
    const formForgotPassword = document.getElementById("form-forgot-password");
    const formSendForgotPasswordToken = document.getElementById("form-send-forgot-password-token");
    const formUpdatePassword = document.getElementById("form-update-password");

    let forgotPasswordEmail = null;
    let forgotPasswordToken = null;

    if(formForgotPassword){formForgotPassword.addEventListener("submit", (event) => sendPasswordResetRequest(event));}
    if(formSendForgotPasswordToken){formSendForgotPasswordToken.addEventListener("submit", (event) => sendForgotPasswordToken(event));}
    if(formUpdatePassword){formUpdatePassword.addEventListener("submit", (event) => updatePassword(event) );}

    async function sendPasswordResetRequest(event){
        if(event) event.preventDefault();
        if(!checkEmpty(`#${formForgotPassword.id}`, "input")) { return; }

        const emailField = formForgotPassword.email;
        if(!validateEmail(emailField)) return;

        const buttonSubmit = formForgotPassword.querySelector("[type='submit']");
        
        windowForgotPassword.classList.add("animation-loading-1");
        buttonSubmit.setAttribute("disabled", "true");
        const result = await accountService.sendPasswordResetRequest({email: emailField.value});
        windowForgotPassword.classList.remove("animation-loading-1");
        buttonSubmit.removeAttribute("disabled");
        if(!result) return;

        windowForgotPassword.querySelector("[name='container-email']").textContent = emailField.value;

        // Ir a siguiente paso
        flowStep(2, windowForgotPassword);
        forgotPasswordEmail = emailField.value;

    }

    async function sendForgotPasswordToken(event){
        if(event) event.preventDefault();
        if(!checkEmpty(`#${formSendForgotPasswordToken.id}`, "input")) { return; }

        const tokenField = formSendForgotPasswordToken.token;
        const buttonSubmit = formSendForgotPasswordToken.querySelector("[type='submit']");


        buttonSubmit.setAttribute("disabled", "true");        
        windowForgotPassword.classList.add("animation-loading-1");
        const result = await accountService.sendForgotPasswordToken({token: tokenField.value, email: forgotPasswordEmail});
        windowForgotPassword.classList.remove("animation-loading-1");
        buttonSubmit.removeAttribute("disabled");
        if(!result) return;

        flowStep(3, windowForgotPassword);
        forgotPasswordToken = tokenField.value;
    }

    async function updatePassword(event){
        if(event) event.preventDefault();
        if(!checkEmpty(`#${formUpdatePassword.id}`, "input")) { return; }

        const passwordField = formUpdatePassword.password;
        const repeatPasswordField = formUpdatePassword.repeat_password;
        const buttonSubmit = formUpdatePassword.querySelector("[type='submit']");

        if(!validatePasswords(passwordField, repeatPasswordField)) return;

        buttonSubmit.setAttribute("disabled", "true");
        windowForgotPassword.classList.add("animation-loading-1");
        
        const result = await accountService.updatePassword({
            email: forgotPasswordEmail,
            token: forgotPasswordToken,
            password: passwordField.value,
            password_repeat: repeatPasswordField.value
        });

        windowForgotPassword.classList.remove("animation-loading-1");
        buttonSubmit.removeAttribute("disabled");
        if(!result) return;

        flowStep(4, windowForgotPassword);
    }


    window.registerAccess = registerAccess;
    window.handleCredentialResponse = handleCredentialResponse;    
    window.logOut = logOut;
    return {
        openSignUpWindow,
        openLogInWindow,
        rememberMe,
        logOut,
        syncUserData,
        modidfyUserData,
        openForgotPasswordWindow
    };

})();

export default AccountManager;