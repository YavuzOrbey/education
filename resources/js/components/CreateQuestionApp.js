import React, { Component } from "react";
import AnswerChoicesInput from "./AnswerChoicesInput";
import QuestionText from "./QuestionText";
import MathJax from "react-mathjax2";
import axios from "axios";
import getSubjects from "../functions/getSubjects";

const NUMBER_OF_CHOICES = 4;
class CreateQuestionApp extends Component {
    constructor(props) {
        super(props);
        this.state = {
            app: {},
            question: {
                subjectId: null,
                questionTextMath: "",
                answerChoices: {},
                answerChoicesMath: {},
                correctAnswer: 1,
                numberOfChoices: NUMBER_OF_CHOICES,
                answerType: 0
            }
        };
    }
    componentDidMount() {
        const app = { ...this.state.app };
        getSubjects().then(
            subjects => {
                app.subjects = subjects;
                console.log(app);
                this.setState({ app });
            },
            error => {
                this.setState({ error });
            }
        );
    }
    convertStringtoMath = s => {
        let regex = new RegExp("\\$\\$(.*?)\\$\\$", "g");
        return s.split(regex).map((item, i) => {
            return i % 2 === 1 ? (
                <MathJax.Node key={i} inline>
                    {item}
                </MathJax.Node>
            ) : (
                <span key={i}>{item}</span>
            );
        });
    };
    handleQuestionInput = event => {
        let { convertStringtoMath } = this,
            { question } = this.state;
        question;
        this.setState({
            realText: event.target.value,
            questionTextMath: convertStringtoMath(event.target.value)
        });
    };
    handleAnswerInput = (event, letter) => {
        let { convertStringtoMath } = this;
        let { answerChoices, answerChoicesMath } = this.state.question;
        answerChoices = {
            ...answerChoices
        };
        answerChoicesMath = {
            ...answerChoicesMath
        };
        answerChoicesMath[letter] = convertStringtoMath(event.target.value);
        answerChoices[letter] = event.target.value;
        this.setState({
            answerChoices: answerChoices,
            answerChoicesMath: answerChoicesMath
        });
    };
    handleTypeChange = (event, numberOfChoices) => {
        this.setState({
            answerType: parseInt(event.target.value, 10),
            numberOfChoices
        });
    };
    addAnswerChoice = () => {
        let { numberOfChoices } = this.state.question;
        numberOfChoices++;
        this.setState({ numberOfChoices });
    };
    check = e => {
        this.setState({ correctAnswer: parseInt(e.target.value, 10) });
    };
    changeSubject = e => {
        let { subjectId } = this.state.question;

        this.setState({ subjectId: parseInt(e.target.value, 10) });
    };
    submit = e => {
        e.preventDefault();
        let question = {
            questionText: this.state.question.realText,
            subjectId: this.state.question.subjectId,
            correctAnswer: this.state.question.correctAnswer,
            answerChoices: this.state.question.answerChoices
        };
        var formData = JSON.stringify(question);
        $.ajax({
            type: "POST",
            url: "/questions",
            data: formData,
            success: function(response) {
                console.log(response);
            },
            error: function(errMsg) {
                console.log(errMsg);
            },
            contentType: "application/json",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            }
        });
        /*  axios
            .post("/questions", question)
            .then(function(response) {
                console.log(response);
            })
            .catch(function(error) {
                console.log(error);
            }); */
    };
    render() {
        console.log(this.state);
        const {
            handleQuestionInput,
            handleAnswerInput,
            addAnswerChoice,
            handleTypeChange,
            submit,
            check,
            changeSubject
        } = this;
        const {
            questionTextMath,
            answerChoices,
            numberOfChoices,
            answerType,
            answerChoicesMath
        } = this.state.question;
        var csrfVar = $('meta[name="csrf-token"]').attr("content");
        return (
            <div style={{ gridArea: "content" }}>
                <MathJax.Context input="tex">
                    <QuestionText
                        onChange={handleQuestionInput}
                        questionText={questionTextMath}
                        changeSubject={changeSubject}
                        subjects={this.state.subjects}
                    />
                </MathJax.Context>
                <MathJax.Context input="tex">
                    <AnswerChoicesInput
                        onChange={handleAnswerInput}
                        handleTypeChange={handleTypeChange}
                        answerChoicesMath={answerChoicesMath}
                        numberOfChoices={numberOfChoices}
                        answerType={answerType}
                        answerChoices={answerChoices}
                        check={check}
                    />
                </MathJax.Context>
                <form method="POST" onSubmit={submit}>
                    <input name="_token" value={csrfVar} type="hidden" />
                    <button>Submit</button>
                </form>
            </div>
        );
    }
}
export default CreateQuestionApp;
