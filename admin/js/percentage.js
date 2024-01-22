document.addEventListener('DOMContentLoaded', function () {
    // Get all elements with the class '.progress-bar'
    const progressBars = document.querySelectorAll('.progress-bar');

    // Iterate through each progress bar
    progressBars.forEach((box) => {
        // Get the value from the data-width attribute
        const widthValue = box.getAttribute('data-width');

        if (widthValue !== null) {
            // Apply the value to the CSS background property
            box.style.background = `radial-gradient(closest-side, transparent 79%, transparent 80% 100%),conic-gradient(hotpink ${widthValue}%, pink 0)`;
        } else {
            console.error("data-width attribute is null or undefined");
        }
    });
});