import React from "react";
import QuestionNav from "./QuestionNav";
import AnswerChoices from "./AnswerChoices";
import RelatedContent from "./RelatedContent";
import Question from "./Question";
import PropTypes from "prop-types";
import MathJax from "react-mathjax2";
import "../../css/exercises.css";
const QuestionBlock = ({
    handleClick,
    handleAnswerClick,
    markQuestion,
    marked,
    questions,
    currentQuestion,
    realContent,
    answers,
    buttons
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
                            handleAnswerClick={letter =>
                                handleAnswerClick(
                                    currentQuestion.number,
                                    letter
                                )
                            }
                            selected={answers[currentQuestion.number - 1]}
                        />
                    </div>
                ) : (
                    <div className="grid-input">
                        <input
                            onChange={e =>
                                handleAnswerClick(
                                    currentQuestion.number,
                                    e.target.value
                                )
                            }
                            type="number"
                        ></input>
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
