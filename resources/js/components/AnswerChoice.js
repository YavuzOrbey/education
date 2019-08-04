import React from "react";
import PropTypes from "prop-types";
const AnswerChoice = ({
    letter = "",
    text = "",
    handleAnswerClick = f => f,
    selected = false,
    input = false
}) => (
    <div className="question-choice" onClick={handleAnswerClick}>
        <label
            className={
                "answer-letter-choice read " + (selected ? "selected" : "")
            }
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
