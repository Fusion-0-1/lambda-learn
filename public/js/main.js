/**
 * @return - void
 * @description
 * 1. Add cancel button functionality of the modal, i.e. cancel button close the modal
 * 2. Close modal when clinking outside the modal
 * @param {string} modal_id - modal id of the modal
 */
function modal_cancel(modal_id) {
    const modal = document.getElementById(modal_id);
    // click cancel button to close
    const cancel_btn = modal.getElementsByClassName('cancel-btn')[0];
    cancel_btn.onclick = function () {
        modal.hidden = true;
    };

    // click outside the modal to close
    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            modal.hidden = true;
        }
    });
}


/**
 * @return {string} - rgba(r,g,b,a)
 * @description
 * Randomly generate each colour(red, green, blue) and opacity is set to 1. These colours are randomly generated using
 * randomly generated number less than 256. This will return as a single string.
 * @example
 * rgba(255, 99, 132, 1)
 *      - light red
 */
function randomColour() {
    const r = Math.floor(Math.random() * 256);
    const g = Math.floor(Math.random() * 256);
    const b = Math.floor(Math.random() * 256);
    return "rgba(" + r + "," + g + "," + b + ",1)";
};