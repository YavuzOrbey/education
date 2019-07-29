import React from "react";
import PropTypes from "prop-types";
const AnswerChoice = ({
    letter = "",
    text = "",
    handleAnswerClick = f => f,
    selected = false,
    create = false
}) => (
    <div className="question-choice">
        <label
            className={
                "answer-letter-choice read " + (selected ? "selected" : "")
            }
            onClick={handleAnswerClick}
        >
            {letter}
        </label>
        <div className="question-choice-text">{text}</div>
        <div className="question-choice-eliminate" />
    </div>
);
AnswerChoice.propTypes = {
    letter: PropTypes.string,
    text: PropTypes.object
};
export default AnswerChoice;
