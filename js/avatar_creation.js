const avatarParts = ["background", "ear", "face", "eyes", "eyebrows", "hair", "mouth"];

window.addEventListener("DOMContentLoaded", (event) => {
    const defaultColors = {
        background: '#F0CA4A',
        ear: '#F7A584',
        eyebrows: '#614335',
        eyes: '#000000',
        face: '#F58F63',
        hair: '#0B2C48',
    };

    avatarParts.forEach(part => {
        let svgOptions = document.querySelectorAll(`#${part}-container .svg-option`);
        let defaultOption = svgOptions[0];
        defaultOption.classList.add('svg-option-selected');
        fetchSVG(part, defaultOption.id, defaultColors[part]);
        svgOptions.forEach(svgOption => {
            svgOption.addEventListener('click', function() {
                document.querySelector(`#${part}-container .svg-option-selected`).classList.remove('svg-option-selected');
                this.classList.add('svg-option-selected');
                fetchSVG(part, this.id, defaultColors[part]);
            });
        });
    });

    document.querySelectorAll('.color-option').forEach(colorOption => {
        colorOption.addEventListener('click', function() {
            let part = this.id.split('-')[1];
            let color = this.dataset.color;
            let selectedOption = document.querySelector(`#${part}-container .svg-option-selected`);
            if (selectedOption) {
                fetchSVG(part, selectedOption.id, color);
            }
        });
    });

    function fetchSVG(part, value, color) {
        let svgOption = document.querySelector(`#${part}-container #${value}`);
        let avatarPartContainer = document.querySelector(`#${part}-avatar`);
        if (!avatarPartContainer) {
            avatarPartContainer = document.createElement('div');
            avatarPartContainer.id = `${part}-avatar`;
            avatarPartContainer.style.position = 'absolute';
            document.querySelector('#preview').appendChild(avatarPartContainer);
        }
        avatarPartContainer.innerHTML = svgOption.innerHTML;
        setColor(avatarPartContainer, color);
        
        // Save the x and y positions in data attributes
        avatarPartContainer.dataset.x = window.getComputedStyle(avatarPartContainer).left;
        avatarPartContainer.dataset.y = window.getComputedStyle(avatarPartContainer).top;
    }
    

    function setColor(container, color) {
        let paths = container.querySelectorAll('svg *');
        paths.forEach(path => {
            path.style.fill = color;
        });
    }
});

document.querySelector('#save').addEventListener('click', function() {
    let avatarContainer = document.querySelector('#preview');
    let combinedSvg = SVG().size(102, 102);

    avatarParts.forEach(part => {
        let partContainer = document.querySelector(`#${part}-avatar`);
        if (partContainer) {
            let svg = partContainer.querySelector('svg');
            if (svg) {
                let svgElement = SVG(svg);
                
                let svgGroup = combinedSvg.group().transform({ translateX: 0, translateY: 0 });
                svgGroup.svg(svgElement.svg());
            }
        }
    });

    let avatarSvg = combinedSvg.svg();

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../../core/avatar/save_avatar.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
            console.log(this.responseText);
            window.location.href = 'register.php';
        }
    }
    xhr.send("svgAvatar=" + encodeURIComponent(avatarSvg));
});
