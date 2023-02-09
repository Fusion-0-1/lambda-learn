const droppables = document.querySelectorAll('.droppable');
const draggables = document.querySelectorAll('.draggable');

const newbtntodo = document.getElementById('card-add-todo');
const newbtninprogress = document.getElementById('card-add-inprogress');
const newbtndone = document.getElementById('card-add-done');

const newmodal = document.getElementById('card-add-modal');
const savebutton = document.getElementById('card-add-save');
const cardtitle = document.getElementById('card-header-modal'); 
const cancelbtnnew = document.getElementById('card-save-cancel');  
        
const radiotodo = document.getElementById('radio-todo');
const radioinprogress = document.getElementById('radio-inprogress')
const radiodone = document.getElementById('radio-done');

newbtntodo.addEventListener('click', function () {
    newmodal.style.display = 'block';
    radiotodo.innerHTML = '<input type="radio" name="card-status" value="To Do" checked> To Do';
});
newbtninprogress.addEventListener('click', function () {
    newmodal.style.display = 'block';
    radioinprogress.innerHTML = '<input type="radio" name="card-status" value="In Progress" checked> In Progress';
});
newbtndone.addEventListener('click', function () {
    newmodal.style.display = 'block';
    radiodone.innerHTML = '<input type="radio" name="card-status" value="Done" checked> Done';
});
savebutton.addEventListener('click', function () {
    if (cardtitle == NULL) {
        cardtitle.innerHTML.value = "Please enter a card title"
    }
    else {
        newmodal.style.display = 'none';
    }
});
cancelbtnnew.addEventListener('click', function () {
    newmodal.style.display = 'none';
})
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