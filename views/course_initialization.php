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
            <button id="save" class="edit-btn edit-btn-text">Save</button>
        </div>
    </div>

    <div class="border main-container flex v-center flex-gap flex-wrap h-justify">
        <div class="flex flex-wrap h-justify">
            <div class="border main-container v-center flex-gap padding-none">
                <h4>1. String Matching Algorithms</h4>
                <div class="border main-container v-center padding-none flex flex-column">
                    <input class="input input-subtopic flex" placeholder="Add sub topic"><br><br>
                    <input class="input input-subtopic flex"><br><br>
                    <input class="input input-subtopic flex"><br><br>
                    <button id="save" class="edit-btn edit-btn-text"><i class="fa-solid fa-plus"></i></button>
                </div>
            </div>
            <div class="border main-container v-center flex-gap padding-none">
                <h4>1. String Matching Algorithms</h4>
                <div class="border main-container v-center padding-none flex flex-column">
                    <input class="input input-subtopic flex"><br><br>
                    <input class="input input-subtopic flex"><br><br>
                    <input class="input input-subtopic flex"><br><br>
                </div>
            </div>
            <div class="border main-container v-center flex-gap padding-none">
                <h4>1. String Matching Algorithms</h4>
                <div class="border main-container v-center padding-none flex flex-column">
                    <input class="input input-subtopic flex"><br><br>
                    <input class="input input-subtopic flex"><br><br>
                    <input class="input input-subtopic flex"><br><br>
                </div>
            </div>
            <div class="border main-container v-center flex-gap padding-none">
                <h4>1. String Matching Algorithms</h4>
                <div class="border main-container v-center padding-none flex flex-column">
                    <input class="input input-subtopic flex"><br><br>
                    <input class="input input-subtopic flex"><br><br>
                    <input class="input input-subtopic flex"><br><br>
                </div>
            </div>
            <div class="border main-container v-center flex-gap padding-none">
                <h4>1. String Matching Algorithms</h4>
                <div class="border main-container v-center padding-none flex flex-column">
                    <input class="input input-subtopic flex"><br><br>
                    <input class="input input-subtopic flex"><br><br>
                    <input class="input input-subtopic flex"><br><br>
                </div>
            </div>
        </div>

        <div class="flex margin-top h-center">
            <button id="save" class="edit-btn edit-btn-text">Initialize Course Page</button>
        </div>
    </div>

</div>

<script>
    var count = 1;
    var id = document.getElementById("input_topic-"+count);
    id.addEventListener("input", addInput);
    function addInput(){
        if(id.value.length !== 0){
            count++;
            var new_input = document.createElement("INPUT");
            new_input.setAttribute("type", "text");
            new_input.setAttribute("placeholder", "Add new topic");
            new_input.setAttribute("class", "input input-topic flex flex-gap");
            new_input.setAttribute("id", "input_topic-"+count);
            document.getElementById('topic').appendChild(new_input);
            id = document.getElementById("input_topic-"+count);
            id.addEventListener("input", addInput);
        }
        // var i=1;
        // for(i=1; i<=10; i++){
        //     if(document.getElementById("input_topic-"+i).value.length === 0){
        //         document.getElementById("input_topic-"+(++i)).remove();
        //         return;
        //     }
        // }
    }
</script>