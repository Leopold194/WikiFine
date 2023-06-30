window.addEventListener("DOMContentLoaded", (event) => {
    const avatarParts = ["background", "ear", "face", "eyes", "eyebrows", "hair", "mouth"];
    const defaultColors = {
        background: '#F0CA4A',
        ear: '#F7A584',
        eyebrows: '#614335',
        eyes: '#000000',
        face: '#F58F63',
        hair: '#0B2C48',
        mouth: '#ef4126'
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

    document.querySelectorAll('.color-picker-button').forEach(button => {
        button.addEventListener('click', function() {
            let part = this.id.split('-')[0];
            let color = this.style.backgroundColor;
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
    let serializer = new XMLSerializer();
    let avatarSvg = '';
    avatarParts.forEach(part => {
        let partContainer = document.querySelector(`#${part}-avatar`);
        if (partContainer) {
            let svg = partContainer.querySelector('svg');
            if (svg) {
                avatarSvg += serializer.serializeToString(svg);
            }
        }
    });

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "save_avatar.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
            console.log(this.responseText);
        }
    }
    xhr.send("svg=" + encodeURIComponent(avatarSvg));
});
