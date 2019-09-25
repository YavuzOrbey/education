import React from "react";

const QuestionSidebar = ({ questions, onClick }) => (
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
                </li>
            ))}
        </ul>
    </div>
);
export default QuestionSidebar;
