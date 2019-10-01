import MathJax from "react-mathjax2";
import QuestionBlock from "./QuestionBlock";
import QuestionSidebar from "./QuestionSidebar";
import React from "react";
import axios from "axios";

import AnswerChoices from "./AnswerChoices";

class QuestionApp extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            currentQuestion: {},
            answers: Array(),
            counter: 0,
            markedQuestions: Array(),
            questions: [],
            buttons: ["", "NEXT"],
            realContent: {}
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
    componentDidMount() {
        const { quiz } = this.props.match.params;
        this.setState({ quiz });
        let relatedContent = [],
            realContent = {};
        axios.get(`/api/quizzes/${quiz}`).then(
            response => {
                let questions = response.data;
                questions.forEach(question => {
                    question.question_text = this.convertStringtoMath(
                        question.question_text
                    );
                    if (
                        !relatedContent.includes(question.related_content) &&
                        question.related_content
                    ) {
                        relatedContent.push(question.related_content);
                        relatedContent.sort();
                    }
                    if (question.answer_choices) {
                        let answerChoices = {};
                        for (
                            let index = 0;
                            index < Object.keys(question.answer_choices).length;
                            index++
                        ) {
                            answerChoices[
                                String.fromCharCode(65 + index)
                            ] = this.convertStringtoMath(
                                question.answer_choices[
                                    String.fromCharCode(65 + index)
                                ]
                            );
                        }
                        question.answer_choices = answerChoices;
                    }
                });

                relatedContent.forEach(contentId => {
                    axios
                        .get(`/api/content/${contentId}`)
                        .then(
                            response =>
                                (realContent[contentId] =
                                    response.data[0].content)
                        );
                });
                this.setState({
                    questions: questions,
                    currentQuestion: questions[0],
                    realContent: realContent
                });
            },
            error => {
                this.setState({ error, loading: false });
            }
        );
    }
    submitAnswers = () => {
        let submit = window.confirm("Submit Answers?");
        let obj = {};
        obj.subject = this.state.subject;
        obj.answers = this.state.answers;
        submit
            ? axios
                  .post("/submission", obj)
                  .then(response => {
                      response.data
                          ? console.log(response) //(window.location.href = "/")
                          : console.log("false");
                  })
                  .catch(error => {
                      console.log(error.message);
                  })
            : "";
    };
    handleClick = j => {
        let { counter, questions, buttons } = this.state;
        let { submitAnswers } = this;
        j ? counter++ : counter--;
        j === 2 ? submitAnswers() : "";
        if (counter > questions.length - 1 || counter < 0) return;

        if (counter === 0) {
            buttons = ["", "NEXT", buttons[2]];
        } else if (counter === questions.length - 1) {
            buttons = ["BACK", "FINISH", buttons[2]];
        } else {
            buttons = ["BACK", "NEXT", buttons[2]];
        }
        let currentQuestion = questions[counter];
        this.setState({
            currentQuestion,
            counter,
            buttons
        });
    };

    handleAnswerClick = (number, answer) => {
        const answers = [...this.state.answers];
        answers[number - 1] = answer;
        this.setState({ answers });
    };

    markQuestion = number => {
        let markedQuestions;
        let { buttons } = this.state;
        if (this.state.markedQuestions.includes(number)) {
            markedQuestions = this.state.markedQuestions.filter(
                e => e != number
            );
        } else {
            markedQuestions = [...this.state.markedQuestions, number].sort();
        }

        this.setState({ markedQuestions, buttons });
    };
    sideBarClick = counter => {
        let { questions, buttons } = this.state;
        let currentQuestion = questions[counter];

        if (counter === 0) {
            buttons = ["", "NEXT"];
        } else if (counter === questions.length - 1) {
            buttons = ["BACK", "FINISH"];
        } else {
            buttons = ["BACK", "NEXT"];
        }
        this.setState({ currentQuestion, counter, buttons });
    };
    render() {
        const {
            handleClick,
            handleAnswerClick,
            markQuestion,
            sideBarClick
        } = this;
        const {
            currentQuestion,
            answers,
            questions,
            markedQuestions,
            buttons,
            realContent
        } = this.state;
        let marked = markedQuestions.includes(currentQuestion.number);
        return (
            <div>
                <QuestionBlock
                    handleClick={handleClick}
                    handleAnswerClick={handleAnswerClick}
                    markQuestion={markQuestion}
                    currentQuestion={currentQuestion}
                    realContent={realContent}
                    marked={marked}
                    answers={answers}
                    buttons={buttons}
                ></QuestionBlock>

                <QuestionSidebar onClick={sideBarClick} questions={questions} />
            </div>
        );
    }
}
QuestionApp.propTypes = {};
QuestionApp.defaultProps = {};
export default QuestionApp;
