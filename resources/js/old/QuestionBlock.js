import React from "react";
import QuestionNav from "./QuestionNav";
import AnswerChoices from "./AnswerChoices";
import Question from "./Question";
import PropTypes from "prop-types";
import MathJax from "react-mathjax2";
const QuestionBlock = ({
    handleClick,
    handleAnswerClick,
    currentQuestion,
    answers
}) => {
    return (
        <div className="question-block">
            <MathJax.Context input="tex">
                <Question
                    data={{
                        number: currentQuestion.number,
                        text: currentQuestion.question_text
                    }}
                />
            </MathJax.Context>
            <MathJax.Context input="tex">
                <div className="question-choices">
                    <AnswerChoices
                        choices={currentQuestion.answer_choices}
                        handleAnswerClick={letter =>
                            handleAnswerClick(currentQuestion.number, letter)
                        }
                        selected={answers[currentQuestion.number - 1]}
                    />
                </div>
            </MathJax.Context>
            <QuestionNav
                onClick={j => {
                    handleClick(j);
                }}
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
