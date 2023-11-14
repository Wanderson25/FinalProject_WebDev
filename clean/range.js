function createRange(container, options, callback) {
    const track = container.querySelector('.track');
    const thumb = container.querySelector('.thumb');
    const progress = container.querySelector('.progress');

    let value = options.value || 0;
    let step = options.step || 0;
    let isDragging = false;
    let min = options.min || 0;
    let max = options.max || 1;
    let orientation = options.orientation || 'horizontal';

    setPosition(value);

    container.addEventListener('pointerdown', (event) => {
        isDragging = true;
        updateValue(event);
    });

    document.addEventListener('pointermove', (event) => {
        if (isDragging) {
            updateValue(event);
        }
    });

    document.addEventListener('pointerup', () => {
        isDragging = false;
    });

    function stepValue(value, step) {
        if (step > 0) {
            value = Math.round(value / step) * step;
        } else {
            value = Math.max(min, Math.min(max, value));
        }
        return value;
    }
    function updateValue(event) {
        const rect = container.getBoundingClientRect();
        if (orientation === 'horizontal') {
            const x = event.clientX - rect.left;
            value = x / rect.width;
            value = Math.max(min, Math.min(max, value));
            value = stepValue(value, step);
            setPosition(value);
            
        } else {
            const y = rect.bottom - event.clientY;
            value = y / rect.height;
            value = Math.max(min, Math.min(max, value));
            value = stepValue(value, step);
            setPosition(value);
        }
        if (typeof callback === 'function') {
            callback(value);
        }
        
    }

    function setPosition(value) {
        if (orientation === 'horizontal') {
            thumb.style.left = `${value * 100}%`;
            progress.style.width = `${value * 100}%`;
        } else {
            thumb.style.bottom = `${value * 100}%`;
            progress.style.bottom = 0;
            progress.style.height = `${value * 100}%`;
        }
    }

    function setValue(newValue) {
        value = newValue;
        setPosition(value);
    }

    return {
        setValue
    };
}