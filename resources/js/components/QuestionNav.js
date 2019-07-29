import React from "react";
const QuestionNav = ({ onClick }) => (
  <div className="question-nav">
    <button className="nav-button back" onClick={() => onClick(0)}>
      BACK
    </button>
    <button className="nav-button mark" onClick={() => onClick(1)}>
      MARK
    </button>
    <button className="nav-button next" onClick={() => onClick(1)}>
      NEXT
    </button>
  </div>
);

export default QuestionNav;
