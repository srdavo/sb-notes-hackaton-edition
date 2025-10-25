<section id="section-button">
    <div class="simple-container grow-1 justify-center align-center">
        <button class="style-superbig"  onclick="togglePrettyWindow('#window-read');" data-flip-id="animate">
            <div class="simple-container position-absolute" style="inset:0;" ></div>
            <md-ripple></md-ripple>
            <span data-shared_background>Asistir</span>
        </button>
    </div>
</section>
<style>
        button.style-superbig{
            font-size: 8vw;
            padding: 1em 2em;
            border:none;
            border-radius:264px;
            background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
            color:rgba(255,255,255,0.8);
            cursor:pointer;
            background-size: 400% 400%;
            animation: gradient 8s ease infinite;
            font-family: "Dm Sans", sans-serif;
            font-weight:500;
            transition:font-weight 250ms cubic-bezier(.56,.21,.66,1);
        }
        button.style-superbig:hover{
            font-weight:600;
        }
        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }
    </style>