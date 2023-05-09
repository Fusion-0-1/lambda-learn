modal_cancel("edit-modal");
modal_cancel("delete-modal");
modal_cancel("warn-modal");

function course_validate(course_code) {
    if (!validate_course_code(course_code)) {
        const modal = document.getElementById("warn-modal");
        modal.hidden = false;
        return false;
    }
    return true;
}

function delete_course(btn, course_code) {
    document.getElementById("delete-warning").innerHTML = "Are you sure you want to delete " + course_code + " course? ";

    var input = document.createElement("input");
    input.setAttribute("type", "hidden");
    input.setAttribute("name", "course_code")
    input.setAttribute("value", course_code);
    document.getElementById('delete_form').appendChild(input);

    const modal = document.getElementById("delete-modal");
    modal.hidden = false;
}

function edit_course(course_code, course_name) {
    document.getElementById("input-edit-course-code").value = course_code;
    document.getElementById("input-edit-course-name").value = course_name;

    const modal = document.getElementById("edit-modal");
    modal.hidden = false;
}