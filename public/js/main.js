/**
 * @return - null
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
