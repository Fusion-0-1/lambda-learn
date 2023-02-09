<link rel="stylesheet" href="css/course/course_page.css">
<link rel="stylesheet" href="css/submission_popup.css">
<div class="modal hide">
    <div class="popup_card modal-content">
        <div class="course_name flex h-center text-bold text-center">Data Structures and Algorithms III</div>
        <div class="course_code flex h-center">SCS 2201</div>

        <div class="submission_topic text-bold">Submission 1 - String Matching</div>
        <div class="submissions_card_inside">
            <div class="due_date_div grid h-justify v-center">
                <div class="due_date_heading flex v-center" >
                    <img src="/images/submissions_popup/submission_pop_due_date.png">
                    <div>Due-Date</div>
                </div>
                <div class="due_date_contain">Wednesday, September 2, 2022       |   12.00 PM</div>
            </div>
            <div class="time_remaning_div grid h-justify v-center">
                <div class="due_date_heading flex v-center" >
                    <img src="/images/submissions_popup/submission_pop_time_remaining.png">
                    <div>Time remaining</div>
                </div>
                <div class="due_date_contain flex h-center">-- --</div>
            </div>

            <div class="break_line"></div>

            <div class="time_remaning_div grid h-justify v-center">
                <div class="due_date_heading flex v-center" >
                    <img src="/images/submissions_popup/submission_pop_granding_status.png">
                    <div>Grading status</div>
                </div>
                <div class="due_date_contain flex h-center">Pending</div>
            </div>
            <div class="time_remaning_div grid h-justify v-center">
                <div class="due_date_heading flex v-center" >
                    <img src="/images/submissions_popup/submission_pop_file_submission.png">
                    <div>File submission</div>
                </div>
                <div class="due_date_contain flex h-center">StringMatching_01.zip</div>
            </div>
            <div class="time_remaning_div grid h-justify v-center">
                <div class="due_date_heading flex v-center" >
                    <img src="/images/submissions_popup/submission_pop_submitted_date.png">
                    <div>Submitted Date</div>
                </div>
                <div class="due_date_contain flex h-center submitted_date">Wednesday, September 2, 2022  |  10.01 PM</div>
            </div>
            <div class="submit_buttons grid h-center">
                <div class="edit-btn submission_btn text-center">Add submission</div>
                <div class="edit-btn submission_btn text-center">Edit submission</div>
            </div>
        </div>
    </div>

</div>

<div class="border main-container v-center flex flex-column flex-gap responsive-container">
    <h3 class="text-bold">Data Structures and Algorithms</h3>
    <h3>CS 2208</h3>

    <div class="outer-secondary-container">
        <div class="secondary-container border border-radius flex flex-column">
            <h5> Student Progress </h5>
            <div class="flex flex-row">
                <div class="progress-bar-outer border-radius">
                    <div class="progress-bar student-progress border-radius"></div>
                </div>
                <div class="progress-value flex h-end v-center"><h5> 20% </h5></div>
            </div>
        
            <h5> Topic Progress </h5>
            <div class="flex flex-row">
                <div class="progress-bar-inner border-radius" id="topic1">
                    <div class="progress-bar border-radius" id="topic1-value"></div>
                    <div class="topic-progress-label"> Topic 1 </div>
                </div>
                <div class="progress-bar-inner border-radius" id="topic2">
                    <div class="progress-bar border-radius" id="topic2-value"></div>
                    <div class="topic-progress-label"> Topic 2 </div>
                </div>
                <div class="progress-bar-inner border-radius" id="topic3">
                    <div class="progress-bar border-radius" id="topic3-value"></div>
                    <div class="topic-progress-label"> Topic 3 </div>
                </div>
                <div class="progress-bar-inner border-radius" id="topic4">
                    <div class="progress-bar border-radius" id="topic4-value"></div>
                    <div class="topic-progress-label"> Topic 4 </div>
                </div>
                <div class="progress-bar-inner border-radius" id="topic5">
                    <div class="progress-bar border-radius" id="topic5-value"></div>
                    <div class="topic-progress-label"> Topic 5 </div>
                </div>
                <div class="progress-bar-inner border-radius" id="topic6">
                    <div class="progress-bar border-radius" id="topic6-value"></div>
                    <div class="topic-progress-label"> Topic 6 </div>
                </div>
                <div class="progress-value flex h-end v-center"><h5> 35% </h5></div>
            </div>
        </div>
    </div>

    <div class="outer-secondary-container flex flex-row h-justify">
        <div class="inner-secondary-container border border-radius flex flex-column">
            <div class="flex flex-row h-justify v-center">
                <h5> Announcements </h5>
                <a href="/site_announcement" class="hyperlink"> View all </a>
            </div>
            <div class="inner-container border-radius"> DSA - Tutorial Session </div>
            <div class="inner-container border-radius"> SCS2201_Rescheduling the lecture on 15/09/2022 </div>
            <div class="inner-container border-radius"> Assignment 1 Details - String Matching </div>
        </div>

        <div class="inner-secondary-container border border-radius flex flex-column">
            <div class="flex flex-row h-justify v-center">
                <h5> Submissions </h5>
                <div class="hyperlink"> View all </div>
            </div>
            <div class="inner-container border-radius"> Submission 3 - Greedy Alogrothms (Group Projects) </div>
            <div class="inner-container border-radius"> Submission 2 - Greedy Alogorithms </div>
            <div class="inner-container border-radius"> Submission 1 - String Matching </div>
        </div>

    </div>

    <div class="outer-secondary-container">
        <div class="secondary-container border border-radius flex flex-column">
            <h5> Course Topics </h5>
            <hr class="hr">
            <div class="topic-container flex flex-row item-gap">
                <div class="course-topic border border-radius flex flex-column ">
                    <h5> String Matching Algorithms</h5>
                    <div>
                        <div class="course-sub-topic border-radius flex flex-row h-justify v-center">
                            <h5> 1.2 KMP & Rabin-Karp Algorithms </h5>
                            <input type="checkbox" name="cs1208-1.2" id="cs1208-1.2" checked class="topic-check">
                        </div>
                        <div class="course-sub-topic-content border-radius">
                            <p><span class="icons fas fa-atom"></span> KMP String Matching Algorithm </p>
                            <p><span class="icons fas fa-atom"></span> Rabin Karp Algorithm </p>
                            <p><span class="icons fas fa-atom"></span> KMP & Rabin-Karp Algorithms </p>
                        </div>
                    </div>
                    <div>
                        <div class="course-sub-topic border-radius flex flex-row h-justify v-center">
                            <h5> 1.1 Naive String Matching </h5>
                            <input type="checkbox" name="cs1208-1.1" id="cs1208-1.1" checked class="topic-check">
                        </div>
                        <div class="course-sub-topic-content border-radius">
                            <p><span class="icons fas fa-atom"></span> Naive String Matching Algorithms </p>
                            <p><span class="icons fas fa-atom"></span> Naive String Matching Part I</p>
                            <p><span class="icons fas fa-atom"></span> Naive String Matching Part II</p>
                        </div>
                    </div>
                </div>
                <div class="course-topic border border-radius flex flex-column">
                    <h5> Linear Programming </h5>
                    <div>
                        <div class="course-sub-topic border-radius flex flex-row h-justify v-center">
                            <h5> 2.2 Simplex Method </h5>
                            <input type="checkbox" name="cs1208-2.2" id="cs1208-2.2" checked class="topic-check">
                        </div>
                        <div class="course-sub-topic-content border-radius">
                            <p><span class="icons fas fa-atom"></span> Simplex Method </p>
                            <p><span class="icons fas fa-atom"></span> Simplex Method Rec </p>
                        </div>
                    </div>
                    <div>
                        <div class="course-sub-topic border-radius flex flex-row h-justify v-center">
                            <h5> 2.1 Graphical Method  </h5>
                            <input type="checkbox" name="cs1208-2.1" id="cs1208-2.1" checked class="topic-check">
                        </div>
                        <div class="course-sub-topic-content border-radius">
                            <p><span class="icons fas fa-atom"></span> Graphical Method </p>
                            <p><span class="icons fas fa-atom"></span> Linear Prog. - Graphical Method </p>
                        </div>
                    </div>  
                </div>
                <div class="course-topic border border-radius flex flex-column">
                    <h5> Greedy Algorithms </h5>
                    <div>
                        <div class="course-sub-topic border-radius flex flex-row h-justify v-center">
                            <h5> 3.3 Coin Change Problem </h5>
                            <input type="checkbox" name="cs1208-3.3" id="cs1208-3.3" class="topic-check">
                        </div>
                        <div class="course-sub-topic-content border-radius">
                            <p><span class="icons fas fa-atom"></span> Coin Change Problem </p>
                            <p><span class="icons fas fa-atom"></span> Coin Change Problem </p>
                        </div>
                    </div>
                    <div>
                        <div class="course-sub-topic border-radius flex flex-row h-justify v-center">
                            <h5> 3.2 Scheduling Problem </h5>
                            <input type="checkbox" name="cs1208-3.2" id="cs1208-3.2" class="topic-check">
                        </div>
                        <div class="course-sub-topic-content border-radius">
                            <p><span class="icons fas fa-atom"></span> Scheduling Problem </p>
                            <p><span class="icons fas fa-atom"></span> Scheduling Algorithms </p>
                        </div>
                    </div>
                    <div>
                        <div class="course-sub-topic border-radius flex flex-row h-justify v-center">
                            <h5> 3.1 Knapsack Problem </h5>
                            <input type="checkbox" name="cs1208-3.1" id="cs1208-3.1" class="topic-check">
                        </div>
                        <div class="course-sub-topic-content border-radius">
                            <p><span class="icons fas fa-atom"></span> 0/1 & Fractional Knapsack </p>
                            <p><span class="icons fas fa-atom"></span> Knapsack Problem </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>