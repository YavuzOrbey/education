import React from "react";
import AnswerChoice from "./AnswerChoice";
import PropTypes from "prop-types";
const AnswerChoices = ({
    choices = {},
    handleAnswerClick,
    selected = true,
    mode,
    eliminations,
    eliminateAnswerChoice,
    result
}) => {
    const entries = Object.entries(choices);
    return entries.map((choice, i) => (
        <AnswerChoice
            key={i}
            letter={choice[0]}
            num={i}
            text={choice[1]}
            selected={i + 1 === selected ? true : false}
            handleAnswerClick={num => handleAnswerClick(num)}
            eliminateAnswerChoice={num => eliminateAnswerChoice(num)}
            eliminated={eliminations.includes(i + 1)}
            mode={mode}
            result={result}
        />
    ));
};
AnswerChoices.propTypes = {
    choices: PropTypes.object
};
export default AnswerChoices;
