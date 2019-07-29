import React from "react";
const MathJax = require("react-mathjax");
const tex = `f(x) = \\int_{-\\infty}^\\infty
    \\hat f(\\xi)\\,e^{2 \\pi i \\xi x}
    \\,d\\xi`;

const Test = () => (
    <MathJax.Provider>
        <div>
            This is an inline math formula:{" "}
            <MathJax.Node inline formula={"a = b"} />
            And a block one:
            <MathJax.Node formula={tex} />
        </div>
    </MathJax.Provider>
);

export default Test;
/*
MathInput
 render() {
        return (
            <div className="question-proper">
                <div className="question-number" />

                <div
                    tabIndex="0"
                    className="question-text editable"
                    onClick={this.handleClick}
                    onKeyUp={event => this.props.changeHistory(event)}
                >
                    {this.props.text}
                </div>
            </div>
        );
    }
 */
