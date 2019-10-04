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
            <div id="left-results">
                <div id="left-assignment"></div>
                <div id="left-form"></div>
            </div>
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
//let buttons = [leftBtn, rightBtn];
var leftSelect = document.getElementById('left-select'), rightSelect = document.getElementById('right-select');
let leftAssignment = document.getElementById('left-assignment'), leftForm = document.getElementById('left-form');

let rightResults = document.getElementById('right-results');
let thingToSend={}, thingReceived; 
let leftQuestions=[], rightQuestions;
function drawResultList(thingToSend){
    let resultList = `<input class='test-title' id='test-title' value='${thingToSend['name']}' placeholder='${thingToSend['name']}'>`;
    
    thingToSend.sections.forEach((section, i) => {
        resultList+=`<div class="section" data-section="${section.id}"><div class="section-title">${section.name}</div><i class="fas fa-trash"></i>
        <ul class='left-question-list'>`;
        section.questions.forEach((question, index) => {
            resultList += `<li class='left-number-box' data-key='${index}'><span>${index+1}.</span><div class="dual-number-box">
            <div class="top-triangle"><p>${question.assignment_id}</p></div>
            <div class="bot-triangle"><p>${question.question_number}</p></div></div></li>`;
            });
            
            resultList += `</ul></div>`;
        });


        return resultList;
}
var questionList = document.getElementById("left-results");

var removeQuestion = function(e){
    let numberBox = e.target.closest('.left-number-box');
    if(numberBox){
        let numberBoxSection = numberBox.closest('.section');
        thingToSend.sections.forEach(section => {
            console.log("section.id: " + section.id + ", numberBoxSection.dataset.section: " + numberBoxSection.dataset.section);
            if(section.id===numberBoxSection.dataset.section){

                section.questions.splice(numberBox.dataset.key, 1);
            }
        });
        leftAssignment.innerHTML = drawResultList(thingToSend);
    }    
}
let getQuestionIds = function(obj){
            return obj.sections.map(function(section){
                return section.questions.map(function(question){
                    return question.id;
            })}).flat().sort();
    }

questionList.addEventListener('click', removeQuestion, false);
function drawLeftForm(thingToSend){
    let form =`<form action="/assignments/${thingToSend.id}" method="POST">
        <input id="obj" type="hidden" name="obj" value=${thingToSend}>@csrf @method('PUT')
        <button id="submission">SUBMIT</button></form>`;
    return form;
}
leftBtn.addEventListener('click', function(){
    resetRightNumberBoxes();
       
    
    var xhr = new XMLHttpRequest();
    let currentAssignment = leftSelect.value;
    xhr.open('GET', '/api/assignments/' + currentAssignment, true);
	xhr.onload = function(){
        
        leftAssignment.innerHTML = "";
        thingToSend = JSON.parse(this.responseText);
        leftAssignment.innerHTML = drawResultList(thingToSend);
        leftForm.innerHTML = drawLeftForm(thingToSend);

        var submitBtn = document.getElementById('submission');

        submitBtn.addEventListener('click', function(e){
            if(!this.clicked){
                e.preventDefault();
                this.textContent = "CONFIRM";
                this.clicked = true;
                return;
            }
            thingToSend.name= document.getElementById('test-title').value;
            document.getElementById('obj').value = JSON.stringify(thingToSend);
        })
	}
    
    xhr.send();
});

function resetRightNumberBoxes(){
    let elements = document.querySelectorAll(".right-number-box");
    if(!elements)
        return;
    Array.prototype.forEach.call(elements, function(el) {
        el.classList.remove("disabled");
        el.disabled = false;
});
}
rightBtn.addEventListener('click', function(){
    if(Object.keys(thingToSend).length){
        leftQuestions = getQuestionIds(thingToSend);
}
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '/api/assignments/' + rightSelect.value, true);
    xhr.onload = function(){

        rightResults.innerHTML = "";
        thingReceived = JSON.parse(this.responseText);
        let resultList = `<div class='test-title'>${thingReceived.name}</div>`;
        thingReceived.sections.forEach((section) => {
            resultList+=`<div class="section" data-section="${section.id}"><div class="section-title">${section.name}</div><ul class='section-questions'>`;
                section.questions.forEach((question, index) => {
                    // here is a good time to check whether this question is in thingToSend;
                    let disabled = leftQuestions.indexOf(question.id) > 0 ? "disabled" : "";
                resultList += "<li class='right-number-box " + disabled +"' data-key='" + (index)+ "'>" + (index+1) + "</li>";
                });
                resultList += "</ul></div>";
        });
        rightResults.innerHTML = resultList;
        
        var numberBoxes = document.getElementsByClassName("left-question-list");
        let insertedQuestionNum = 0;

        let disableButtons = function(){
            let buttons = document.querySelectorAll('#right-results .disabled');

            buttons.forEach(button => {
                button.disabled = true;
            });
        }
        disableButtons();
        var findSection = function(el){
                // Need to find if there exists a section on the left that cooresponds with the section on the right and if not return an error
                let leftSections = document.querySelectorAll('#left-assignment > .section');
                let theSection; 
                leftSections.forEach((leftSection)=>{
                    if(el.dataset.section === leftSection.dataset.section){
                        theSection = leftSection;
                    }
                });

                return theSection;
        }
        var addQuestion = function(e) {
            let numberBox = e.target.closest('.right-number-box');
            if(numberBox){

                if(numberBox.disabled){
                    return;
                }

                let numberBoxSection = numberBox.closest('.section');
                let theSection = findSection(numberBoxSection);
                if(theSection === undefined){
                    alert('Section doesn\'t exist!');
                    return;
                }

                
                numberBox.disabled = true;
                numberBox.classList.add('disabled');

                // you're doing a lot more work then you need to just update the thingToSend object then redraw the left results

                let rightSections = document.querySelectorAll('#right-results > .section');
                let sectionIndex = Array.prototype.indexOf.call(rightSections, numberBoxSection)
                thingToSend.sections.forEach(section => {
                    if(section.id===numberBoxSection.dataset.section){
                        section.questions.push(thingReceived.sections[sectionIndex].questions[numberBox.dataset.key]);
                    }
                });
                console.log(thingReceived);
                leftAssignment.innerHTML = drawResultList(thingToSend);
        }
    }
    rightResults.addEventListener('click', addQuestion, false);
}

xhr.send();
});

</script>
@stop

@section('stylesheets')
{{Html::style('css/admin/insert.css') }}
{{Html::style('css/admin.css') }}
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
@stop