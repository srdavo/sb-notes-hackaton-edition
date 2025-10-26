let nav = document.querySelector('nav');
function toggleSection(objetiveSectionId, specialScrollTarget = false) {
  activeSection = document.querySelector('section[active]');
  activeNavButton = nav.querySelector('nav button[active]');
  if (activeSection.id === objetiveSectionId) {
    if(specialScrollTarget){
      document.querySelector(specialScrollTarget).scrollTo({
        top: 0,
        behavior: 'smooth'
      });
      return;
    }

    activeSection.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
    return;
  }

  updateDom(objetiveSectionId);
  function updateDom( objetiveSectionId ) {
    if(activeSection) {activeSection.removeAttribute('active'); activeSection.classList.remove("section-open");}
    if(activeNavButton) {activeNavButton.removeAttribute('active');}
    if(document.getElementById(objetiveSectionId)) {
      document.getElementById(objetiveSectionId).setAttribute('active', '');
      nav.querySelector(`button[data-section="${objetiveSectionId}"]`).setAttribute('active', '');
      document.getElementById(objetiveSectionId).classList.add("section-open");

      if((window.location.pathname).split("/").pop() === "home"){
        localStorage.setItem("currentSection", objetiveSectionId);

      }
    }
  }
}
function resetDialog(dialog){
  if(!dialog){return;}
  const inputs = dialog.querySelectorAll('input, textarea, select, '+ materialT("input"));
  for (let i=0; i<inputs.length; i++){
    inputs[i].value = "";
    inputs[i].removeAttribute('error');
  }
  toggleButton("#"+dialog.id, false);
}
function toggleDialog(dialogId) {
  if (dialogId == '' || dialogId == undefined){
    const openDialog = document.querySelector('md-dialog[open]')
    if(openDialog){
      openDialog.removeAttribute('open');
      openDialog.classList.remove('dialog-active');
      resetDialog(openDialog);
    }
    // resetForm();
    return
  }
  const dialog = document.getElementById(dialogId);
  dialog.setAttribute('open', '');
  dialog.classList.add('dialog-active');

}

// Menus
function toggleMenu(menuId, originButton = false) {
  if(originButton){
    const menu = originButton.nextElementSibling;
    menu.open = !menu.open;
    return;
  }

  const menu = document.getElementById(menuId);
  menu.open = !menu.open;
}


// old
function materialT(elements) {
  const mapping = {
    'option': 'md-select-option',
    'select': 'MD-OUTLINED-SELECT, MD-FILLED-SELECT, md-outlined-select, md-filled-select',
    'select-not-reset': 'md-outlined-select:not(.no-reset), md-filled-select:not(.no-reset)', 
    'button': 'md-outlined-button, md-filled-button, md-filled-tonal-button, md-text-button, md-elevated-button',
    'input': 'md-outlined-text-field, md-filled-text-field',
    'input-not-reset': 'md-outlined-text-field:not(.no-reset), md-filled-text-field:not(.no-reset)',
    'slider': 'md-slider',
    'textarea': 'mwc-textarea',
  };

  const elementList = elements.split(',').map(e => e.trim().toLowerCase());

  const result = [];
  elementList.forEach(element => {
    const mapped = mapping[element];
    if (mapped) {
      result.push(mapped);
    }
  });

  return result.length > 0 ? result.join(', ') : 'Componente no mapeado';
}

function resetForm(parent){
  if (parent) {
    const parentElement = document.querySelector(parent);
    if(!parentElement){return;}
    var inputs = parentElement.querySelectorAll(materialT("input-not-reset")+', textarea, select:not(.no-reset), input:not(.no-reset) ,'+materialT("select-not-reset")+','+materialT("slider"));
  } else {
    var inputs = document.querySelectorAll(materialT("input")+', textarea, select:not(.no-reset), input:not(.no-reset)');
  }
  for (let i=0; i<inputs.length; i++){
    inputs[i].value = "";
    inputs[i].style.background = "";
    inputs[i].classList.remove('error');
  }
}

function resetFormNextGen(parentId){
  if(!parent){return;}
  const parentElement = document.getElementById(parentId);
  if(!parentElement){return;}
  const inputs = parentElement.querySelectorAll(materialT("input-not-reset")+', textarea, select:not(.no-reset), input:not(.no-reset) ,'+materialT("select-not-reset")+','+materialT("slider"));
  for (let i=0; i<inputs.length; i++){
      if(inputs[i].tagName == "select" || inputs[i].tagName == "MD-OUTLINED-SELECT" || inputs[i].tagName == "MD-FILLED-SELECT"){
        inputs[i].querySelectorAll(materialT("option")).forEach(element => {
          element.selected = false;
        });
      }else{
        if(inputs[i].tagName == "MD-SLIDER"){
          inputs[i].value = 50;
        }else{
          inputs[i].value = "";
        }
      }
      
    inputs[i].removeAttribute('error');
    try{inputs[i].reportValidity()} catch(e){}
    inputs[i].style.background = "";
    inputs[i].classList.remove('error');
  }
}

function checkEmpty(parentId, elementToCheck){
  const parentElement = document.querySelector(parentId);
  if(!parentElement){return;}
  const allInputs = parentElement.querySelectorAll(`${materialT(elementToCheck)}, ${elementToCheck}`);

  const inputs = Array.from(allInputs).filter(input => !input.hasAttribute('data-allow-empty'));

  validation = 0;
  for (let i=0; i<inputs.length; i++){
    inputs[i].addEventListener("focus", function() {inputs[i].removeAttribute('error')}, {once: true});
    if(inputs[i].value === "" || inputs[i].value === "0"){ 
      validation = 1; 
      inputs[i].setAttribute('error', '');;
    }
  }
  if(validation != 0){
    // if(type==="dialog"){toggleWindow("#empty_spaces")} 
    return false;
  }else{
    return true
  }
}

function toggleButton(parentId, state, type){
  const parentElement = document.querySelector(parentId);
  if(!parentElement){return;}
  lastButton = parentElement.querySelector(materialT("button"));
  if(type === "submit"){lastButton = parentElement.querySelector('[type="submit"]')}
  if(state){
    lastButton.disabled = true;
  } else {
    lastButton.disabled = false;
  }
}

let currentTimeoutId = null;

function message(message, action){
  const messageElement = document.querySelector("MESSAGE");
  if (action === "error") {messageElement.classList.add('error');}
  if (action === "success") {messageElement.classList.add('success'); }
  
  messageElement.innerHTML = message;
  messageElement.style.display = "flex";
  messageElement.style.animation = "messageIn 0.7s cubic-bezier(0.6, -0.14, 0.02, 1.29)";
  if (currentTimeoutId) {clearTimeout(currentTimeoutId);}
  currentTimeoutId = setTimeout(() => {
      messageElement.style.animation = "messageOut 0.8s";
      setTimeout(() => {
        messageElement.style.display = "none"; 
        currentTimeoutId = null;
        messageElement.className="";
      }, 700);
  }, 4000);
}
function toggleWindowFullSize(){
  if(!document.querySelector('transparent window.active')){return;}

  state = Flip.getState("transparent window.active");
  windowId = document.querySelector('transparent window.active').id;
  document.getElementById(windowId).classList.toggle('full-size');

  timeline = Flip.from(state, {
    // ease: CustomEase.create("custom", "M0,0 C0.308,0.19 0.107,0.633 0.288,0.866 0.382,0.987 0.656,1 1,1 "),
    ease: CustomEase.create("easeName", "0.38,0.49,0,1"),
    targets: "window.active",
    duration: 0.7,
    scale:true,
    simple:true,
  })
  timeline.play();
}
function toggleWindow(windowId, position, scale, appearStyle = false, customOrigin = false){
 
  const caller = new Error().stack.split('\n')[2];
  if (windowId == ''){windowId = null}

  const windowNew = document.querySelector(windowId);
  if(windowNew){
    transparent = windowNew.closest('transparent');
    setTimeout(() => {windowNew.querySelector("HOLDER").scrollTo(0,0)}, 1)
  }else{
    windowActive = document.querySelector("window.active");
    if(!windowActive){return;}
    transparent = windowActive.closest('transparent');
  }


  if (transparent.hasAttribute('data-beautiful_transparent')) {
    transparent.removeAttribute('data-beautiful_transparent');
  }


  
  const activeWindow = transparent.querySelector('window.active');

  function closingAnimation() {
    if (transparent.hasAttribute("closing")) {
      transparent.classList.remove('active');
      transparent.removeAttribute("closing");
      
      activeWindow.classList.remove('active');
    }
  }

  if (activeWindow) {
    if (transparent.hasAttribute("closing")) { return; }
    toggleOvermessage();

    const windowAnimationId = activeWindow.getAttribute("data-window-toggler-id");
    const originButton = document.querySelector(`[data-button-toggler-id="${windowAnimationId}"]`);

    
    transparent.setAttribute("closing", "");
    if(originButton) applyAnimationReverse(Flip.getState(originButton), activeWindow, true, true, false, false)
    
    setTimeout(() => {
      closingAnimation();
    }, 480);

    
    resetFormNextGen(activeWindow.id)
    // resetForm();
    return;
  }
  if (transparent.hasAttribute("closing") && transparent.classList.contains("active")) {
    transparent.removeAttribute("closing");
  }

  transparent.classList.remove('dynamic', 'right', 'left', 'top', 'bottom');


  if (!windowNew) { return; }
  transparent.classList.add('active'); 
  localStorage.setItem("currentWindow", windowId); 

  

  // Set origin element of animation
  if (event && event.currentTarget) {
    element = event.currentTarget;
    if(customOrigin) element = customOrigin;
    windowNew.classList.remove("not-animated");
  }else{
    element = null
    windowNew.classList.add("not-animated");
  }

 
  const randomNumber = Math.random();
  if(element) {
  
    if (element && element.tagName && element.tagName.toLowerCase() === "md-menu-item") {
      const menuTogglerId = element.closest("md-menu").getAttribute("anchor")
      const menuTogglerButton = document.getElementById(menuTogglerId);
      if(menuTogglerButton) element = menuTogglerButton
    }

    element.setAttribute("data-button-toggler-id", randomNumber);
  };
  windowNew.setAttribute("data-window-toggler-id", randomNumber);
  switch (windowId) {
    case "#window-account": 
      getUserData()
    break;
    default: break;
  }

  if(position == "absolute"){
    windowNew.classList.add("absolute");
    var rect = element.getBoundingClientRect();
    screenWidth = window.innerWidth;
    screenHeight = window.innerHeight;
    // Tests
    
    

    if (rect.left < (screenWidth/2)) {
      windowNew.style.right = "unset";
      windowNew.style.left = Math.round(rect.left)+"px";
      transparent.classList.add("left");
    } else{
      windowNew.style.left = "unset";
      windowNew.style.right = screenWidth-Math.round(rect.right)+"px";
      transparent.classList.add("right");
    }

    if (rect.top < (screenHeight/2)) {
      windowNew.style.bottom = "unset";
      windowNew.style.top = (Math.round(rect.top) + Math.round(rect.height) + 8)+"px";
      if(appearStyle){
        windowNew.style.top = (Math.round(rect.top))+"px";
      }
      transparent.classList.add("top");

    }else{
      windowNew.style.top = "unset";
      windowNew.style.bottom = (screenHeight-Math.round(rect.bottom) + Math.round(rect.height) + 8)+"px";
      if(appearStyle){
        windowNew.style.bottom = (screenHeight-Math.round(rect.bottom))+"px";
      }
      transparent.classList.add("bottom");
    }
    
  }
  if(scale === undefined){scale = 0}else{scale = 1}
  animate(element, windowNew, position, scale);
}
function animate(element, windowNew, position, scale){
  let easeType = CustomEase.create("custom", "M0,0 C0.308,0.19 0.107,0.633 0.288,0.866 0.382,0.987 0.656,1 1,1 ");
  if(position === "absolute" && window.innerWidth >= 681){
    easeType = CustomEase.create("custom", "M0,0 C0.249,-0.124 0.04,0.951 0.335,1 0.684,1.057 0.614,0.964 1,1");
  }

  if (scale === 0 || window.innerWidth >= 681) {
    var scaleValue = true;
  }else{
    var scaleValue = false;
  }


  
  let state = Flip.getState(element);
  windowNew.classList.toggle('active');
  Flip.from(state, {
    targets: windowNew,
    duration: 0.7,
    scale: scaleValue,
    ease: easeType,
    absolute: true,
  })
    
}


function currencySymbol() {
  const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
  if (timezone.includes('America')) {
    return '$';
  }
  return '€';
}

function formatMoney(amount) {
  const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
  
  let currency = 'EUR';
  
  // Check if timezone is in Americas
  if (timezone.includes('America')) {
    currency = 'USD';
  }

  return new Intl.NumberFormat('en-US', { 
    style: 'currency', 
    currency: currency 
  }).format(amount);
}
function dateToText(date, showYear) {
  if(showYear === undefined){showYear = false}
  const months = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
  const [year, month, day] = date.split("-");
  if(showYear){
    return `${parseInt(day)} del ${months[month - 1]} de ${year}`;
  }
  return `${parseInt(day)} de ${months[month - 1]}`;
}
function dateToPrettyDate(date, showYear) {
  if(date === "0000-00-00"){return "-";}
  if(showYear === undefined){showYear = false}
  const [year, month, day] = date.split("-");
  if(showYear){
    return `${parseInt(day)}/${month}/${year}`;
  }
  return `${parseInt(day)}/${month}`;
}

function dateToShort(date, showYear = false) {
  if (!date) return '';
  const shortMonths = ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"];
  const [year, month, day] = date.split("-");
  if(showYear){
    return `${parseInt(day)} ${shortMonths[parseInt(month) - 1]} ${year}`;
  }
  return `${parseInt(day)} ${shortMonths[parseInt(month) - 1]}`;
}

function dateToFullText(dateString, showYear = false, showMonth = true) {
  if (!dateString || typeof dateString !== "string") {
    return "Por favor, selecciona una fecha válida.";
  }

  const datePart = dateString.split(" ")[0];
  const parts = datePart.split("-");

  if (parts.length !== 3) {
    return "Formato de fecha inválido. Utiliza YYYY-MM-DD.";
  }

  const [year, month, day] = parts.map(Number);

  if (isNaN(year) || isNaN(month) || isNaN(day)) {
    return "Componentes de fecha inválidos. Utiliza YYYY-MM-DD.";
  }

  const dateObj = new Date(year, month - 1, day);

  if (dateObj.getFullYear() !== year || dateObj.getMonth() !== month - 1 || dateObj.getDate() !== day) {
    return "La fecha proporcionada no es válida (ej. el día no existe en el mes).";
  }

  const options = {
    weekday: 'long', 
    day: 'numeric', 
  };

  if (showMonth) {
    options.month = 'long';  
  }

  if (showYear) {
    options.year = 'numeric'; 
  }

  const formatter = new Intl.DateTimeFormat('es-MX', options);
  let formattedDate = formatter.format(dateObj);

  return formattedDate.charAt(0).toUpperCase() + formattedDate.slice(1);
}

function timeToAmPm(input) {
    if (!input) return '';

    if (input instanceof Date && !isNaN(input)) {
        let hours = input.getHours();
        let minutes = input.getMinutes();
        const ampm = hours >= 12 ? 'PM' : 'AM';

        hours = hours % 12;
        hours = hours ? hours : 12; // La hora '0' (medianoche) se convierte en '12'

        const minutesStr = String(minutes).padStart(2, '0');

        return `${hours}:${minutesStr} ${ampm}`;
    }

    if (typeof input === 'string') {
        let timePart = input;
        
        if (input.includes(' ')) {
            timePart = input.split(' ')[1];
        }

        if (!timePart.includes(':')) return ''; 
        
        const [hoursStr, minutesStr] = timePart.split(':');
        let hour = parseInt(hoursStr, 10);
        
        if (isNaN(hour)) return ''; 

        const ampm = hour >= 12 ? 'PM' : 'AM';
        hour = hour % 12;
        hour = hour ? hour : 12;
        
        return `${hour}:${minutesStr} ${ampm}`;
    }
    
    return '';
}

function formatTime(time){
  if(time === undefined){return;}
  if(time === "00:00:00"){return "-";}
  const [hours, minutes, seconds] = time.split(":");
  return `${hours}:${minutes}`;
}

function toggleMdTab(origin = false, tabId){
  var desiredPanel = false;
  if(origin){
    const desiredPanelId = origin.getAttribute("aria-controls");
    desiredPanel = document.getElementById(desiredPanelId);
  }
  if(!origin && tabId != undefined){
    desiredPanel = document.getElementById(tabId);
  }
  
  if(!desiredPanel) return;
  
  const currentPanel = desiredPanel.parentElement.querySelector("[data-md-panel][active]");
  if(currentPanel) {
    currentPanel.removeAttribute("active");
  }
  desiredPanel.setAttribute("active", "");
}

function applyAnimation(state, target, scale = true, absolute = false, customEase = false, zIndex = false){
  easeToUse = CustomEase.create("custom", "M0,0 C0.308,0.19 0.107,0.633 0.288,0.866 0.382,0.987 0.656,1 1,1 ")
  if(!zIndex){zIndex = 0}else{zIndex = 100}
  if(customEase){easeToUse = CustomEase.create("easeName", "0.38,0.49,0,1")}
  let timeline = Flip.from(state, {
    ease: easeToUse,
    // ease: CustomEase.create("custom", "M0,0 C0.154,0 0.165,0.541 0.324,0.861 0.532,1.281 0.524,1 1,1 "),
    targets: target,
    duration: 0.7,
    absolute:absolute,
    scale:scale,
    zIndex:zIndex,
    simple:true,
  })
  timeline.play();
}

async function applyAnimationReverse(state, target, scale = true, absolute = false, customEase = false, zIndex = false) {
  return new Promise(resolve => {
    let easeToUse = CustomEase.create("custom300", "M0,0 C0.28,0.08 0.10,0.55 0.28,0.78 0.38,0.95 0.64,1 1,1");
    if (!zIndex) { zIndex = 0 } else { zIndex = 100 }
    if (customEase) { easeToUse = CustomEase.create("easeName", "0.38,0.49,0,1") }

    let timeline = Flip.to(state, {
      ease: easeToUse,
      targets: target,
      duration: 0.5,
      absolute: absolute,
      scale: scale,
      zIndex: zIndex,
      simple: true,
      onComplete: () => {
        target.setAttribute("style", "")
        resolve();
      }
    });

    timeline.play();
  });
}

function removeTableRow(row = false){
  if(!row){return;}
  const parentTable = row.closest("table");
  rowsState = Flip.getState(`#${parentTable.id} tr`);
  row.remove();
  let timeline = Flip.from(rowsState, {
      ease: CustomEase.create("custom", "M0,0 C0.308,0.19 0.107,0.633 0.288,0.866 0.382,0.987 0.656,1 1,1 "),
      targets: `#${parentTable.id} tr`,
      absolute:false,
      scale:true,
      simple:true,
  })
  timeline.play();
  countTableRows(parentTable.id);
}

function countTableRows(tableId){
  const table = document.getElementById(tableId);
  const rowsCount = table.querySelectorAll('tr').length;
  
  if(rowsCount <= 1){
    table.querySelector("tr").remove();
    table.parentElement.querySelector(".container-info-empty-table").innerHTML = `
      <div class="content-box on-background-text align-center info-table-empty">
        <md-icon class="pretty medium">sentiment_content</md-icon>
        <span class="headline-small">No hay registros</span>
      </div>
    `;
  }
}

function setDateTime(dateParent, timeParent){
  const date = getDate();
  const time = getTime();

  const dateParentElement = document.getElementById(dateParent);
  const timeParentElement = document.getElementById(timeParent);

  if(dateParentElement){
    dateParentElement.value = `${date.year}-${date.month}-${date.day}`;
  }
  if(timeParentElement){
    timeParentElement.value = `${time.hours}:${time.minutes}`;
  }
}

function getDate(){
  const date = new Date();

  const year = date.getFullYear();
  const month = String(date.getMonth() + 1).padStart(2, '0'); // Los meses van de 0 a 11
  const day = String(date.getDate()).padStart(2, '0');

  const response = {
    "year": year,
    "month": month,
    "day": day,
  }
  return response;
}
function getTime(){
  const date = new Date();

  const hours = String(date.getHours()).padStart(2, '0');
  const minutes = String(date.getMinutes()).padStart(2, '0');

  const response = {
    "hours": hours,
    "minutes": minutes,
  }
  return response;
}

function toggleWSection(wSectionId, originButton){
  if (wSectionId.charAt(0) === '#') {
    wSectionId = wSectionId.substring(1);
  }
  if(originButton === undefined){
    holder = document.getElementById(wSectionId).closest("HOLDER");
  }else{
    holder = originButton.closest("HOLDER");
  }
  if(!holder){
    holder = document.querySelector("window.active")
  }
  const activeWSection = holder.querySelector('.w-section[active]');
  const activeWSectionButton = holder.querySelector('button[active]');
  if(wSectionId === activeWSection.id){return false;}

  const objetiveWSection = holder.querySelector(`#${wSectionId}`);
  const objetiveWSectionButton = holder.querySelector(`button[data-w-section="${wSectionId}"]`);

  const activeWSectionParent = activeWSection.parentElement;
  const objetiveWSectionParent = objetiveWSection.parentElement;

  if(activeWSectionParent !== objetiveWSectionParent){

    var innerActiveWSectionButton = objetiveWSectionParent.querySelector('button[active]');
    var innerActiveWSection = objetiveWSectionParent.querySelector('.w-section[active]');

    if(innerActiveWSectionButton){ innerActiveWSectionButton.removeAttribute('active');}
    if(innerActiveWSection){ innerActiveWSection.removeAttribute('active');}

    objetiveWSection.setAttribute('active', '');
    objetiveWSectionButton.setAttribute('active', '');
    return true;
  }


  if(objetiveWSection){
    if(activeWSection){activeWSection.removeAttribute('active');}
    if(activeWSectionButton){activeWSectionButton.removeAttribute('active');}
    objetiveWSection.setAttribute('active', '');
    if(objetiveWSectionButton){objetiveWSectionButton.setAttribute('active', '');}
  }
  return true;
}

function changeWindow(windowId){
  toggleWindow();
  setTimeout(function() {
    toggleWindow(windowId);
  },520);
}


function toggleOvermessage(overId){
  if (overId == ''){overId = null}
  
  // Close
  const activeOvermessage = document.querySelector(".overmessage.active");
  function closingAnimation() {
    if (activeOvermessage.hasAttribute("closing")) {
      activeOvermessage.classList.remove('active');
      activeOvermessage.removeAttribute("closing");
    }
  }
  if (activeOvermessage) {
    activeOvermessage.setAttribute("closing", "");
    activeOvermessage.addEventListener("animationend", () =>{closingAnimation()}, {once: true})
    return;
  }
  if (activeOvermessage) {
    if (activeOvermessage.hasAttribute("closing") && activeOvermessage.classList.contains("active")) {
      activeOvermessage.removeAttribute("closing");
    }
  }
  

  // Open
  const overmessage = document.querySelector(overId);
  if(!overmessage){ return; }
  overmessage.classList.add("active");

}

function toggleSubSection(subSectionId, options = { exclusive: false, hardExclusive: false, action: null }) {
    const currentMainSection = document.querySelector('section[active]');
    const subSection = document.querySelector(subSectionId);

    const mainParent = subSection.parentElement;
    var activeContent = mainParent.querySelectorAll(':scope > *:not([data-sub-section]:not([active]))');
    activeContent = Array.from(activeContent).filter(element => element !== subSection);

    if (options.exclusive) {
        // Close any other active subsections
        let activeSubSections = currentMainSection.querySelectorAll(`[data-sub-section][active]`);
        if (options.hardExclusive) activeSubSections = [...document.querySelectorAll(`[data-sub-section][active][data-allow-hard-exclusive]`)];
        activeSubSections.forEach(section => {
            if (section.id != subSection.id) {
                section.toggleAttribute('sub-section-in-animation-out');
                section.addEventListener("animationend", () => {
                    section.removeAttribute('sub-section-in-animation-out');
                    section.removeAttribute('active');
                }, { once: true });
            }
        });
    }

    if (subSection.hasAttribute("active") && options.action === "open") return false;
    
    if (!subSection.hasAttribute("active") && options.action === "close") return false;

    if (options.animationType) {
        if (options.animationType === "from-origin") {
            let eventOriginState;
            if (options.customOrigin) {
                eventOriginState = Flip.getState(options.customOrigin);
            } else if (event && event.currentTarget) {
                eventOriginState = Flip.getState(event.currentTarget);
            }

            subSection.toggleAttribute("active");
            subSection.setAttribute("sub-section-simple-in-animation", "");

            Flip.from(eventOriginState, {
                ease: CustomEase.create("custom", "M0,0 C0.308,0.19 0.107,0.633 0.288,0.866 0.382,0.987 0.656,1 1,1 "),
                targets: subSection,
                duration: 0.7,
                toggleClass: "apply-blur-animation-2",
                scale: true,
                onComplete: () => { subSection.removeAttribute("sub-section-simple-in-animation") }
            }).play();
        }
        return;
    }

    if (subSection.hasAttribute('active')) {
        // Close the subsection
        subSection.toggleAttribute('sub-section-in-animation-out');
        subSection.addEventListener("animationend", () => {
            subSection.removeAttribute('sub-section-in-animation-out');

            const activeContentState = Flip.getState(activeContent);
            subSection.removeAttribute('active');

            Flip.from(activeContentState, {
                ease: CustomEase.create("easeName", "0.38,0.49,0,1"),
                duration: .3,
                simple: true,
                absolute: false,
            }).play();

        }, { once: true });
    } else {
        // Open the subsection
        subSection.toggleAttribute('active');
        subSection.toggleAttribute('sub-section-in-animation');
        subSection.addEventListener("animationend", () => {
            subSection.removeAttribute('sub-section-in-animation');
        }, { once: true });
    }
}


function addMinutesToDate(datetime, minutes) {
  const date = new Date(datetime);
  
  if (isNaN(date.getTime())) {
    throw new Error('Fecha inválida proporcionada');
  }
  
  if (!Number.isInteger(minutes)) {
    throw new Error('Los minutos deben ser un número entero');
  }
  
  const newDate = new Date(date.getTime() + (minutes * 60 * 1000));
  
  return newDate;
}

function flowStep(step, parent = document, animations = true){
  const currentOpenStep = parent.querySelector("[data-step][active]");
  if(currentOpenStep){
    if(animations) {
      const lastItem = currentOpenStep.children[currentOpenStep.children.length - 1];
      flowChildsOut(currentOpenStep, {animationVariant: "-bottom"});
      lastItem.addEventListener("animationend", () => {
        currentOpenStep.removeAttribute("active");
        const newStep = parent.querySelector(`[data-step='${step}']`);
        newStep.setAttribute("active", "");
        flowChilds(newStep);
      }, {once: true});
    } else {
      currentOpenStep.removeAttribute("active");
      const newStep = parent.querySelector(`[data-step='${step}']`);
      newStep.setAttribute("active", "");
      Array.from(newStep.children).forEach(el => {
        el.style.opacity = 1;
      });
    }
  } else {
    const newStep = parent.querySelector(`[data-step='${step}']`);
    if(newStep) {
      newStep.setAttribute("active", "");
      if(animations) {
        flowChilds(newStep);
      } else {
        Array.from(newStep.children).forEach(el => {
          el.style.opacity = 1;
        });
      }
    }
  }
}

function flowChilds(parent, options = {startOpacity: 0, animationVariant: "", betweenDelay: 0.05, keepAnimation: false, target: false}){
  options.startOpacity = options.startOpacity || 0;
  options.animationVariant = options.animationVariant || "";
  options.betweenDelay = options.betweenDelay || 0.05;
  options.keepAnimation = options.keepAnimation || false;
  options.target = options.target || false;

  const elements = options.target 
    ? Array.from(parent.querySelectorAll(options.target)) 
    : Array.from(parent.children);

  elements.forEach((el, index) => {
      el.classList.remove("animation-item-out-bottom");

      el.style.opacity = options.startOpacity;
      el.style.animationDelay = `${index * options.betweenDelay}s`; // Retraso de 0.2s por elemento
      el.classList.add(`search-result-item-in${options.animationVariant}`);
      el.addEventListener("animationend", () => {
          if(!options.keepAnimation){
            el.classList.remove(`search-result-item-in${options.animationVariant}`)
            el.style.opacity = 1;
          }
      }, {once: true})
  });
}

function flowChildsOut(parent, options = {startOpacity: 0, animationVariant: "", betweenDelay: 0.05}){
  options.startOpacity = options.startOpacity || 1;
  options.animationVariant = options.animationVariant || "";
  options.betweenDelay = options.betweenDelay || 0.05;

  const parentLastChild = parent.querySelector(":last-child");

  Array.from(parent.children).forEach((el, index) => {
      
    el.style.opacity = options.startOpacity;
    el.style.animationDelay = `${index * options.betweenDelay}s`;
    el.classList.add(`animation-item-out${options.animationVariant}`);
    el.addEventListener("animationend", () => {
        el.classList.remove(`animation-item-out${options.animationVariant}`)
        el.style.opacity = "0"
    }, {once: true})

  });

  parentLastChild.addEventListener("animationend", () => {
    Array.from(parent.children).forEach((el, index) => {
      el.style.opacity = options.startOpacity;
    });
  }, {once: true})


}

function htmlspecialchars(value){
  return value.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;");
}


function convertUTCToLocal(utcDateString) {
  const utcDate = new Date(utcDateString.replace(' ', 'T') + 'Z');
  const options = {
    year: 'numeric',
    month: '2-digit',
    day: '2-digit',
    hour: '2-digit',
    minute: '2-digit',
    second: '2-digit',
    hour12: false // Use 24-hour format
  };

  const formattedDate = new Intl.DateTimeFormat(undefined, options).format(utcDate);

  const parts = new Intl.DateTimeFormat(undefined, options).formatToParts(utcDate);
  const year = parts.find(part => part.type === 'year').value;
  const month = parts.find(part => part.type === 'month').value;
  const day = parts.find(part => part.type === 'day').value;
  const hour = parts.find(part => part.type === 'hour').value;
  const minute = parts.find(part => part.type === 'minute').value;
  const second = parts.find(part => part.type === 'second').value;

  return `${year}-${month}-${day} ${hour}:${minute}:${second}`;
}

function getNaturalDate(date, onlyNatural = false) {
  const now = new Date();
  const dateObj = new Date(date);
  
  const today = new Date(now.getFullYear(), now.getMonth(), now.getDate());
  const compareDate = new Date(dateObj.getFullYear(), dateObj.getMonth(), dateObj.getDate());
  
  const timeDiff = compareDate - today;
  const daysDiff = Math.ceil(timeDiff / (1000 * 60 * 60 * 24));
  
  const weekdays = ['domingo', 'lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado'];
  const weekdayName = weekdays[dateObj.getDay()];
  
  // Special cases
  if (daysDiff === 0) {
    return 'Hoy';
  } else if (daysDiff === 1) {
    return 'Mañana';
  } else if (daysDiff === -1) {
    return 'Ayer';
  } else if (daysDiff === 2) {
    return 'Pasado mañana';
  } else if (daysDiff === -2) {
    return 'Anteayer';
  }
  
  if (daysDiff > 0 && daysDiff <= 6) {
    return `Este ${weekdayName}`;
  } else if (daysDiff < 0 && daysDiff >= -6) {
    return `El ${weekdayName} pasado`;
  }
  
  if (daysDiff > 6 && daysDiff <= 13) {
    return `El próximo ${weekdayName}`;
  } else if (daysDiff < -6 && daysDiff >= -13) {
    return `El ${weekdayName} de la semana pasada`;
  }
  
  if (onlyNatural) {
    return null; // Don't return typical dates when onlyNatural is true
  }
  
  const months = [
    'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio',
    'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'
  ];
  
  const day = dateObj.getDate();
  const month = months[dateObj.getMonth()];
  const year = dateObj.getFullYear();
  const currentYear = now.getFullYear();
  
  if (year === currentYear) {
    return `${day} de ${month}`;
  } else {
    return `${day} de ${month} de ${year}`;
  }
}

function buildPagination(paginationData, page, container, actionFunction, additionalParams = {}){
  const totalRows = paginationData.total_rows;
  const limit = paginationData.limit;

  const pageCount = Math.ceil(totalRows / limit);
  if(pageCount <= 1){container.innerHTML = ""; return;}

  const currentPage = page;

  const pagesToShow = new Set();
  pagesToShow.add(0); // First page
  const rangeStart = Math.max(0, currentPage - 2);
  const rangeEnd = Math.min(pageCount - 1, currentPage + 2);
  for (let i = rangeStart; i <= rangeEnd; i++) pagesToShow.add(i);
  pagesToShow.add(pageCount - 1); // Last page
  const pagesArray = Array.from(pagesToShow).sort((a, b) => a - b);
  let paginationHTML = `<span class='user-select-none simple-container width-100 flex-wrap gap-4' style='overflow:auto;content-visibility: auto;'>`;
  let previousPage = null;
  for (const pageNumber of pagesArray) {
      if (previousPage !== null && pageNumber - previousPage > 1) {
          paginationHTML += `<span class="pagination-ellipsis" style="display: inline-flex;align-items: center;padding: 0 8px;color: #666;">...</span>`;
      }
      if (pageNumber === currentPage) {
          paginationHTML += `<button class="style-2" active data-page='${pageNumber}'>${pageNumber + 1}</button>`;
      } else {
          paginationHTML += `<button class="style-2" style="content-visibility: auto;" data-page='${pageNumber}'>${pageNumber + 1}</button>`;
      }
      previousPage = pageNumber;
  }
  paginationHTML += `</span>`;

  container.innerHTML = paginationHTML;

  const buttons = container.querySelectorAll("[data-page]");
  buttons.forEach(button => {
      button.addEventListener("click", async () => {
          const newPage = parseInt(button.getAttribute("data-page"));
          
          button.disabled = true;
          
          await actionFunction(newPage, ...Object.values(additionalParams));

          button.disabled = false;

      })
  })
}

function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        message("Copiado al portapapeles", "success");
    }).catch(err => {
        console.error('Error al copiar el enlace: ', err);
    });
}

function fillForm(form, data, skipFields = []){
  if(!form || !data) return;

  const inputs = form.querySelectorAll("input, select, textarea");
  inputs.forEach(input => {
    const name = input.name || input.id;
    if(name && data[name] !== undefined && !skipFields.includes(name)){
      if(input.type === "checkbox" || input.type === "radio"){
        input.checked = data[name];
      }else{
        input.value = data[name];
      }
    }
  });

  const selects = form.querySelectorAll("md-select");
  selects.forEach(select => {
    const name = select.getAttribute("name") || select.id;
    if(name && data[name] !== undefined && !skipFields.includes(name)){
      select.value = data[name];
    }
  });

  const namedElements = form.querySelectorAll("[name]");
  namedElements.forEach(element => {
    if(element.tagName === "INPUT" || element.tagName === "SELECT" || element.tagName === "TEXTAREA" || 
       element.tagName === "MD-SELECT") return;
    
    const name = element.getAttribute("name");
    if(name && data[name] !== undefined && !skipFields.includes(name)){
      element.textContent = data[name];
    }
  });
}

function mdSelect(element, value) {
  const selectElement = typeof element === 'string' ? document.querySelector(element) : element;
  
  if (!selectElement) return;
  
  if (selectElement.tagName.toLowerCase() === 'select') {
    const optionIndex = Array.from(selectElement.options).findIndex(option => option.value == value);
    selectElement.selectedIndex = optionIndex >= 0 ? optionIndex : 0;
  } 
  else if (selectElement.tagName.toLowerCase().startsWith('md-')) {
    const options = Array.from(selectElement.querySelectorAll('md-select-option, option'));
    const optionIndex = options.findIndex(option => option.value == value);
    selectElement.selectedIndex = optionIndex >= 0 ? optionIndex : 0;
  }
  
  // Trigger a change event to ensure the UI updates
  selectElement.dispatchEvent(new Event('change', { bubbles: true }));
}
