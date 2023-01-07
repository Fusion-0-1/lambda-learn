<link rel="stylesheet" href="css/course_initialization.css">

<div class="border main-container v-center flex-gap">

    <h3 class="text-center">Data Structures and Algorithms III</h3>
    <h4 class="text-center text-normal">SCS2201</h4>

    <div class="border main-container v-center flex-gap">
        <h4>Course Topics</h4><hr><br>
        <div class="flex flex-wrap h-justify">
            <div id="topic" class="flex flex-wrap h-evenly flex-gap">
                <input id="input_topic_1" class="input input-topic flex flex-gap" placeholder="Add new topic" onkeyup="addTopic(this)">
            </div>
        </div>
        <div class="flex margin-top h-center">
            <button id="save" class="edit-btn edit-btn-text hide">Save</button>
        </div>
    </div>

    <div class="border main-container flex-gap">
        <h4>Course Sub Topics</h4><hr><br>
        <div id="course-topic" class="flex flex-gap flex-wrap h-center">
            <div id="sub_topic_list_1" class="border container-course-topic v-center flex flex-gap v-center flex-column">
                <h5 id="topic-1" class="text-center remove-space">Add new topic...</h5>
                <div id="subtopic-1" class="border container-course-sub-topic v-center padding-none flex flex-column">
                    <input class="input input-subtopic flex" placeholder="Add new sub topic...">
                </div>
                <button id="1" class="btn-circle" onclick="addSubTopic(this.id)" disabled><i class="fa-solid fa-plus"></i></button>
            </div>
        </div>
        <div class="flex margin-top h-center">
            <button id="initialize" class="confirm-btn" disabled>Initialize course page</button>

            <div id="modal" class="modal hide" >
                <div class="warn-modal-content">
                    <div class="text-center">
                        <img src="images/primary_icons/warning.svg" alt="warning">
                        <h4>Are You Sure?</h4>
                        <p>Once you initialize the course page, you cannot add new topics for progress tracking</p>
                    </div>
                    <div class="two-button-row  text-right">
                        <button id="cancel-btn" class="text-bold">Cancel</button>
                        <button id="initialize-btn" class="text-bold">Initialize</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script>

/*
    0. create function to set as onchange
    1. pass element(element id) to the onchange function as parameter
    2. IFF element id + 1 not exists x(use try catch)
           element id + 1 -> create input field from that
           element -> set onchange function (0.) with current element as parameter <-------------------- Done upto here
           same way : create subtopic from that
       ELSE
            update existing element (update sub-header)
            IF header_length == 0
                delete sub topic element
    2.1 Delete empty input fields in the middle.
        1. get all input field as a list : document.getElementById('topic').getElementsByTagName('input')[i]
        2. filter only empty fields -> emptyFieldsArr
        3. IF length(emptyFieldsArr) > 1:
                delete all elements in emptyFieldsArr[:length(emptyFieldsArr)-1]

-----------------------------------------------------------------------------------
    NOT NEEDED : 3. 2. element -> set onchange function (0.) with current element as parameter
 */

function getTopicNumberFromID(topic_id){
    let topic_arr = topic_id.split('_');
    return parseInt(topic_arr[topic_arr.length-1]);
}

function addTopic(topic_element){
    let topic_id = getTopicNumberFromID(topic_element.id);
    let topic_elements = document.getElementById('topic').getElementsByTagName('input');
    let exists = false;
    for (let i=0; i < topic_elements.length; i++) {
        if (getTopicNumberFromID(topic_elements[i].id) === topic_id + 1) {
            exists = true;
            break;
        }
    }
    let new_input;
    for (let i=0; i < topic_elements.length; i++) {
        if (!exists) {
            document.getElementById("initialize").removeAttribute("disabled");
            document.getElementById(""+(topic_id)).removeAttribute("disabled");

            new_input = document.createElement("INPUT");
            new_input.setAttribute("type", "text");
            new_input.setAttribute("placeholder", "Add new topic");
            new_input.setAttribute("class", "input input-topic flex flex-gap");
            new_input.setAttribute("id", "input_topic_" + (topic_id + 1));
            new_input.setAttribute("onkeyup", "addTopic(this)");
            document.getElementById('topic').appendChild(new_input);

            var topic_container = document.createElement('div');
            topic_container.classList.add("border", "container-course-topic", "v-center", "flex", "flex-gap", "v-center", "flex-column");

            var heading = document.createElement('h5');
            heading.innerText = "Add topic"
            heading.setAttribute("id", "topic-"+(topic_id+1));
            heading.classList.add("text-center", "remove-space");

            var subtopic_container = document.createElement('div');
            subtopic_container.setAttribute("id", "subtopic-"+(topic_id+1));
            subtopic_container.classList.add("border", "container-course-sub-topic", "v-center", "padding-none", "flex", "flex-column");

            var input = document.createElement("input");
            input.classList.add("input", "input-subtopic", "flex");
            input.setAttribute("placeholder", "Add new sub topic...");

            var add_button = document.createElement("button");
            add_button.setAttribute("id", ""+(topic_id+1));
            add_button.disabled = true;
            add_button.classList.add("class", "btn-circle", "fa-solid", "fa-plus");

            add_button.onclick = function(){ return addSubTopic(this.id)};

            topic_container.appendChild(heading);
            subtopic_container.appendChild(input);
            topic_container.appendChild(subtopic_container);
            topic_container.appendChild(add_button);
            document.getElementById("course-topic").appendChild(topic_container);

            console.log(new_input.id);
            break; // maybe need to remove this
        }
        else{
            document.getElementById("topic-"+topic_id).innerHTML = document.getElementById("input_topic_"+topic_id).value;
        }
    }
    // DELETING EMPTY FIELDS FROM THE TOPIC INPUTS
    topic_elements = document.getElementById('topic').getElementsByTagName('input');
    let empty_fields = [];
    for (let i=0; i < topic_elements.length; i++) {
        if (topic_elements[i].value === "") {
            empty_fields.push(topic_elements[i]);
            console.log(topic_elements[i]);
        }
    }
    if (empty_fields.length > 1) {
        for (let i = 0; i < empty_fields.length-1; i++) {
            empty_fields[i].remove();
        }
    }
}
    // var count = 1;
    // var subtopic_count = 1;
    // var id = document.getElementById("input_topic-"+count);
    // id.addEventListener("input", addInput);

    // function addInput(){
    //     document.getElementById("topic-"+count).innerHTML = document.getElementById("input_topic-"+count).value;
    //     console.log(document.getElementById("input_topic-"+count));
    //     document.getElementById("initialize").removeAttribute("disabled");
    //     document.getElementById(""+count).removeAttribute("disabled");
    //     document.getElementById("sub_topic-1-1").removeAttribute("disabled");
    //
    //     if(id.value.length !== 0){
    //         count++;
    //         var new_input = document.createElement("INPUT");
    //         new_input.setAttribute("type", "text");
    //         new_input.setAttribute("placeholder", "Add new topic");
    //         new_input.setAttribute("class", "input input-topic flex flex-gap");
    //         new_input.setAttribute("id", "input_topic-"+count);
    //         document.getElementById('topic').appendChild(new_input);
    //         id = document.getElementById("input_topic-"+count);
    //
    //         var topic_container = document.createElement('div');
    //         topic_container.classList.add("border", "container-course-topic", "v-center", "flex", "flex-gap", "v-center", "flex-column");
    //
    //         var heading = document.createElement('h5');
    //         heading.innerText = "Add topic"
    //         heading.setAttribute("id", "topic-"+count);
    //         heading.classList.add("text-center", "remove-space");
    //
    //         var subtopic_container = document.createElement('div');
    //         subtopic_container.setAttribute("id", "subtopic-"+count);
    //         subtopic_container.classList.add("border", "container-course-sub-topic", "v-center", "padding-none", "flex", "flex-column");
    //
    //         var input = document.createElement("input");
    //         input.classList.add("input", "input-subtopic", "flex");
    //         input.setAttribute("id", "sub_topic-"+count+"-"+subtopic_count);
    //         input.setAttribute("placeholder", "Add new sub topic...");
    //
    //         var add_button = document.createElement("button");
    //         add_button.setAttribute("id", ""+count);
    //         add_button.classList.add("class", "btn-circle", "fa-solid", "fa-plus");
    //
    //         add_button.onclick = function(){ return addSubTopic(this.id)};
    //
    //         topic_container.appendChild(heading);
    //         subtopic_container.appendChild(input);
    //         topic_container.appendChild(subtopic_container);
    //         topic_container.appendChild(add_button);
    //         document.getElementById("course-topic").appendChild(topic_container);
    //
    //         id.addEventListener("input", addInput);
    //     }
    //     //TODO: remove input field if empty
    // }
    let subtopic_count = 1;

    function addSubTopic(clicked_id){
        subtopic_count++;
        var new_subtopic = document.createElement("INPUT");
        new_subtopic.setAttribute("type", "text");
        new_subtopic.setAttribute("placeholder", "Add new sub topic...");
        new_subtopic.setAttribute("class", "input input-subtopic flex width-full");
        new_subtopic.setAttribute("id", "sub_topic-"+clicked_id+"-"+subtopic_count);
        document.getElementById('subtopic-'+clicked_id).appendChild(new_subtopic);
    }

    var modal = document.getElementById("modal");
    var initialize_btn = document.getElementById("initialize");
    var cancel_btn = document.getElementById("cancel-btn");

    initialize_btn.onclick = function (){
        modal.style.display = "block";
    }
    window.onclick = function(event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    }
    cancel_btn.onclick = function(){
        modal.style.display = "none";
    }
</script>