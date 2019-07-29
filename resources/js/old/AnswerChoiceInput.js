import React from "react";

const AnswerChoiceInput = ({ onChange, answer, letter }) => (
    <div className="answer-choice">
        <div>
            <label className="label answer-letter-choice create">
                {letter}
            </label>
            <label className="checkmark-container">
                <input type="radio" name="correct-answer" value={letter} />
                <span className="checkmark" />
            </label>
        </div>

        <textarea onChange={event => onChange(event, letter)} />
        <div>{answer}</div>
    </div>
);
export default AnswerChoiceInput;
