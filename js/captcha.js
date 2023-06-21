const captchaBtnCheck = document.querySelector(".captchaBtnCheck");
const captcha = document.querySelector(".captcha");

let page = document.querySelector(".loginForm");

if(document.querySelector(".loginForm") === null){
    page = document.querySelector('.registerForm');
}else{
    page = document.querySelector(".loginForm");
}

captchaBtnCheck.addEventListener("click", () => {
    if(!captchaBtnCheck.classList.contains("captchaBtnChecked")){
        captcha.classList.toggle('captchaClose');
        page.classList.toggle('filter');
        window.scrollTo(0, 0);
        document.documentElement.style.overflow = 'hidden';
    }
});

const puzzlePieces = document.querySelectorAll('.puzzlePiece');
const captchaBtn = document.getElementById('captchaBtn');
const connBtn = document.getElementById("connBtn");

const orderedImageNames = ["0", "1", "2", "3", "4", "5", "6", "7", "8"];

let draggedPiece = null;
let isOrderCorrect = false;

puzzlePieces.forEach(piece => {
    piece.addEventListener('dragstart', dragStart);
    piece.addEventListener('dragover', dragOver);
    piece.addEventListener('drop', dragDrop);
});

function dragStart(event) {
    draggedPiece = this;
    event.dataTransfer.effectAllowed = 'move';
    event.dataTransfer.setData('text/html', this.innerHTML);
}

function dragOver(event) {
    event.preventDefault();
    event.dataTransfer.dropEffect = 'move';
}

function dragDrop(event) {
    if (this !== draggedPiece) {
        draggedPiece.innerHTML = this.innerHTML;
        this.innerHTML = event.dataTransfer.getData('text/html');
    }

    const currentImageNames = Array.from(puzzlePieces).map(piece => piece.querySelector('img').id);
    isOrderCorrect = JSON.stringify(currentImageNames) === JSON.stringify(orderedImageNames);
    if(isOrderCorrect){
        const puzzleImg = document.querySelectorAll('.captchaImg');
        const puzzleImgCompleted = document.querySelector('.completedCaptcha');
        const puzzleImgContainer = document.querySelector('.captchaContainer');
        puzzleImg.forEach(img => {
            img.setAttribute("style", "margin:0; width:167px; height:167px; transition: all 0.3s ease-in-out;");
        });
        puzzleImgCompleted.setAttribute("style", "display: block; transition: all 0.3s;");
        puzzleImgContainer.setAttribute("style", "display: none; transition: all 0.3s;");
        captchaBtn.classList.toggle('captchaBtnDisabled');
        connBtn.classList.replace('submitInactive', 'submitActive');
        document.documentElement.style.overflow = 'auto';
    }
}

captchaBtn.addEventListener("click", () => {
    if(isOrderCorrect){
        captcha.classList.toggle('captchaClose');
        page.classList.toggle('filter');

        const captchaBtnCheck = document.querySelector(".captchaBtnCheck");
        captchaBtnCheck.classList.replace("captchaBtnCheck", "captchaBtnChecked");
    }
});

connBtn.addEventListener("click", () => {
    if(isOrderCorrect){
        document.getElementById('loginFormData').submit(); 
    }
})

