const cocounutChartTemplate = document.createElement('template');
cocounutChartTemplate.innerHTML = `
<style>
  :host{
    display:flex;
    flex-grow:1;
    flex-direction:column;
    flex-basis:600px;
    
    height:auto;
    user-select:none;
    overflow-x:auto;
    background:var(--md-sys-color-surface-container-low);
    border-radius:24px;
    padding:24px;
    gap:32px;
    font-family: 'dm-sans', sans-serif;
  }
  :host::-webkit-scrollbar{display:none;}
  @media only screen and (max-width: 680px){
    :host{
      min-height:300px;
      flex-basis:initial;
      max-width:100%;
    }
  }
    

  .bar-container{
    display:flex;
    align-items: flex-end;
    flex-grow:1;
    height:100%;
    border-radius:16px;
  }
  .bar{
    position:relative;
    width:100%;
    height:100%;
    max-height:50%;
    transition:max-height 0.5s;
    border-radius:64px;
    cursor:pointer;
    background:var(--md-sys-color-primary);
    transition: transform .3s cubic-bezier(0,0,0.5,1);
  }
  .bar:hover{
    transform: scale(1.0261290323);

  }
  

  .bar-tooltip{
    display:none;
    flex-direction:column;
    gap:4px;
    min-width:max-content;
    background:var(--md-sys-color-secondary-container);
    color:var(--md-sys-color-on-secondary-container);
    box-shadow: 0px 0px 32px -8px var(--md-sys-color-secondary-container);
    

    padding:8px;
    border-radius:16px;

    position:absolute;
    bottom:CALC(100% + 4px);
    animation: tooltip-in 200ms cubic-bezier(0.1, 0.8, 0, 1);
  }
  .bar:hover .bar-tooltip{
    display:flex;
  }
  @keyframes tooltip-in {
    from {
      opacity: 0;
      transform: translateX(-8px);
    }
    to {
      opacity: 1;
      transform: translateX(0);
    }
  }


  .bar:hover::after {
    content: '';
    position: absolute;
    z-index: 1;
  }
  .bar:hover + .bar-tooltip{
    z-index: 2;
  }

  .bar:hover + .bar-tooltip{
    z-index: 2;
  }

  .bar:hover{
    z-index: 2;
  }
  

  #chart-container{
    display:flex;
    flex-grow:1;
    gap:4px;
  }

  .header{
    display:flex;
    flex-direction:column;
  }

  .headline-small{
    font-family: var(--md-sys-typescale-headline-small-font-family-name);
    font-style: var(--md-sys-typescale-headline-small-font-family-style);
    font-weight: var(--md-sys-typescale-headline-small-font-weight);
    font-size: var(--md-sys-typescale-headline-small-font-size);
    letter-spacing: var(--md-sys-typescale-headline-small-tracking);
    line-height: var(--md-sys-typescale-headline-small-height);
    text-transform: var(--md-sys-typescale-headline-small-text-transform);
    text-decoration: var(--md-sys-typescale-headline-small-text-decoration);
    color:var(--md-sys-color-on-background);
  }
  .headline-medium{
    font-family: var(--md-sys-typescale-headline-medium-font-family-name);
    font-style: var(--md-sys-typescale-headline-medium-font-family-style);
    font-weight: var(--md-sys-typescale-headline-medium-font-weight);
    font-size: var(--md-sys-typescale-headline-medium-font-size);
    letter-spacing: var(--md-sys-typescale-headline-medium-tracking);
    line-height: var(--md-sys-typescale-headline-medium-height);
    text-transform: var(--md-sys-typescale-headline-medium-text-transform);
    text-decoration: var(--md-sys-typescale-headline-medium-text-decoration);
    color:var(--md-sys-color-on-background);
  }
  .body-medium{
    font-family: var(--md-sys-typescale-body-medium-font-family-name);
    font-style: var(--md-sys-typescale-body-medium-font-family-style);
    font-weight: var(--md-sys-typescale-body-medium-font-weight);
    font-size: var(--md-sys-typescale-body-medium-font-size);
    letter-spacing: var(--md-sys-typescale-body-medium-tracking);
    line-height: var(--md-sys-typescale-body-medium-height);
    text-transform: var(--md-sys-typescale-body-medium-text-transform);
    text-decoration: var(--md-sys-typescale-body-medium-text-decoration);
  }
  .body-small{
    font-family: var(--md-sys-typescale-body-small-font-family-name);
    font-style: var(--md-sys-typescale-body-small-font-family-style);
    font-weight: var(--md-sys-typescale-body-small-font-weight);
    font-size: var(--md-sys-typescale-body-small-font-size);
    letter-spacing: var(--md-sys-typescale-body-small-tracking);
    line-height: var(--md-sys-typescale-body-small-height);
    text-transform: var(--md-sys-typescale-body-small-text-transform);
    text-decoration: var(--md-sys-typescale-body-small-text-decoration);
  }
</style>

<div class="header">
  <span class='headline-medium' id='char-title' ></span>
  <span class='headline-small' id='char-subtitle'></span>
</div>

<div id="chart-container">

</div>



`;


class cocounutChart extends HTMLElement {
    
  constructor() {
    super();
    const shadow = this.attachShadow({mode: 'open'});
    shadow.append(cocounutChartTemplate.content.cloneNode(true)); 
  }
  

  connectedCallback() {
    let dataXvalues;
    let dataYvalues;
    let dataXvaluesType;
    let dataYvaluesType;

    if(this.hasAttribute('data-x-values')) {
      dataXvalues = JSON.parse(this.getAttribute('data-x-values'));
    }
    if(this.hasAttribute('data-y-values')) {
      dataYvalues = JSON.parse(this.getAttribute('data-y-values'));
    }
    if(this.hasAttribute('data-x-values-type')) {
      dataXvaluesType = this.getAttribute('data-x-values-type');
    }
    if(this.hasAttribute('data-y-values-type')) {
      dataYvaluesType = this.getAttribute('data-y-values-type');
    }
    if(dataXvalues && dataYvalues){
      this.workValues(dataXvalues, dataYvalues, dataXvaluesType, dataYvaluesType);
    }

    if(this.hasAttribute('data-chart-title')) {
      const chartTitle = this.shadowRoot.getElementById('char-title');
      chartTitle.innerHTML = this.getAttribute('data-chart-title');
    }
    if(this.hasAttribute('data-chart-subtitle')) {
      const chartSubtitle = this.shadowRoot.getElementById('char-subtitle');
      chartSubtitle.innerHTML = this.getAttribute('data-chart-subtitle');
    }
  }

  workValues(dataXvalues, dataYvalues, dataXvaluesType, dataYvaluesType){
    const chartContainer = this.shadowRoot.getElementById('chart-container');
    const maxYvalue = Math.max(...dataYvalues); 
    const barsCount = dataYvalues.length;

    for(let i=0 ; i<barsCount; i++){

      // here we create the bar container and the bar
      const barContainer = document.createElement('div');
      barContainer.classList.add('bar-container');
      const barHeight = (dataYvalues[i] / maxYvalue) * 100;
      const bar = document.createElement('span');
      bar.classList.add('bar');
      bar.style.maxHeight = `${barHeight}%`;
      barContainer.appendChild(bar);

      // here we work the X tooltip and label
      const barTooltip = document.createElement('span');
      barTooltip.classList.add('bar-tooltip');
      const barTooltipXLabel = document.createElement('span');
      barTooltipXLabel.classList.add('body-small');
      switch (dataXvaluesType) {
        case "date":
          barTooltipXLabel.innerHTML = this.formatDay(dataXvalues[i]);
          break;
        default:
          barTooltipXLabel.innerHTML = dataXvalues[i];
          break;
      }
      barTooltip.appendChild(barTooltipXLabel);

      // here we work the Y tooltip and label
      const barTooltipValue = document.createElement('span');
      barTooltipValue.classList.add('body-medium');
      switch (dataYvaluesType) {
        case "money":
          barTooltipValue.innerHTML = this.formatMoney(dataYvalues[i]);
          break;
      
        default:
          barTooltipValue.innerHTML = dataYvalues[i];
          break;
      }
      
      barTooltip.appendChild(barTooltipValue);
      bar.appendChild(barTooltip);

      // append the bar container to the chart container
      chartContainer.appendChild(barContainer);
    }

  }


  formatMoney(value) {
    return value.toLocaleString('es-MX', { style: 'currency', currency: 'MXN' });
  }

  formatDay(date){
    const options = { day: 'numeric', month: 'long' };
    const formattedDate = new Date(date);
    formattedDate.setDate(formattedDate.getDate() + 1);
    return formattedDate.toLocaleDateString('es-MX', options);
  }
}






customElements.define('cocounut-chart', cocounutChart);