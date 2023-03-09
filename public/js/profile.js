modal_cancel("warn-modal");
modal_cancel("modal");

var modal = document.getElementById("modal");
var btn = document.getElementById("password");
var span = document.getElementsByClassName("close")[0];
var btn_edit = document.getElementById("edit");
var btn_confirm = document.getElementById("btn_confirm");
var change_profile_btn = document.getElementById('profile-btn');
var preview = document.getElementById("preview");


btn.onclick = function (){
    modal.hidden = false;
}
// Function to enable editing of contact and personal email fields
btn_edit.onclick = function(){
    document.getElementById('contact').removeAttribute('readonly');
    document.getElementById('personal_email').removeAttribute('readonly');
    document.getElementById('edit-icon_1').classList.remove('hide');
    document.getElementById('edit-icon_2').classList.remove('hide');
    change_profile_btn.classList.remove('hide');
    btn_edit.hidden = true;
    btn.hidden = true;
    btn_confirm.hidden = false;
}


// Function to confirm changes to contact and personal email fields
btn_confirm.onclick = function () {
    if (profile_validate(
    document.getElementById('contact').value,
    document.getElementById('personal_email').value)
    ){
        btn_confirm.hidden = true;
        btn.hidden = true;
        btn_edit.hidden = true;
        document.getElementById('contact').setAttribute('readonly', true);
        document.getElementById('personal_email').setAttribute('readonly', true);
        return true;
    } else {
        document.getElementById('warn-modal').hidden = false;
        return false;
    }
}

// Function to trigger the image upload input field when the change profile button is clicked
change_profile_btn.onclick = function(){
    document.getElementById("image_upload").click();
}

// Function to preview the selected image before uploading
function previewImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (event) {
            preview.src = event.target.result;
        }
    reader.readAsDataURL(input.files[0]);
    }
}

//Function to check whether the updated data are valid
function profile_validate(contact, email){
    return validate_contact(contact) && validate_email(email);
}

function isValid(){
    try{
        if(document.forms["change_password"]["new_password"].value === document.forms["change_password"]["confirm_password"].value ){
            return true
        } else {
            throw 'Make sure your passwords match';
        }
    } catch (e){
        document.getElementById("error").innerHTML=("Make sure your passwords match");
        return false;
    }
}