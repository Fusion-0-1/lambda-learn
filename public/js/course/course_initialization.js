modal_cancel("modal");
let topic_fields = [];

/**
 * @description - A function to extract the topic number from a given topic ID
 * @param {string} topic_id - The topic ID to extract the number from
 * @return {number} - The topic number extracted from the given topic ID
 */
function getTopicNumberFromID(topic_id){
    let topic_arr = topic_id.split('_');
    return parseInt(topic_arr[topic_arr.length-1]);
}

/**
 * @description - A function that adds a new topic element
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

            //create new input fields to add course topics
            new_input = document.createElement("INPUT");
            new_input.setAttribute("type", "text");
            new_input.setAttribute("placeholder", "Add new topic");
            new_input.setAttribute("class", "input input-topic flex flex-gap");
            new_input.setAttribute("id", "input_topic_" + (topic_id + 1));
            new_input.setAttribute("name", "topics[]");
            new_input.setAttribute("onkeyup", "addTopic(this)");
            document.getElementById('topic').appendChild(new_input);
            break;
        }
    }
    // deleting empty fields from the topic inputs
    topic_elements = document.getElementById('topic').getElementsByTagName('input');
    let empty_fields = [];
    let nonempty_topics = [];
    for (let i=0; i < topic_elements.length; i++) {
        if (topic_elements[i].value === "") {
            empty_fields.push(topic_elements[i]);
        }
        else {
            nonempty_topics.push(topic_elements[i]);
        }
    }
    topic_fields = nonempty_topics;

    console.log(topic_fields)
    if (empty_fields.length > 1) {
        for (let i = 0; i < empty_fields.length-1; i++) {
            empty_fields[i].remove();
        }
    }

}

/**
 *  @description  - This function is used for adding new subtopics to a parent topic.
 *  @param {string} clicked_id - the id of the parent element, the new subtopic input field will be appended to
 */
function addSubTopic(clicked_id){
    const subtopicContainer = document.getElementById('subtopic-' + clicked_id);
    const lastInput = subtopicContainer.lastElementChild;
    // Check if the last input is empty before adding a new input
    if (lastInput.value.trim() !== '') {
        const newSubtopic = document.createElement('input');
        newSubtopic.onkeyup = function(){return removeIfEmpty(this)};
        newSubtopic.type = 'text';
        newSubtopic.placeholder = 'Add new sub topic...';
        newSubtopic.className = 'input input-subtopic flex width-full';
        newSubtopic.setAttribute('name', 'subtopic['+(clicked_id)+'][]');
        // newSubtopic.name = "subtopics!!subtopic-"+(clicked_id);
        // newSubtopic.name = "subtopic-"+(clicked_id) + "!!";

        subtopicContainer.appendChild(newSubtopic);
    }
}

/**
 * @Description - Removes the input element if its value is empty.
 * @param {HTMLInputElement} input - The input element to check and remove if empty.
 * */
function removeIfEmpty(input){
    if(input.value === ""){
        if(input.parentElement.children.length>1){
            input.remove();
        }
    }
}

function createSubtopics(){
    for(let i=0; i<topic_fields.length; i++){
        //enable editing the subtopic elements once start typing on the topic input fields
        document.getElementById("initialize").removeAttribute("disabled");
        document.getElementById("save").disabled = 'true';

        let topic_container = document.createElement('div');
        topic_container.setAttribute('id', 'sub_topic_list_'+(i));
        topic_container.classList.add("border","container-course-topic", "v-center", "flex", "flex-gap", "v-center",
            "flex-column");

        let heading_container = document.createElement('div');
        heading_container.classList.add("flex","flex-row", "v-center")
        let heading = document.createElement('h5');
        heading.innerText = "Topic..."
        heading.setAttribute("id", "topic-"+(i));
        heading.classList.add("text-center", "remove-space");

        //checkbox
        let check_box = document.createElement('input');
        let hidden_input = document.createElement('input');
        check_box.setAttribute('type', 'checkbox');
        check_box.setAttribute('id', 'check_box-'+(i));
        check_box.setAttribute('name', 'checkbox_'+i);
        // document.createElement('input');
        // hidden_input.setAttribute('type', 'hidden');




        let subtopic_container = document.createElement('div');
        subtopic_container.setAttribute("id", "subtopic-"+(i));
        subtopic_container.classList.add("border", "container-course-sub-topic", "v-center", "padding-none", "flex",
            "flex-column");

        let input = document.createElement("input");
        input.onkeyup = function(){return removeIfEmpty(this)};
        input.classList.add("input", "input-subtopic", "flex");
        input.setAttribute("placeholder", "Add new sub topic...");
        input.setAttribute('name', 'subtopic['+(i)+'][]');
        // input.name = "subtopics!!subtopic-"+(i);


        //Create the add button
        let add_button = document.createElement("button");
        add_button.setAttribute("id", ""+(i));
        add_button.setAttribute("type", "button");
        add_button.classList.add("class", "btn-circle", "fa-solid", "fa-plus");

        add_button.onclick = function(){return addSubTopic(this.id)};

        topic_container.appendChild(heading_container);
        heading_container.appendChild(heading);
        heading_container.appendChild(check_box);

        subtopic_container.appendChild(input);
        topic_container.appendChild(subtopic_container);
        topic_container.appendChild(add_button);
        document.getElementById("course-topic").appendChild(topic_container);

        document.getElementById("topic-"+i).innerHTML
                = document.getElementById('topic').getElementsByTagName('input')[i].value;
    }
}

/**
 * Create a modal to confirm the initialization
 */
let modal = document.getElementById("modal");
let initialize_btn = document.getElementById("initialize");

initialize_btn.onclick = function (){
    modal.hidden = false;
}