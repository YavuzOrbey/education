import React from "react";
import PropTypes from "prop-types";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import {
    faCheck,
    faTimesCircle,
    faTimes
} from "@fortawesome/free-solid-svg-icons";
const AnswerChoice = ({
    num,
    letter = "",
    text = {},
    handleAnswerClick = f => f,
    eliminateAnswerChoice = f => f,
    selected = false,
    eliminated,
    input = false,
    mode,
    result
}) => {
    let icon = result ? (
        result.correct_answer === num + 1 ? (
            <FontAwesomeIcon icon={faCheck} style={{ color: "green" }} />
        ) : result.response === num + 1 ? (
            <FontAwesomeIcon icon={faTimes} style={{ color: "red" }} />
        ) : (
            ""
        )
    ) : (
        ""
    );
    return (
        <div
            className={"question-choice" + (eliminated ? " eliminated" : "")}
            onClick={
                mode && !eliminated ? () => handleAnswerClick(num + 1) : null
            }
        >
            <label
                className="eliminate"
                onClick={
                    mode
                        ? e => (
                              eliminateAnswerChoice(num + 1),
                              e.stopPropagation()
                          )
                        : null
                }
            >
                <FontAwesomeIcon
                    icon={faTimesCircle}
                    style={{ color: "orange" }}
                />
            </label>
            <label className="correct-answer-icon">{icon}</label>

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
};
AnswerChoice.propTypes = {
    letter: PropTypes.string,
    text: PropTypes.array
};
export default AnswerChoice;
