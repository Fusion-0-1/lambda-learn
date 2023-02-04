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
    /**
     * getTopicNumberFromID - A function to extract the topic number from a given topic ID
     *
     * @param {string} topic_id - The topic ID to extract the number from
     *
     * @return {number} - The topic number extracted from the given topic ID
     */
    function getTopicNumberFromID(topic_id){
        let topic_arr = topic_id.split('_');
        return parseInt(topic_arr[topic_arr.length-1]);
    }



    /**
     * addTopic - A function that adds a new topic element
     *
     * @param topic_element - The topic element which is currently being added/edited
     */
    function addTopic(topic_element){
        let topic_id = getTopicNumberFromID(topic_element.id);
        let topic_elements = document.getElementById('topic').getElementsByTagName('input');

        // Check if the next topic already exists
        let exists = false;
        for (let i=0; i < topic_elements.length; i++) {
            if (getTopicNumberFromID(topic_elements[i].id) === topic_id + 1) {
                exists = true;
                break;
            }
        }

        // Create new topic element if it doesn't exist
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

                // Create new topic container and other related elements (subtopics, heading, buttons)
                let topic_container = document.createElement('div');
                topic_container.setAttribute('id', 'sub_topic_list_'+(topic_id + 1));
                topic_container.classList.add("border", "container-course-topic", "v-center", "flex", "flex-gap", "v-center",
                    "flex-column");

                let heading = document.createElement('h5');
                heading.innerText = "Add topic"
                heading.setAttribute("id", "topic-"+(topic_id+1));
                heading.classList.add("text-center", "remove-space");

                let subtopic_container = document.createElement('div');
                subtopic_container.setAttribute("id", "subtopic-"+(topic_id+1));
                subtopic_container.classList.add("border", "container-course-sub-topic", "v-center", "padding-none", "flex",
                    "flex-column");

                let input = document.createElement("input");
                input.classList.add("input", "input-subtopic", "flex");
                input.setAttribute("placeholder", "Add new sub topic...");

                let add_button = document.createElement("button");
                add_button.setAttribute("id", ""+(topic_id+1));
                add_button.disabled = true;
                add_button.classList.add("class", "btn-circle", "fa-solid", "fa-plus");

                add_button.onclick = function(){ return addSubTopic(this.id)};

                topic_container.appendChild(heading);
                subtopic_container.appendChild(input);
                topic_container.appendChild(subtopic_container);
                topic_container.appendChild(add_button);
                document.getElementById("course-topic").appendChild(topic_container);
                break;
            }
            else{
                document.getElementById("topic-"+topic_id).innerHTML = document.getElementById("input_topic_"+topic_id).value;
            }
        }
        // deleting empty fields from the topic inputs
        topic_elements = document.getElementById('topic').getElementsByTagName('input');
        let empty_fields = [];
        for (let i=0; i < topic_elements.length; i++) {
            if (topic_elements[i].value === "") {
                empty_fields.push(topic_elements[i]);
            }
        }
        if (empty_fields.length > 1) {
            for (let i = 0; i < empty_fields.length-1; i++) {
                empty_fields[i].remove();
            }
        }

        // deleting empty subtopic elements
        if(document.getElementById("topic-"+topic_id).innerHTML === ''){
            const remove_elements = document.querySelector('#sub_topic_list_'+topic_id);
            while (remove_elements.firstChild) {
                remove_elements.removeChild(remove_elements.firstChild);
            }
            document.getElementById('sub_topic_list_'+topic_id).remove();
        }
    }



    /**
     * addSubTopic - This function is used for adding new subtopics to a parent topic.
     *
     *  @param {string} clicked_id - the id of the parent element, the new subtopic input field will be appended to
     */
    function addSubTopic(clicked_id){
        let new_subtopic = document.createElement("INPUT");
        new_subtopic.setAttribute("type", "text");
        new_subtopic.setAttribute("placeholder", "Add new sub topic...");
        new_subtopic.setAttribute("class", "input input-subtopic flex width-full");
        document.getElementById('subtopic-'+clicked_id).appendChild(new_subtopic);
    }



    /**
     * Create a modal to confirm the initialization
     */
    let modal = document.getElementById("modal");
    let initialize_btn = document.getElementById("initialize");
    let cancel_btn = document.getElementById("cancel-btn");

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