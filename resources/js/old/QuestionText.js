import React from "react";
import PropTypes from "prop-types";
import MathJax from "react-mathjax2";
import "../../css/create-question.css";
const QuestionText = ({ onChange, questionText }) => (
    <div className="question-proper">
        <div className="question-text">
            <div className="math-input">
                <label className="label">Question Text</label>
                <textarea
                    onChange={onChange}
                    placeholder="Type a question using LaTex"
                />
            </div>

            <div className="math-output">{questionText}</div>
        </div>
        <div className="question-info">
            <div className="question-subject">
                <label className="label">Subject</label>
                <select>
                    <option value="Math">Math</option>
                </select>
            </div>
            <div className="question-tags">
                <label className="label">Tags</label>
                <select>
                    <option value="Calculus">Calculus</option>
                </select>
            </div>
        </div>
    </div>
);
export default QuestionText;
