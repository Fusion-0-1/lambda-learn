const droppables = document.querySelectorAll('.droppable');
const draggables = document.querySelectorAll('.draggable');

const newmodal = document.getElementById('card-add-modal');
const savebutton = document.getElementById('card-add-save');

const newbtntodo = document.getElementById('card-add-todo');
const newbtninprogress = document.getElementById('card-add-inprogress');
const newbtndone = document.getElementById('card-add-done');

const radiotodo = document.getElementById('radio-todo');
const radioinprogress = document.getElementById('radio-inprogress');
const radiodone = document.getElementById('radio-done');

newbtntodo.addEventListener('click', function () {
    newmodal.style.display = 'block';
    radiotodo.innerText = "checked";
});

newbtninprogress.addEventListener('click', function () {
    newmodal.style.display = 'block';
});

newbtndone.addEventListener('click', function () {
    newmodal.style.display = 'block';
});

savebutton.addEventListener('click', function () {
    newmodal.style.display = 'none';
});

window.onclick = function(event) {
    if (event.target == newmodal) {
        newmodal.style.display = 'none';
    }
}

document.addEventListener('dragstart', e=> {
    if(e.target.classList.contains('draggable')) {
        e.target.classList.add('dragging');
    }
});

document.addEventListener('dragend', e=> {
    if(e.target.classList.contains('draggable')) {
        e.target.classList.remove('dragging');
    }
});

droppables.forEach(droppable=> {
    droppable.addEventListener('dragover', e=> {
        e.preventDefault();
        const dragging = document.querySelector('.dragging');
        // droppable.append(dragging);
        const frontSib = getClosestFrontSibling(droppable, e.clientY);
        if (frontSib) {
            frontSib.insertAdjacentElement('afterend',dragging);
        } else {
            droppable.prepend(dragging);
        }
    });
});

function getClosestFrontSibling(droppable, draggingY) {
    const siblings = droppable.querySelectorAll('.draggable:not(.dragging');
    let result;

    for (const sibling of siblings) {
        const box = sibling.getBoundingClientRect();

        const boxCenterY = box.y + box.height / 2;
        if (draggingY >= boxCenterY) {
            result = sibling;
        } else {
            return result;
        }
    }
    return result;
}



