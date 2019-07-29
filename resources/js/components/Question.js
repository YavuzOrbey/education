import React from "react";
import PropTypes from "prop-types";
const Question = ({ data = {} }) => (
  <div className="question-proper">
    <div className="question-number">{data.number}</div>
    <div className="question-text">{data.text}</div>
  </div>
);
Question.propTypes = {
  data: PropTypes.object
};
export default Question;
