<window
    id="window-theme"
    class=""
    data-flip-id="animate"
    >
    <div class="simple-container padding-16 justify-between">
        <md-icon-button onclick="toggleWindow()"><md-icon>close</md-icon></md-icon-button>
    </div>
    <holder>
        <div class="theme-selector-parent v-margin" id="app-theme-selector-parent">
            <div 
                class="ball" 
                data-theme="black"
                onclick="changeTheme(this)" 
                >
                <span style="background:#000000;"></span>
                <span style="background:#122644;"></span>
                <span style="background:#b4c7ed;"></span>
                <md-ripple></md-ripple>
            </div>
            <div 
                class="ball" 
                data-theme="blue"
                onclick="changeTheme(this)"
                >
                <span style="background:#0045b2;"></span>
                <span style="background:#0066ff;"></span>
                <span style="background:#b3c5ff;"></span>
                <md-ripple></md-ripple>
            </div>
            <div 
                class="ball" 
                data-theme="green"
                onclick="changeTheme(this)"
                >
                <span style="background:#006d34;"></span>
                <span style="background:#5de989;"></span>
                <span style="background:#9fffb3;"></span>
                <md-ripple></md-ripple>
            </div>
            <div 
                class="ball" 
                data-theme="brown"
                onclick="changeTheme(this)"
                >
                <span style="background:#944b00;"></span>
                <span style="background:#ff9947;"></span>
                <span style="background:#ffbc8d;"></span>
                <md-ripple></md-ripple>
            </div>
            <div 
                class="ball" 
                data-theme="cold-blue"
                onclick="changeTheme(this)"
                >
                <span style="background:#006590;"></span>
                <span style="background:#55c0ff;"></span>
                <span style="background:#96d3ff;"></span>
                <md-ripple></md-ripple>
            </div>
            <div 
                class="ball" 
                data-theme="pink"
                onclick="changeTheme(this)"
                >
                <span style="background:#8900a3;"></span>
                <span style="background:#c400e8;"></span>
                <span style="background:#f7acff;"></span>
                <md-ripple></md-ripple>
            </div>
            <div 
                class="ball" 
                data-theme="purple"
                onclick="changeTheme(this)"
                >
                <span style="background:#5e00d0;"></span>
                <span style="background:#853fff;"></span>
                <span style="background:#d2bcff;"></span>
                <md-ripple></md-ripple>
            </div>
            <div 
                class="ball" 
                data-theme="oled"
                onclick="changeTheme(this)"
                active
                >
                <span style="background:#000000;"></span>
                <span style="background:#0f0f0f;"></span>
                <span style="background:#0a0a0a;"></span>
                <md-ripple></md-ripple>
            </div>
            <div 
                class="ball" 
                data-theme="super-blue"
                onclick="changeTheme(this)"
                >
                <span style="background:#0028db;"></span>
                <span style="background:#4058ff;"></span>
                <span style="background:#afb8ff;"></span>
                <md-ripple></md-ripple>
            </div>
            <div 
                class="ball" 
                data-theme="red"
                onclick="changeTheme(this)"
                >
                <span style="background:#a50012;"></span>
                <span style="background:#db3331;"></span>
                <span style="background:#ff958b;"></span>
                <md-ripple></md-ripple>
            </div>
          
        </div>
    </holder>

</window>