import React from "react";

const AnswerChoiceInput = ({
    check,
    onChange,
    answer,
    letter,
    value,
    answerText
}) => (
    <div className="answer-choice">
        <div className="answer-letter-container">
            <label className="label answer-letter-choice create">
                {letter}
            </label>
            <label className="checkmark-container">
                <input
                    type="radio"
                    name="correct-answer"
                    value={value}
                    onChange={check}
                />
                <span className="checkmark" />
            </label>
        </div>

        <textarea
            value={answerText}
            onChange={event => onChange(event, letter)}
        />
        <div className="answer-choice-text">{answer}</div>
    </div>
);
export default AnswerChoiceInput;
