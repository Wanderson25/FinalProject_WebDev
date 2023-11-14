function load_rainbow_text(delay, text_element) {
    const rainbowText = text_element.textContent.split("").map((char, i) => {
        if (char === " ") char = "&nbsp;";
        return `<span style="animation-delay: ${i * delay}s;">${char}</span>`;
    }).join("");
    text.innerHTML = rainbowText;
}