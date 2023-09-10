window.onload = function() {
    const selectElement = document.querySelector('.search-container select');
    const setSelectWidth = () => {
        // create a temporary canvas element
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');

        // get the font styles of the select element
        const computedStyle = getComputedStyle(selectElement);
        const fontSize = computedStyle.fontSize;
        const fontFamily = computedStyle.fontFamily;

        // set the font of the canvas context to match the font of the select element
        ctx.font = `${fontSize} ${fontFamily}`;

        // measure the width of the text
        const textWidth = ctx.measureText(selectElement.selectedOptions[0].innerHTML).width;

        // set the width of the select element
        selectElement.style.width = `${textWidth + 30}px`; // add some extra space for padding and borders
    }
    setSelectWidth();
    selectElement.addEventListener('change', setSelectWidth);
}
