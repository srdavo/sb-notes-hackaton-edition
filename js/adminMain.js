import AdminManager from './managers/adminManager.js?v=3';

(async function adminMain() {

    console.log("adminMain.js");

    try {


        // AdminManager.openAdminPanel();

        const openAdminPanelButton = document.getElementById("open-admin-panel-button");
        if(openAdminPanelButton){
            openAdminPanelButton.addEventListener("click", () => {
                AdminManager.openAdminPanel();
            });
        }
        
    } catch (error) {
        console.error("An unexpected error occurred.");
    }


})();