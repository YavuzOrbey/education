import React from "react";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faEye } from "@fortawesome/free-solid-svg-icons";
const QuestionSidebar = ({ questions, onClick, markedQuestions }) => (
    <div className="question-sidebar">
        <ul className="question-list">
            <li className="question-list-title">Questions</li>
            {questions.map((question, i) => (
                <li
                    onClick={() => onClick(question.number - 1)}
                    key={i}
                    className="question"
                >
                    {question.number}

                    <span>
                        {markedQuestions.includes(question.number) ? (
                            <FontAwesomeIcon
                                icon={faEye}
                                style={{ color: "red", textAlign: "right" }}
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
