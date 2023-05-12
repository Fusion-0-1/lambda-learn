const droppables = document.querySelectorAll('.droppable');
const draggables = document.querySelectorAll('.draggable');

const newbtntodo = document.getElementById('card-add-todo');
const newbtninprogress = document.getElementById('card-add-inprogress');
const newbtndone = document.getElementById('card-add-done');

const newmodal = document.getElementById('card-add-modal');
const editmodal = document.getElementById('card-edit-modal');
const deletemodal = document.getElementById("delete-modal");

const radiotodo = document.getElementById('radio-todo');
const radioinprogress = document.getElementById('radio-inprogress')
const radiodone = document.getElementById('radio-done');

const cancelbtnnew = document.getElementById('card-save-cancel');
const canceleditbtn = document.getElementById('card-edit-cancel');
const canceldltbtn = document.getElementById('card-dlt-cancel');

// --------------------------- Drag and Drop -----------------------------------

document.addEventListener('dragstart', e=> {
    if(e.target.classList.contains('draggable')) {
        e.target.classList.add('dragging');
    }
});
document.addEventListener('dragend', e=> {
    if (e.target.classList.contains('draggable')) {
        e.target.classList.remove('dragging');
        const taskid = e.target.getAttribute('data-id');
        const taskstate = e.target.parentNode.getAttribute('data-state');
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '/update_task_state', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send(`card-id=${taskid}&card-state=${taskstate}`);
    }
});
droppables.forEach(droppable=> {
    droppable.addEventListener('dragover', e=> {
        e.preventDefault();
        const dragging = document.querySelector('.dragging');
        const frontSib = getClosestFrontSibling(droppable, e.clientY);
        if (frontSib) {
            frontSib.insertAdjacentElement('afterend',dragging);
        } else {
            droppable.prepend(dragging);
        }
    });
});
function getClosestFrontSibling(droppable, draggingY) {
    const siblings = droppable.querySelectorAll('.draggable:not(.dragging)');
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

// --------------------------- Modal Open -----------------------------------

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

function kanbanupdate(taskid, tasktitle, taskdescription, taskstate, taskpriority, taskdeadline) {
    editmodal.style.display = 'block';
    document.getElementById('card-header-edit-modal').value = tasktitle;
    document.getElementById('card-body-edit-modal').value = taskdescription;
    document.getElementById('card-deadline-edit-modal').value = taskdeadline;
    document.getElementById('card-state-edit-modal').value = taskstate;
    document.getElementById('card-priority-edit-modal').value = taskpriority;
    document.getElementById('card-id-edit-modal').value = taskid;
}

function deletecard(taskid) {
    deletemodal.style.display = 'block';
    document.getElementById('card-delete-id').value = taskid;
}

// --------------------------- Modal Close with Cancel Button -----------------------------------

cancelbtnnew.addEventListener('click', function () {
    newmodal.style.display = 'none';
});

canceleditbtn.addEventListener('click', function () {
    editmodal.style.display = 'none';
});

canceldltbtn.addEventListener('click', function () {
    deletemodal.style.display = 'none';
});

// --------------------------- Modal Close when clicked outside Window -----------------------------------

window.addEventListener("click", function(event) {
    if (event.target === newmodal) {
        newmodal.style.display = 'none';
    }
});

window.addEventListener("click", function(event) {
    if (event.target === editmodal) {
        editmodal.style.display = 'none';
    }
});

window.addEventListener("click", function(event) {
    if (event.target === deletemodal) {
        deletemodal.style.display = 'none';
    }
});

// --------------------------- Task Priority -----------------------------------

const cardpriority = document.querySelectorAll('.card-priority');

for (let i = 0; i < cardpriority.length; i++) {
    const priorityvalue = cardpriority[i].textContent;
    if (priorityvalue === 'High') {
        cardpriority[i].style.color = '#ff0000';
    } else if (priorityvalue === 'Medium') {
        cardpriority[i].style.color = '#b36e15';
    } else if (priorityvalue === 'Low') {
        cardpriority[i].style.color = '#2ba512';
    }
}

// --------------------------- Due Date Styling -----------------------------------

const cardduedate = document.querySelectorAll('.card-deadline');
console.log(cardduedate);
for (let i = 2; i < cardduedate.length; i++) {
    const carddate = cardduedate[i].innerText;
    const duedate = new Date(Date.parse(carddate.replace(/-/g, "/").split(" ")[0]));
    const currentDate = new Date();

    if (currentDate > duedate) {
        cardduedate[i].style.color = '#ff0000';
        cardduedate[i].style.fontWeight = 'bold';
    }
}

