<link rel="stylesheet" href="css/course_initialization.css">

<div class="border main-container v-center flex-gap">

    <h3 class="text-center">Data Structures and Algorithms III</h3>
    <h4 class="text-center text-normal">SCS2201</h4>

    <div class="border main-container v-center flex-gap">
        <h4>Course Topics</h4><hr><br>
        <div class="flex flex-wrap h-justify">
            <div id="topic" class="flex flex-wrap h-evenly flex-gap">
                <input id="input_topic-1" class="input input-topic flex flex-gap" placeholder="Add new topic">
            </div>
        </div>
        <div class="flex margin-top h-center">
            <button id="save" class="edit-btn edit-btn-text hide">Save</button>
        </div>
    </div>

    <div class="border main-container flex-gap">
        <h4>Course Sub Topics</h4><hr><br>
        <div id="course-topic" class="flex flex-gap flex-wrap h-center">
            <div class="border container-course-topic v-center flex flex-gap v-center flex-column">
                <h5 id="topic-1" class="text-center remove-space">Add new topic...</h5>
                <div id="subtopic-1" class="border container-course-sub-topic v-center padding-none flex flex-column">
                    <input id="sub_topic-1-1" class="input input-subtopic flex" placeholder="Add new sub topic..." disabled>
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
    var count = 1;
    var subtopic_count = 1;
    var id = document.getElementById("input_topic-"+count);
    id.addEventListener("input", addInput);

    function addInput(){
        document.getElementById("topic-1").innerHTML = document.getElementById("input_topic-1").value;
        document.getElementById("initialize").removeAttribute("disabled")
        document.getElementById(""+count).removeAttribute("disabled");
        document.getElementById("sub_topic-1-1").removeAttribute("disabled")

        if(id.value.length !== 0){
            count++;
            var new_input = document.createElement("INPUT");
            new_input.setAttribute("type", "text");
            new_input.setAttribute("placeholder", "Add new topic");
            new_input.setAttribute("class", "input input-topic flex flex-gap");
            new_input.setAttribute("id", "input_topic-"+count);
            document.getElementById('topic').appendChild(new_input);
            id = document.getElementById("input_topic-"+count);

            var topic_container = document.createElement('div');
            topic_container.classList.add("border", "container-course-topic", "v-center", "flex", "flex-gap", "v-center", "flex-column");

            var heading = document.createElement('h5');
            heading.innerText = "Add topic"
            heading.setAttribute("id", "topic-"+count);
            heading.classList.add("text-center", "remove-space");

            var subtopic_container = document.createElement('div');
            subtopic_container.setAttribute("id", "subtopic-"+count);
            subtopic_container.classList.add("border", "container-course-sub-topic", "v-center", "padding-none", "flex", "flex-column");

            var input = document.createElement("input");
            input.classList.add("input", "input-subtopic", "flex");
            input.setAttribute("id", "sub_topic-"+count+"-"+subtopic_count);
            input.setAttribute("placeholder", "Add new sub topic...");

            var add_button = document.createElement("button");
            add_button.setAttribute("id", ""+count);
            add_button.classList.add("class", "btn-circle", "fa-solid", "fa-plus");

            add_button.onclick = function(){ return addSubTopic(this.id)};

            topic_container.appendChild(heading);
            subtopic_container.appendChild(input);
            topic_container.appendChild(subtopic_container);
            topic_container.appendChild(add_button);
            document.getElementById("course-topic").appendChild(topic_container);

            id.addEventListener("input", addInput);
        }
        //TODO: remove input field if empty
    }

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