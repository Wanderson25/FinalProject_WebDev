function loading_text(loading_id, load_message) {
    var loading = document.getElementById(loading_id);
    loading.innerHTML = `${load_message}<span class="dot">.</span><span class="dot">.</span><span class="dot">.</span>`;
    var dots = document.getElementsByClassName("dot");
    for (var i = 0; i < dots.length; i++) {
        dots[i].style.animationDelay = (i * 0.5) + "s";
    }
}

function include(filename) {
    // https://stackoverflow.com/a/26979805
   var head = document.getElementsByTagName('head')[0];

   var script = document.createElement('script');
   script.src = filename;
   script.type = 'text/javascript';

   head.appendChild(script)
}   

function format_time(time) {
    let minutes = Math.floor(time / 60);
    let seconds = Math.floor(time % 60);
    if (seconds < 10) {
        seconds = "0" + seconds;
    }
    return minutes + ":" + seconds;
}

function doesTextFit(text) {
    const limitWidth = 380;
    let fontSize = calculateFontSize(text, limitWidth);
    return fontSize > 10;
}

function calculateFontSize(text, limitWidth) {
    // create a temporary element to measure the text width
    let temp = document.createElement('div');
    temp.style.position = 'absolute';
    temp.style.visibility = 'hidden';
    temp.style.whiteSpace = 'nowrap';
    document.body.appendChild(temp);

    // set the initial font size
    let fontSize = 30;

    // measure the text width and adjust the font size until it fits within the container
    do {
        fontSize -= 1;
        temp.style.fontSize = fontSize + 'px';
        temp.textContent = text;
    } while (temp.offsetWidth > limitWidth && fontSize > 10);

    // remove the temporary element
    document.body.removeChild(temp);

    // return the calculated font size
    return fontSize;
}

function parse_lrc_to_arr(lrc_string) {
    let lines = lrc_string.split('\n');
    let lyrics = [];
    for (let line of lines) {
        let match = line.match(/^\[(\d+):(\d+\.\d+)\](.*)$/);
        if (match) {
            let minutes = parseInt(match[1]);
            let seconds = parseFloat(match[2]);
            let text = match[3];
            let time = minutes * 60 + seconds;
            lyrics.push({time, text});
        }
    }
    return lyrics;
}


function remove_classes(elements, class_names) {
    elements.forEach(element => element.classList.remove(...class_names));
}

function add_classes(elements, class_names) {
    elements.forEach(element => element.classList.add(...class_names));
}

function toggle_classes(elements, class_names) {
    elements.forEach(element => element.classList.toggle(...class_names));
}

function edit_styles(elements, styles) {
    elements.forEach(element => {
        Object.keys(styles).forEach(style => {
            element.style[style] = styles[style];
        });
    });
}