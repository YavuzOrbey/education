var leftBtn = document.getElementById("left-button"),
    rightBtn = document.getElementById("right-button");
let buttons = [leftBtn, rightBtn];
var leftSelect = document.getElementById("left-select"),
    rightSelect = document.getElementById("right-select");
let leftResults = document.getElementById("left-results"),
    rightResults = document.getElementById("right-results");
let thingToSend = {}; // we have to keep track of this given any change!!

/* buttons.forEach((button, index)=>{
    button.addEventListener('click', function(){
        var xhr = new XMLHttpRequest();
         // depending on whether the button pressed was the left or right one 
        let selection = index  === 0 ? selectionReceive : selectionSend;
        xhr.open('GET', '/api/assignments/' + selection.value, true);

        xhr.onload = function(){
	    let results = index  === 0 ? leftResults : rightResults;
        results.innerHTML = "";
        var obj = JSON.parse(this.responseText);
        let assignment = Object.entries(obj);
        console.log(assignment);
        let name = assignment.shift()[1];
        let resultList = `<div class='test-title'>${name}</div>`;
        assignment.forEach((section, index) => {
            resultList+=`<div class="section" data-section="${index}"><div class="section-title">${section[0]}</div><ul class='section-questions'>`;
                section[1].forEach((question, index) => {
                resultList += `<li class='number-box'>${index + 1}</li>`
                });
                resultList += "</ul></div>";
        });
        results.innerHTML = resultList;
    }
    xhr.send();
    });
}) */
// change this better to add this eventlistener to both
leftBtn.addEventListener("click", function() {
    resetRightNumberBoxes();
    var xhr = new XMLHttpRequest();
    let currentAssignment = leftSelect.value;
    xhr.open("GET", "/api/assignments/" + currentAssignment, true);
    xhr.onload = function() {
        leftResults.innerHTML = "";

        var obj = JSON.parse(this.responseText);
        let assignment = Object.entries(obj);
        console.log(assignment);
        let name = assignment.pop()[1];
        let resultList = `<div class='test-title'>${name}</div>`;
        assignment.forEach(section => {
            resultList += `<div class="section" data-section="${
                section[0]
            }"><div class="section-title">${
                section[1].name
            }</div><ul class='question-list'>`;
            section[1].questions.forEach((question, index) => {
                resultList += `<li class='left-number-box'><span>${index +
                    1}.</span><div class="dual-number-box"><div class="top-triangle"><p>1</p></div><div class="bot-triangle"><p>${index +
                    1}</p></div></div></li>`;
            });
            resultList += `</ul></div>`;
        });
        // need to transform all of the sections and their respective questions into an object which gets sent via a form
        thingToSend = JSON.stringify({
            id: currentAssignment,
            sections: assignment
        });
        //let formRoute = "route('assignments.update',"+currentAssignment+")";
        //console.log(formRoute);
        //I can't get a laravel named route to work with this
        resultList += `<form action="/assignments/${currentAssignment}" method="POST">
    <input id="obj" type="hidden" name="obj" value='${thingToSend}'><input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"> @method('PATCH')<button>SUBMIT</button></form>`;

        leftResults.innerHTML = resultList;
    };

    xhr.send();
});

function resetRightNumberBoxes() {
    let elements = document.querySelectorAll(".right-number-box");

    Array.prototype.forEach.call(elements, function(el) {
        el.classList.remove("disabled");
        el.disabled = false;
    });
}
rightBtn.addEventListener("click", function() {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "/api/assignments/" + rightSelect.value, true);
    xhr.onload = function() {
        rightResults.innerHTML = "";
        var obj = JSON.parse(this.responseText);
        let assignment = Object.entries(obj);
        let name = assignment.pop()[1];
        let resultList = `<div class='test-title'>${name}</div>`;
        assignment.forEach(section => {
            resultList += `<div class="section" data-section="${
                section[0]
            }"><div class="section-title">${
                section[1].name
            }</div><ul class='section-questions'>`;
            section[1].questions.forEach((question, index) => {
                resultList +=
                    "<li class='right-number-box' data-key='" +
                    (index + 1) +
                    "'>" +
                    (index + 1) +
                    "</li>";
            });
            resultList += "</ul></div>";
        });
        rightResults.innerHTML = resultList;

        var numberBoxes = document.getElementsByClassName("right-number-box");
        let insertedQuestionNum = 0;
        var myFunction = function() {
            if (this.disabled) {
                return;
            }

            let sections = document.querySelectorAll(
                "#left-results > .section"
            );
            let section;
            sections.forEach(item => {
                if (
                    this.closest(".section").getAttribute("data-section") ===
                    item.dataset.section
                ) {
                    section = item;
                }
            });
            if (section === undefined) {
                alert("Section doesn't exist!");
                return;
            }
            this.disabled = true;
            this.classList.add("disabled");
            let questionList = section.getElementsByTagName("ul")[0];
            let questions = questionList.getElementsByTagName("li"); //could be length 0 aka no questions yet
            let lastQuestionNum;
            if (questions.length) {
                let lastQuestion = questions[questions.length - 1];
                lastQuestionNum = parseInt(
                    lastQuestion.getElementsByTagName("span")[0].textContent
                );
            } else {
                lastQuestionNum = 0;
            }

            let questionListHTML = questionList.innerHTML;
            var attribute = this.getAttribute("data-key");
            questionListHTML += `<li class='left-number-box'><span>${lastQuestionNum +
                1}.</span><div class="dual-number-box"><div class="top-triangle"><p>${
                rightSelect.value
            }</p></div><div class="bot-triangle"><p>${attribute}</p></div></div></li>`;
            section.getElementsByTagName("ul")[0].innerHTML = questionListHTML;

            thingToSend = { id: currentAssignment };
        };

        for (var i = 0; i < numberBoxes.length; i++) {
            numberBoxes[i].addEventListener("click", myFunction, false);
        }
    };

    xhr.send();
});
