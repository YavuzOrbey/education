@extends('layouts.admin')

@section('content')
<div id="content">
    <div id="insert">
        <div class="column-1">
                <select id="left-select">
                    @foreach ($assignments as $key=>$assignment)
                    <option value="{{$key}}">{{$assignment}}</option>
                    @endforeach
                    
                </select>
            <button id="left-button">Edit Assignment</button>
            <div id="left-results"></div>
        </div>
        <div class="column-2">
            <select id="right-select">
                <option value="1">SAT Practice Test 1</option>
                <option value="2">SAT Practice Test 2</option>
                <option value="3">SAT Practice Test 3</option>
                <option value="4">SAT Practice Test 4</option>
            </select>
            <button id="right-button">Get Questions</button>
            <div id="right-results"></div>
        </div>
        
    </div>
</div>
@stop

@section('scripts')
<script>
var leftBtn = document.getElementById('left-button'), rightBtn = document.getElementById('right-button');
let buttons = [leftBtn, rightBtn];
var leftSelect = document.getElementById('left-select'), rightSelect = document.getElementById('right-select');
let leftResults = document.getElementById('left-results'), rightResults = document.getElementById('right-results');
let thingToSend = {}; // we have to keep track of this given any change!!

// change this better to add this eventlistener to both 
leftBtn.addEventListener('click', function(){
    resetRightNumberBoxes();
       
    
    var xhr = new XMLHttpRequest();
    let currentAssignment = leftSelect.value;
    
    xhr.open('GET', '/api/assignments/' + currentAssignment, true);
	xhr.onload = function(){
        
        leftResults.innerHTML = "";
        var obj = JSON.parse(this.responseText);
        thingToSend = obj;
        console.log(thingToSend);
        let resultList = `<div class='test-title'>${thingToSend['name']}</div>`;
        thingToSend.sections.forEach((section, i) => {
            resultList+=`<div class="section" data-section="${i}"><div class="section-title">${section.name}</div><ul class='left-question-list'>`;
                section.questions.forEach((question, index) => {
                    resultList += `<li class='left-number-box' data-key='${index+1}'><span>${index+1}.</span><div class="dual-number-box"><div class="top-triangle"><p>${thingToSend.id}</p></div>
                    <div class="bot-triangle"><p>${question.question_number}</p></div></div></li>`;
                });
                resultList += `</ul></div>`;

        });
        resultList+=`<form action="/assignments/${currentAssignment}" method="POST">
        <input id="obj" type="hidden" name="obj" value=${thingToSend}>@csrf @method('PUT')<button id="submission">SUBMIT</button></form>`;
        
        
        leftResults.innerHTML = resultList;
    /*     let assignment = Object.entries(obj);
        console.log(assignment); */
        /*
        let name = assignment.pop()[1];

        // need to transform all of the sections and their respective questions into an object which gets sent via a form
        thingToSend = {assignment_id: currentAssignment, sections: assignment};
        let resultList = `<div class='test-title'>${name[0]}</div>`;
        thingToSend.sections.forEach((section) => {
            resultList+=`<div class="section" data-section="${section[0]}"><div class="section-title">${section[1].name}</div><ul class='left-question-list'>`;
                section[1].questions.forEach((question, index) => {
                resultList += `<li class='left-number-box' data-key='${index+1}'><span>${index+1}.</span><div class="dual-number-box"><div class="top-triangle"><p>${name[1]}</p></div><div class="bot-triangle">
                <p>${index+1}</p></div></div></li>`;
                });
                resultList += `</ul></div>`;

        });
     
        //I can't get a laravel named route to work with this
        resultList+=`<form action="/assignments/${currentAssignment}" method="POST">
        <input id="obj" type="hidden" name="obj" value=${thingToSend}>@csrf @method('PUT')<button id="submission">SUBMIT</button></form>`;
        
        
        leftResults.innerHTML = resultList;
        
        var removeQuestion = function(){
            let numberBoxSection = this.closest('.section');
            console.log(numberBoxSection);
            thingToSend.sections.forEach((element,i) => {
                if(element[0]===numberBoxSection.dataset.section){
                    let index = this.dataset.key -1;
                    element[1].questions.splice(index,1);
                    console.log(i);
                    //redraw that section NOTE because we're drawing the sections again they WONT have the event listener
                    let questionListHTML = "";
                    thingToSend.sections[i][1].questions.forEach((question,index)=>{
                        questionListHTML += `<li class='left-number-box' data-key='${index+1}'><span>${index+1}.</span><div class="dual-number-box"><div class="top-triangle"><p>1</p></div>
                        <div class="bot-triangle"><p>${index+1}</p></div></div></li>`;
                    })
                    let questionList = numberBoxSection.getElementsByTagName('ul')[0];
                    console.log(questionList);
                    questionList.innerHTML = questionListHTML;
                }
            });
        
        }

        var numberBoxes = document.getElementsByClassName("left-question-list");
        for (let i = 0; i < numberBoxes.length; i++) {
            numberBoxes[i].addEventListener('click', removeQuestion, false);
        }

        var submitBtn = document.getElementById('submission');
        submitBtn.addEventListener('click', function(e){
            if(this.clicked){
                this.clicked = false;
                return;
            }
            this.clicked = true;
            document.getElementById('obj').value = JSON.stringify(thingToSend);
            e.preventDefault();
            this.textContent = "CONFIRM";
        }) */
	}
    
    xhr.send();
});

function resetRightNumberBoxes(){
    let elements = document.querySelectorAll(".right-number-box");
    
    Array.prototype.forEach.call(elements, function(el) {
        el.classList.remove("disabled");
        el.disabled = false;
});
}
rightBtn.addEventListener('click', function(){

    var xhr = new XMLHttpRequest();
    xhr.open('GET', '/api/assignments/' + rightSelect.value, true);
    xhr.onload = function(){
        rightResults.innerHTML = "";
        var obj = JSON.parse(this.responseText);
        let assignment = Object.entries(obj);
        let name = assignment.pop()[1];
        let resultList = `<div class='test-title'>${name[0]}</div>`;
        assignment.forEach((section) => {
            resultList+=`<div class="section" data-section="${section[0]}"><div class="section-title">${section[1].name}</div><ul class='section-questions'>`;
                section[1].questions.forEach((question, index) => {
                resultList += "<li class='right-number-box' data-key='" + (index + 1) + "'>" + (index + 1) + "</li>";
                });
                resultList += "</ul></div>";
        });
        rightResults.innerHTML = resultList;

        var numberBoxes = document.getElementsByClassName("left-question-list");
        let insertedQuestionNum = 0;
        var addQuestion = function() {
            if(this.disabled){
                return;
            }
        
        
            let leftSections = document.querySelectorAll('#left-results > .section');
            let section;
            let rightSections = document.querySelectorAll('#right-results > .section');
            let numberBoxSection = this.closest('.section'); // the section that this question button resides in
            let numberBoxSectionIndex =0;
            rightSections.forEach((element, index) => {
                if(element===numberBoxSection)
                numberBoxSectionIndex = index;
            });
            let sectionNumber = numberBoxSection.getAttribute("data-section"); 
            leftSections.forEach((item)=>{
                if(sectionNumber === item.dataset.section){
                section = item;
            }
            })
            if(section === undefined){
                alert('Section doesn\'t exist!');
                return;
            }
            this.disabled = true;
            this.classList.add('disabled');
            let questionList = section.getElementsByTagName('ul')[0];
            let questions = questionList.getElementsByTagName('li'); //could be length 0 aka no questions yet
            let lastQuestionNum ;
            if(questions.length){
                let lastQuestion = questions[questions.length-1];
                lastQuestionNum = parseInt(lastQuestion.getElementsByTagName('span')[0].textContent);
            }
            else{
                lastQuestionNum = 0;
            }
            let questionListHTML = questionList.innerHTML;
            var attribute = this.getAttribute("data-key");
            questionListHTML += `<li class='left-number-box'><span>${lastQuestionNum+1}.</span><div class="dual-number-box"><div class="top-triangle"><p>${name[1]}</p>
            </div><div class="bot-triangle"><p>${attribute}</p></div></div></li>`;
            section.getElementsByTagName('ul')[0].innerHTML = questionListHTML;
        
            thingToSend.sections.forEach(element => {
                if(element[0]===sectionNumber){
                    element[1].questions.push({id: assignment[numberBoxSectionIndex][1].questions[this.dataset.key-1].id})
                }
               
            });
            

    }

    for (var i = 0; i < numberBoxes.length; i++) {
        numberBoxes[i].addEventListener('click', addQuestion, false);
    }
}

xhr.send();
});

</script>
@stop

@section('stylesheets')
{{Html::style('css/admin/insert.css') }}
{{Html::style('css/admin.css') }}
@stop