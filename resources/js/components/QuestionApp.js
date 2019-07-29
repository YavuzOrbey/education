import MathJax from "react-mathjax2";
import QuestionBlock from "./QuestionBlock";
import React from "react";
import axios from "axios";

import AnswerChoices from "./AnswerChoices";
let sample =
    "When a variable $$ x = \\frac{1}{5} $$. What is $$y$$ if $$ y= \\frac{1}{x} $$. Damn look at this: $$x^2 = \\log_{10}x$$";

/* {
        number: 1,
        question_text: questionText,
        answer_choices: { ...answerChoices }
    },
    { */
/* {
        number: 2,
        question_text: (
            <div>
                When the expression <MathJax.Node>{"\\sqrt{a}"}</MathJax.Node>{" "}
                is multipled by
                <MathJax.Node inline>{"\\sqrt{a}"}</MathJax.Node> the resulting
                expression is
            </div>
        ),
        answer_choices: {
            A: <MathJax.Node inline>{"\\sqrt{ab}"}</MathJax.Node>,
            B: <MathJax.Node inline>{"\\sqrt{a+b}"}</MathJax.Node>,
            C: <MathJax.Node inline>{"ab"}</MathJax.Node>,
            D: <MathJax.Node inline>{4}</MathJax.Node>
        }
    } */

class QuestionApp extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            currentQuestion: {},
            answers: Array(),
            counter: 0
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
    componentWillMount() {
        /* let regex = new RegExp("\\$\\$(.*?)\\$\\$", "g"); */
        axios.get("/api/questions").then(
            response => {
                let questions = response.data;
                questions.forEach(question => {
                    question.question_text = this.convertStringtoMath(
                        question.question_text
                    );
                    /*  question.question_text
                        .split(regex)
                        .map((item, i) => {
                            return i % 2 === 1 ? (
                                <MathJax.Node key={i} inline>
                                    {item}
                                </MathJax.Node>
                            ) : (
                                <span key={i}>{item}</span>
                            );
                        }); */
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
                        /* (
                            <MathJax.Node inline>
                                {
                                    question.answer_choices[
                                        String.fromCharCode(65 + index)
                                    ]
                                }
                            </MathJax.Node>
                        ); */
                    }
                    question.answer_choices = answerChoices;
                });
                /* questions = parts.map(part =>
                    part.map((item, i) => {
                        return i % 2 === 1 ? (
                            <MathJax.Node key={i} inline>
                                {item}
                            </MathJax.Node>
                        ) : (
                            <span key={i}>{item}</span>
                        );
                    })
                );
                console.log(questions); */
                /* let sampleSplit = sample.split(regex);
            let arr = sampleSplit.map((item, i) => {
                return i % 2 === 1 ? (
                    <MathJax.Node key={i} inline>
                        {item}
                    </MathJax.Node>
                ) : (
                    <span key={i}>{item}</span>
                );
            });
            let questionText = <div>{arr}</div>; */
                this.setState({
                    questions: questions,
                    currentQuestion: questions[0]
                });
            },
            error => {
                this.setState({ error, loading: false });
            }
        );
    }
    handleClick = j => {
        let { counter, questions } = this.state;
        j ? counter++ : counter--;
        if (counter > questions.length - 1 || counter < 0) return;
        let currentQuestion = questions[counter];
        this.setState({
            currentQuestion: currentQuestion,
            counter: counter
        });
    };

    handleAnswerClick = (number, answer) => {
        const answers = [...this.state.answers];
        answers[number - 1] = answer;
        this.setState({ answers });
    };
    render() {
        const { handleClick, handleAnswerClick } = this;
        const { currentQuestion, answers } = this.state;
        return (
            <QuestionBlock
                handleClick={handleClick}
                handleAnswerClick={handleAnswerClick}
                currentQuestion={currentQuestion}
                answers={answers}
            />
        );
    }
}
QuestionApp.propTypes = {};
QuestionApp.defaultProps = {};
export default QuestionApp;
