import React from "react";
const QuestionNav = ({ onClick, markQuestion, buttons, marked, mode }) => (
    <div className="question-nav">
        <button className="nav-button back" onClick={() => onClick(0)}>
            {buttons[0]}
        </button>
        <button
            className="nav-button mark"
            onClick={mode ? () => markQuestion() : null}
        >
            {marked ? "UNMARK" : "MARK"}
        </button>
        {buttons[1] === "FINISH" ? (
            <button
                className="nav-button finish"
                onClick={mode ? () => onClick(2) : null}
            >
                {buttons[1]}
            </button>
        ) : (
            <button className="nav-button next" onClick={() => onClick(1)}>
                {buttons[1]}
            </button>
        )}
    </div>
);

export default QuestionNav;
