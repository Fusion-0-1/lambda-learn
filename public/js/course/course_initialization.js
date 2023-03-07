modal_cancel("modal");
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
            //enable editing the subtopic elements once start typing on the topic input fields
            document.getElementById("initialize").removeAttribute("disabled");
            document.getElementById(""+(topic_id)).removeAttribute("disabled");

            //create new input fields to add course topics
            new_input = document.createElement("INPUT");
            new_input.setAttribute("type", "text");
            new_input.setAttribute("placeholder", "Add new topic");
            new_input.setAttribute("class", "input input-topic flex flex-gap");
            new_input.setAttribute("id", "input_topic_" + (topic_id + 1));
            new_input.setAttribute("onkeyup", "addTopic(this)");
            document.getElementById('topic').appendChild(new_input);

            // Create new sub-topic container and other related elements (subtopics, heading, buttons)
            let topic_container = document.createElement('div');
            topic_container.setAttribute('id', 'sub_topic_list_'+(topic_id + 1));
            topic_container.classList.add("border", "container-course-topic", "v-center", "flex", "flex-gap", "v-center",
                "flex-column");

            let heading = document.createElement('h5');
            heading.innerText = "Topic..."
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
            add_button.setAttribute("type", "button");
            add_button.disabled = true;
            add_button.classList.add("class", "btn-circle", "fa-solid", "fa-plus");

            add_button.onclick = function(){return addSubTopic(this.id)};

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
    let empty_subtopic_fields = [];
    for (let i=0; i < topic_elements.length; i++) {
        if (topic_elements[i].value === "") {
            let topic_number = getTopicNumberFromID(topic_elements[i].id);
            let sub_topics = document.getElementById("sub_topic_list_"+topic_number);
            empty_subtopic_fields.push(sub_topics);
            empty_fields.push(topic_elements[i]);
        }
    }
    if (empty_fields.length > 1) {
        for (let i = 0; i < empty_fields.length-1; i++) {
            empty_fields[i].remove();
            empty_subtopic_fields[i].remove();
        }
    }
}

/**
 * addSubTopic - This function is used for adding new subtopics to a parent topic.
 *
 *  @param {string} clicked_id - the id of the parent element, the new subtopic input field will be appended to
 */
function addSubTopic(clicked_id){
    const subtopicContainer = document.getElementById('subtopic-' + clicked_id);
    const lastInput = subtopicContainer.lastElementChild;

    // Check if the last input is empty before adding a new input
    if (lastInput.value.trim() !== '') {
        const newSubtopic = document.createElement('input');
        newSubtopic.type = 'text';
        newSubtopic.placeholder = 'Add new sub topic...';
        newSubtopic.className = 'input input-subtopic flex width-full';
        subtopicContainer.appendChild(newSubtopic);
    }
}

/**
 * Create a modal to confirm the initialization
 */
let modal = document.getElementById("modal");
let initialize_btn = document.getElementById("initialize");
let cancel_btn = document.getElementById("cancel-btn");

initialize_btn.onclick = function (){
    modal.hidden = false;
}