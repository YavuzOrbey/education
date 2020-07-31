import React from "react";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faThumbtack } from "@fortawesome/free-solid-svg-icons";
import { faCheck } from "@fortawesome/free-solid-svg-icons";
import { faTimes } from "@fortawesome/free-solid-svg-icons";
const QuestionSidebar = ({
    questions,
    onClick,
    markedQuestions,
    mode,
    results
}) => (
    <div className="question-sidebar">
        <ul className="question-list">
            {questions.map((question, i) => (
                <li
                    onClick={() => onClick(question.number - 1)}
                    key={i}
                    className="question"
                >
                    {question.number}
                    {mode ? (
                        ""
                    ) : results[i].response == results[i].correct_answer ? (
                        <FontAwesomeIcon
                            icon={faCheck}
                            style={{ color: "green" }}
                        />
                    ) : (
                        <FontAwesomeIcon
                            icon={faTimes}
                            style={{ color: "red" }}
                        />
                    )}
                    <span>
                        {markedQuestions.includes(question.number) ? (
                            <FontAwesomeIcon
                                icon={faThumbtack}
                                style={{ color: "#e03838", textAlign: "right" }}
                            />
                        ) : (
                            ""
                        )}
                    </span>
                </li>
            ))}
        </ul>
    </div>
);
export default QuestionSidebar;
