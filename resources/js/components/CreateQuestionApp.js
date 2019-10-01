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
                correctAnswer: null,
                numberOfChoices: NUMBER_OF_CHOICES,
                answerType: 0
            }
        };
    }
    componentDidMount() {
        const app = { ...this.state.app };
        const questionApp = this;
        getSubjects().then(
            subjects => {
                app.subjects = subjects;
                questionApp.setState({ app });
            },
            error => {
                questionApp.setState({ error });
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
        question.realText = event.target.value;
        question.questionTextMath = convertStringtoMath(event.target.value);
        this.setState({ question });
    };
    handleAnswerInput = (event, letter) => {
        let { convertStringtoMath } = this;
        let { question } = this.state;

        question.answerChoicesMath[letter] = convertStringtoMath(
            event.target.value
        );
        question.answerChoices[letter] = event.target.value;
        this.setState({ question });
    };
    handleTypeChange = (event, numberOfChoices) => {
        let { question } = this.state;
        question.answerType = parseInt(event.target.value, 10);
        question.numberOfChoices = numberOfChoices;
        this.setState({ question });
    };
    addAnswerChoice = () => {
        let { question } = this.state;
        question.numberOfChoices++;
        this.setState({ question });
    };
    check = e => {
        let { question } = this.state;
        question.correctAnswer = parseInt(e.target.value, 10);
        this.setState({ question });
    };
    changeSubject = e => {
        let { question } = this.state;
        question.subjectId = parseInt(e.target.value, 10);

        this.setState({ question });
    };
    submit = e => {
        e.preventDefault();
        let question = {
            questionText: this.state.question.realText,
            subjectId: this.state.question.subjectId,
            correctAnswer: this.state.question.correctAnswer,
            answerChoices: this.state.question.answerChoices,
            answerType: this.state.question.answerType
        };
        let { app } = this.state;
        console.log(question);
        axios
            .post("/questions", question)
            .then(response => {
                console.log(response);
                app.response = parseInt(response.data, 10);
                this.setState({ app });
                setTimeout(() => {
                    app.response = null;
                    this.setState({ app });
                }, 5000);
            })
            .catch(function(error) {
                console.log(error);
            });
    };
    render() {
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
        const { subjects } = this.state.app;
        const msg =
            this.state.app.response !== null &&
            this.state.app.response !== undefined ? (
                <div
                    className={
                        this.state.app.response === 1
                            ? "success msg"
                            : "error msg"
                    }
                >
                    {this.state.app.response === 1
                        ? "Question successfully submitted!"
                        : "Something went wrong"}
                </div>
            ) : (
                ""
            );

        var csrfVar = $('meta[name="csrf-token"]').attr("content");
        return (
            <div style={{ gridArea: "content" }}>
                {msg}
                <MathJax.Context input="tex">
                    <QuestionText
                        onChange={handleQuestionInput}
                        questionText={questionTextMath}
                        changeSubject={changeSubject}
                        subjects={subjects}
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
