import React from "react";
import AnswerChoiceInput from "./AnswerChoiceInput";
import "../../css/create-question.css";
const AnswerChoicesInput = ({
    onChange,
    answerChoicesMath,
    numberOfChoices,
    handleTypeChange,
    answerType,
    answerChoices,
    check
}) => {
    let answerChoiceInputs = [];
    if (answerType == 0) {
        for (let i = 0; i < numberOfChoices; i++) {
            answerChoiceInputs[i] = (
                <AnswerChoiceInput
                    key={i}
                    onChange={onChange}
                    letter={String.fromCharCode(65 + i)}
                    value={i + 1}
                    answer={answerChoicesMath[String.fromCharCode(65 + i)]}
                    answerText={answerChoices[String.fromCharCode(65 + i)]}
                    check={check}
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
                        onChange={e => handleTypeChange(e, 4)}
                    />
                    <label htmlFor="multiple-choice">Multiple Choice</label>
                </div>
                <div>
                    <input
                        type="radio"
                        id="non-multiple-choice"
                        name="answerType"
                        value={1}
                        onChange={e => handleTypeChange(e, 1)}
                    />
                    <label htmlFor="non-multiple-choice">Grid In</label>
                </div>
            </div>

            <div>{answerChoiceInputs}</div>
        </div>
    );
};
export default AnswerChoicesInput;
