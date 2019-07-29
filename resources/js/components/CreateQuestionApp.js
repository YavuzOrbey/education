import React, { Component } from "react";
import AnswerChoicesInput from "./AnswerChoicesInput";
import QuestionText from "./QuestionText";
import MathJax from "react-mathjax2";
class CreateQuestionApp extends Component {
    constructor(props) {
        super(props);
        this.state = {
            questionText: "",
            answerChoices: {},
            correctAnswer: 1,
            numberOfChoices: 4,
            answerType: 0
        };
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
        let { convertStringtoMath } = this;
        this.setState({
            questionText: convertStringtoMath(event.target.value)
        });
    };
    handleAnswerInput = (event, letter) => {
        let { convertStringtoMath } = this;
        let { answerChoices } = this.state;
        answerChoices = {
            ...answerChoices
        };
        answerChoices[letter] = convertStringtoMath(event.target.value);
        this.setState({
            answerChoices: answerChoices
        });
    };
    handleTypeChange = event => {
        this.setState({ answerType: event.target.value });
    };
    addAnswerChoice = () => {
        let { numberOfChoices } = this.state;
        numberOfChoices++;
        this.setState({ numberOfChoices });
    };
    submit = () => ({});
    render() {
        const {
            handleQuestionInput,
            handleAnswerInput,
            addAnswerChoice,
            handleTypeChange,
            submit
        } = this;
        const {
            questionText,
            answerChoices,
            numberOfChoices,
            answerType
        } = this.state;
        return (
            <div style={{ gridArea: "content" }}>
                <MathJax.Context input="tex">
                    <QuestionText
                        onChange={handleQuestionInput}
                        questionText={questionText}
                    />
                </MathJax.Context>
                <MathJax.Context input="tex">
                    <AnswerChoicesInput
                        onChange={handleAnswerInput}
                        handleTypeChange={handleTypeChange}
                        answerChoices={answerChoices}
                        numberOfChoices={numberOfChoices}
                        answerType={answerType}
                    />
                </MathJax.Context>
                <button onClick={submit}>Submit</button>
            </div>
        );
    }
}
export default CreateQuestionApp;
