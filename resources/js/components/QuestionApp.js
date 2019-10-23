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
            mode: 1,
            answers: Array(),
            counter: 0,
            markedQuestions: Array(),
            questions: {},
            buttons: ["", "NEXT"],
            timer: null,
            realContent: {},
            results: null
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
    startTimer() {
        const ONE_SECOND = 1000,
            ONE_MINUTE = ONE_SECOND * 60;
        let minutes = 0.1,
            endTime = ONE_MINUTE * minutes;
        let { submitAnswers, endTimer } = this;
        let timer = setInterval(() => {
            endTime = endTime - ONE_SECOND;
            if (endTime < 0) {
                submitAnswers(true);
                endTimer(timer);
            }
        }, ONE_SECOND);
    }
    endTimer(timer) {
        clearInterval(timer);
    }
    componentDidMount() {
        const quiz = this.props.match.params.subject;
        this.startTimer();
        this.setState({ quiz });
        let relatedContent = [],
            realContent = {};
        axios.get(`/api/quizzes/${quiz}`).then(
            response => {
                let questions = response.data;

                if (Array.isArray(questions)) {
                    questions.forEach(question => {
                        question.question_text = this.convertStringtoMath(
                            question.question_text
                        );
                        if (
                            !relatedContent.includes(
                                question.related_content
                            ) &&
                            question.related_content
                        ) {
                            relatedContent.push(question.related_content);
                            relatedContent.sort();
                        }
                        if (question.answer_choices) {
                            let answerChoices = {};
                            for (
                                let index = 0;
                                index <
                                Object.keys(question.answer_choices).length;
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
                }

                relatedContent.forEach(contentId => {
                    axios
                        .get(`/api/content/${contentId}`)
                        .then(
                            response =>
                                (realContent[contentId] =
                                    response.data[0].content)
                        );
                });
                let answers = Array(questions.length);
                this.setState({
                    questions,
                    currentQuestion: Array.isArray(questions)
                        ? questions[0]
                        : null,
                    realContent,
                    answers
                });
            },
            error => {
                this.setState({ error, loading: false });
            }
        );
    }
    submitAnswers = (timesUp = false) => {
        let submit = timesUp ? true : window.confirm("Submit Answers?");
        let obj = {};
        obj.id = this.state.quiz;
        obj.answers = this.state.answers;
        submit
            ? axios
                  .post("/submission", obj)
                  .then(response => {
                      let { questions } = this.state;
                      if (response.data) {
                          let updatedQuestions = questions.map(
                              (question, i) => {
                                  let ques = {
                                      ...question,
                                      result: response.data[i]
                                  };
                                  return ques;
                              }
                          );
                          this.setState(
                              state => ({
                                  mode: 0,
                                  results: response.data,
                                  counter: 0,
                                  questions: updatedQuestions,
                                  currentQuestion: updatedQuestions[0]
                              }),
                              state => this.changeNavButtons(this.state)
                          );
                      }
                  })
                  .catch(error => {
                      console.log(error.message);
                  })
            : "";
    };

    changeNavButtons = ({ counter, buttons, questions }) => {
        if (counter === 0) {
            buttons = ["", "NEXT", buttons[2]];
        } else if (counter === questions.length - 1) {
            buttons = ["BACK", "FINISH", buttons[2]];
        } else {
            buttons = ["BACK", "NEXT", buttons[2]];
        }
        this.setState({ buttons });
    };
    handleClick = j => {
        let { counter, questions, mode, results } = this.state;
        let { submitAnswers, changeNavButtons } = this;
        j ? counter++ : counter--;
        if (j === 2) {
            submitAnswers();
            return;
        }
        if (counter > questions.length - 1 || counter < 0) return;
        let currentQuestion = questions[counter];
        mode ? "" : (currentQuestion.result = results[counter]);
        this.setState({ counter, currentQuestion }, () =>
            changeNavButtons(this.state)
        );
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
        let { questions } = this.state;
        let currentQuestion = questions[counter];
        this.setState({ counter, currentQuestion }, () =>
            this.changeNavButtons(this.state)
        );
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
            realContent,
            mode,
            results
        } = this.state;
        let marked = currentQuestion
            ? markedQuestions.includes(currentQuestion.number)
            : false;
        return Array.isArray(questions) && questions.length ? (
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
                    mode={mode}
                ></QuestionBlock>

                <QuestionSidebar
                    onClick={sideBarClick}
                    questions={questions}
                    markedQuestions={markedQuestions}
                    mode={mode}
                    results={results}
                />
            </div>
        ) : null;
    }
}
QuestionApp.propTypes = {};
QuestionApp.defaultProps = {};
export default QuestionApp;
