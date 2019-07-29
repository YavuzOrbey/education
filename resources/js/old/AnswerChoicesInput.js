import React from "react";
import AnswerChoiceInput from "./AnswerChoiceInput";
import "../../css/create-question.css";
const AnswerChoicesInput = ({
    onChange,
    answerChoices,
    numberOfChoices,
    handleTypeChange,
    answerType
}) => {
    let answerChoiceInputs = [];
    if (answerType == 0) {
        for (let i = 0; i < numberOfChoices; i++) {
            answerChoiceInputs[i] = (
                <AnswerChoiceInput
                    key={i}
                    onChange={onChange}
                    letter={String.fromCharCode(65 + i)}
                    answer={answerChoices[String.fromCharCode(65 + i)]}
                />
            );
        }
    } else {
        answerChoiceInputs = <input type="number" />;
    }
    return (
        <div className="answer-choices">
            <label className="label">Answer Choices</label>
            <div id="answer-type">
                <div>
                    <input
                        type="radio"
                        id="multiple-choice"
                        name="answerType"
                        value={0}
                        defaultChecked
                        onChange={handleTypeChange}
                    />
                    <label htmlFor="multiple-choice">Multiple Choice</label>
                </div>
                <div>
                    <input
                        type="radio"
                        id="non-multiple-choice"
                        name="answerType"
                        value={1}
                        onChange={handleTypeChange}
                    />
                    <label htmlFor="non-multiple-choice">Grid In</label>
                </div>
            </div>

            <div>{answerChoiceInputs}</div>
        </div>
    );
};
export default AnswerChoicesInput;
