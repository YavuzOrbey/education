import React from "react";
import QuestionNav from "./QuestionNav";
import AnswerChoices from "./AnswerChoices";
import RelatedContent from "./RelatedContent";
import Question from "./Question";
import PropTypes from "prop-types";
import MathJax from "react-mathjax2";
import "../../css/exercises.css";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faCheck } from "@fortawesome/free-solid-svg-icons";
import { faTimes } from "@fortawesome/free-solid-svg-icons";
const QuestionBlock = ({
    handleClick,
    handleAnswerClick,
    markQuestion,
    marked,
    currentQuestion,
    realContent,
    answers,
    buttons,
    mode
}) => {
    return (
        <div className="question-block read">
            {currentQuestion.related_content ? (
                <RelatedContent
                    relatedContent={
                        realContent[currentQuestion.related_content]
                    }
                />
            ) : (
                ""
            )}
            {marked ? <span className="marked">Marked</span> : ""}
            <MathJax.Context input="tex">
                <Question
                    data={{
                        number: currentQuestion.number,
                        text: currentQuestion.question_text
                    }}
                />
            </MathJax.Context>
            <MathJax.Context input="tex">
                {currentQuestion.answer_choices ? (
                    <div className="question-choices">
                        <AnswerChoices
                            choices={currentQuestion.answer_choices}
                            result={currentQuestion.result}
                            handleAnswerClick={letter =>
                                handleAnswerClick(
                                    currentQuestion.number,
                                    letter
                                )
                            }
                            selected={answers[currentQuestion.number - 1]}
                            mode={mode}
                        />
                    </div>
                ) : mode ? (
                    <div className="grid-input">
                        <input
                            onChange={e =>
                                handleAnswerClick(
                                    currentQuestion.number,
                                    e.target.value
                                )
                            }
                            type="number"
                            placeholder={answers[currentQuestion.number - 1]}
                        ></input>
                    </div>
                ) : currentQuestion.result.correct_answer ==
                  currentQuestion.result.response ? (
                    <div>
                        <FontAwesomeIcon
                            icon={faCheck}
                            style={{ color: "green" }}
                        />
                        <div className="grid-input">
                            <input
                                type="number"
                                disabled
                                placeholder={
                                    answers[currentQuestion.number - 1]
                                }
                            ></input>
                        </div>
                    </div>
                ) : (
                    <div>
                        <FontAwesomeIcon
                            icon={faTimes}
                            style={{ color: "red" }}
                        />
                        <div className="grid-input">
                            <input
                                type="number"
                                disabled
                                placeholder={
                                    answers[currentQuestion.number - 1]
                                }
                            ></input>
                        </div>
                        {currentQuestion.result.correct_answer}
                    </div>
                )}
            </MathJax.Context>
            <QuestionNav
                onClick={j => {
                    handleClick(j);
                }}
                markQuestion={() => markQuestion(currentQuestion.number)}
                buttons={buttons}
                marked={marked}
                mode={mode}
            />
        </div>
    );
};
QuestionBlock.defaultProps = {
    currentQuestion: {
        question: { 0: "This is an example question" },
        answer_choices: { A: "A", B: "B", C: "C", D: "D" }
    },
    handleClick: () => console.log("handleClick function pressed")
};

QuestionBlock.propTypes = {
    currentQuestion: PropTypes.object,
    handleClick: PropTypes.func
};

export default QuestionBlock;
