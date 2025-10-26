export class PrettyMenu {
    constructor(config = {}){

        this.menu = config.menu || null;

        if(!this.menu) throw new Error("PrettyMenu: menu element is required in config");
        this.startingStep = config.startingStep || this.menu.querySelector("[data-menu-step-active]");


        this.#setupEventListeners();
    }

    #setupEventListeners(){
        this.menu.addEventListener("click", (event) => {
            this.#handleStepChange(event.target);
        })

        // Click fuera del menú para regresar al startingStep
        document.addEventListener("click", (event) => {
            if(!this.menu.contains(event.target)){
                // Pequeño delay para verificar que el menú sigue visible
                setTimeout(() => {
                    // Verificar que el menú no se haya ocultado usando checkVisibility()
                    const isVisible = this.menu.checkVisibility();
                    if(isVisible){
                        this.#returnToStartingStep();
                    }
                }, 10);
            }
        })
    }

    #returnToStartingStep(){
        const currentStep = this.menu.querySelector("[data-menu-step-active]");
        const startingStepName = this.startingStep.getAttribute("data-menu-step-name");
        const currentStepName = currentStep.getAttribute("data-menu-step-name");

        // Si ya estamos en el startingStep, no hacer nada
        if(startingStepName === currentStepName) return;

        const startingStepMenuStyle = this.startingStep.getAttribute("data-menu-style");

        const currentStepAnimationScale = currentStep.getAttribute("data-menu-animation-scale") === "true";
        const startingStepAnimationScale = this.startingStep.getAttribute("data-menu-animation-scale") === "true";
        const animationScale = currentStepAnimationScale || startingStepAnimationScale;

        const currentStepAnimationStyle = currentStep.getAttribute("data-menu-animation-style");
        const startingStepAnimationStyle = this.startingStep.getAttribute("data-menu-animation-style");
        const animationStyle = currentStepAnimationStyle || startingStepAnimationStyle;

        this.#animateTransition(currentStep, this.startingStep, startingStepMenuStyle, animationScale, animationStyle);
    }

    #handleStepChange(origin){
        if(!origin) return;

        // Buscar el elemento con data-menu-step-target, incluyendo elementos padre
        const targetElement = origin.closest("[data-menu-step-target]");
        console.log(targetElement);
        if(!targetElement) return;

        const targetStep = targetElement.getAttribute("data-menu-step-target");
        if(!targetStep) return;
        const targetStepElement = this.menu.querySelector(`[data-menu-step-name="${targetStep}"]`);
        const currentStep = this.menu.querySelector("[data-menu-step-active]");
        
        const targetStepMenuStyle = targetStepElement.getAttribute("data-menu-style");

        const currentStepAnimationScale = currentStep.getAttribute("data-menu-animation-scale") === "true";
        const targetStepAnimationScale = targetStepElement.getAttribute("data-menu-animation-scale") === "true";
        const animationScale = currentStepAnimationScale || targetStepAnimationScale;

        const currentStepAnimationStyle = currentStep.getAttribute("data-menu-animation-style");
        const targetStepAnimationStyle = targetStepElement.getAttribute("data-menu-animation-style");
        const animationStyle = currentStepAnimationStyle || targetStepAnimationStyle;

        this.#animateTransition(currentStep, targetStepElement, targetStepMenuStyle, animationScale, animationStyle);
    }

    #animateTransition(currentStep, targetStepElement, targetStepMenuStyle, animationScale = false, animationStyle = null){
        targetStepElement.setAttribute("data-flip-id", "animate");
        currentStep.setAttribute("data-flip-id", "animate");

        targetStepElement.style.minWidth = `initial`;
        targetStepElement.style.maxWidth = `initial`;
        

        // props
        const currentStepBorderRadius = window.getComputedStyle(currentStep).borderRadius;
        const currentStepBackground = window.getComputedStyle(currentStep).background;
        const currentStepBoxShadow = window.getComputedStyle(currentStep).boxShadow;

        const targetStepBorderRadius = window.getComputedStyle(targetStepElement).borderRadius;
        const targetStepBackground = window.getComputedStyle(targetStepElement).background;
        const targetStepBoxShadow = window.getComputedStyle(targetStepElement).boxShadow;

        // Detectar si es mobile o desktop
        const isMobile = window.innerWidth <= 680;
        
        // Detectar si hay cambio de clase de estilo
        const currentMenuStyle = Array.from(this.menu.classList).find(className => className.startsWith("style-"));
        const hasStyleChange = !!(currentMenuStyle !== targetStepMenuStyle && (currentMenuStyle || targetStepMenuStyle));
        
        // Usar absolute: true solo en desktop Y cuando hay cambio de clase de estilo
        const useAbsolute = !isMobile && hasStyleChange;

        this.menu.style.borderRadius = currentStepBorderRadius;
        this.menu.style.background = currentStepBackground;
        this.menu.style.boxShadow = currentStepBoxShadow;
        //
        const menuState = Flip.getState(this.menu);
        const targetStepElementState = Flip.getState(targetStepElement);
        const currentStepState = Flip.getState(currentStep);

        
        
        currentStep.removeAttribute("data-menu-step-active");
        targetStepElement.setAttribute("data-menu-step-active", true);
        
        
        this.menu.classList.forEach(className => {
            if(className.startsWith("style-")){
                this.menu.classList.remove(className);
            }
        });
        
        if(targetStepMenuStyle){
            this.menu.classList.add(targetStepMenuStyle);
        }


        const contentWidth = targetStepElement.getBoundingClientRect().width;
        
        targetStepElement.style.minWidth = `${contentWidth}px`;
        targetStepElement.style.maxWidth = `${contentWidth}px`; 
        this.menu.style.borderRadius = targetStepBorderRadius;
        this.menu.style.background = targetStepBackground;
        this.menu.style.boxShadow = targetStepBoxShadow;
        
        
        console.log(useAbsolute);
        
        // Determinar configuración de animación basada en animationStyle
        const isElastic = animationStyle === "elastic";
        const flipDuration = isElastic ? 0.7 : 0.5;
        const flipEase = isElastic ? "elastic.out(0.5,0.5)" : CustomEase.create("easeName", "0.38,0.49,0,1");
        const flipScale = isElastic ? true : animationScale;

        // Aplicar overflow: initial y background transparente cuando es elastic
        if(isElastic){
            this.menu.style.overflow = "initial";
            this.menu.style.background = "transparent";
            this.menu.style.boxShadow = "none";
        } else {
            this.menu.style.overflow = "";
        }

        Flip.from(menuState, {
            duration: flipDuration,
            ease: flipEase,
            // ease: CustomEase.create("custom", "M0,0 C0.308,0.19 0.107,0.633 0.288,0.866 0.382,0.987 0.656,1 1,1 "),

            // props: "borderRadius,background",
            absolute: true,
            // zIndex: 99999,
            // fade:true,
            scale:false,
            simple:true,
            ...(isElastic && {
                custom: {
                    x: { ease: "elastic.out(0.7,0.4)", duration: 0.7 },
                    y: { ease: "elastic.out(0.7,0.4)", duration: 0.7 }
                }
            }),
            onComplete: () => {
                targetStepElement.style.minWidth = null;
                targetStepElement.style.maxWidth = null;
            }
        })
        Flip.from(currentStepState, {
            targets: targetStepElement,
            duration: flipDuration,
            ease: flipEase,
            // ease: CustomEase.create("custom", "M0,0 C0.308,0.19 0.107,0.633 0.288,0.866 0.382,0.987 0.656,1 1,1 "),
    
            absolute:true,
            zIndex: 10,
            // props: "borderRadius,background",
            scale: flipScale,
            simple:true,
            fade:true,
            ...(isElastic && {
                custom: {
                    x: { ease: "elastic.out(0.7,0.4)", duration: 0.7 },
                    y: { ease: "elastic.out(0.7,0.4)", duration: 0.7 }
                }
            }),
            toggleClass: "sb-menu-items-blur",
        })
    }   
}