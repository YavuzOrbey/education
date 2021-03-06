import MathJax from "react-mathjax2";
import QuestionBlock from "./QuestionBlock";
import QuestionSidebar from "./QuestionSidebar";
import React from "react";
import axios from "axios";
import ClockTime from "../functions/ClockTime";

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
            buttons: ["", "NEXT", "MARK"],
            timer: null,
            realContent: {},
            results: null,
            timeDisplay: null,
            timerVisibility: true
        };
    }
    setVisible(selector, visible) {
        document.querySelector(selector).style.display = visible
            ? "block"
            : "none";
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

    startTimer = () => {
        this.setVisible(".page", true);
        this.setVisible("#loading", false);
        ClockTime(
            timeDisplay => {
                this.setState({ timeDisplay });
            },
            (time, timer) => {
                this.setState({ timer });
                time < 60 ? this.setState({ countdown: time }) : null;
                time < 0 ? this.submitAnswers(true) : null;
            },
            70
        );
    };
    componentDidMount() {
        const quiz = this.props.match.params.subject;
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
                            question.eliminations = [];
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
                console.log(questions);
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

    componentDidUpdate() {}
    submitAnswers = (timesUp = false) => {
        let submit = timesUp ? true : window.confirm("Submit Answers?");
        let obj = {};
        obj.id = this.state.quiz;
        obj.answers = this.state.answers;
        submit
            ? (clearInterval(this.state.timer),
              axios
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
                          this.setState(state => ({
                              mode: 0,
                              results: response.data,
                              counter: 0,
                              questions: updatedQuestions,
                              currentQuestion: updatedQuestions[0]
                          }));
                          this.changeNavButtons(this.state);
                      }
                  })
                  .catch(error => {
                      console.log(error.message);
                  }))
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
            submitAnswers(false);
            return;
        }
        if (counter > questions.length - 1 || counter < 0) return;
        let currentQuestion = questions[counter];
        mode ? "" : (currentQuestion.result = results[counter]);
        this.setState({ counter, currentQuestion }, () =>
            changeNavButtons(this.state)
        );
    };
    sideBarClick = counter => {
        let { questions } = this.state;
        let currentQuestion = questions[counter];
        this.setState({ counter, currentQuestion }, () =>
            this.changeNavButtons(this.state)
        );
    };
    handleAnswerClick = (number, answer) => {
        const answers = [...this.state.answers];
        answers[number - 1] = answer;
        this.setState({ answers });
    };
    eliminateAnswerChoice = (number, choice) => {
        let { questions } = this.state;
        let eliminations = questions[number - 1].eliminations;
        eliminations.includes(choice)
            ? eliminations.splice(eliminations.indexOf(choice), 1)
            : eliminations.push(choice);
        eliminations.sort();
        questions[number - 1].elimations = eliminations;
        this.setState({ questions });
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
    sendReady = () => this.startTimer();
    hideTimer = () =>
        this.setState(state => ({ timerVisibility: !state.timerVisibility }));
    render() {
        const {
            handleClick,
            handleAnswerClick,
            markQuestion,
            sideBarClick,
            eliminateAnswerChoice,
            hideTimer,
            startTimer,
            sendReady
        } = this;
        const {
            currentQuestion,
            answers,
            questions,
            markedQuestions,
            buttons,
            realContent,
            mode,
            results,
            timeDisplay,
            countdown,
            timerVisibility
        } = this.state;
        let marked = currentQuestion
            ? markedQuestions.includes(currentQuestion.number)
            : false;
        return (
            Array.isArray(questions) &&
            questions.length && (
                <div className="question-app-container">
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
                        time={timeDisplay}
                        eliminateAnswerChoice={eliminateAnswerChoice}
                        countdown={countdown}
                        timerVisibility={timerVisibility}
                        hideTimer={hideTimer}
                        startTimer={startTimer}
                        sendReady={sendReady}
                    />

                    <QuestionSidebar
                        onClick={sideBarClick}
                        questions={questions}
                        markedQuestions={markedQuestions}
                        mode={mode}
                        results={results}
                    />
                </div>
            )
        );
    }
}
QuestionApp.propTypes = {};
QuestionApp.defaultProps = {};
export default QuestionApp;
