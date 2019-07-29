import React from "react";
import AnswerChoice from "./AnswerChoice";
import PropTypes from "prop-types";
const AnswerChoices = ({
  choices = {},
  handleAnswerClick,
  selected = true
}) => {
  const entries = Object.entries(choices);
  return entries.map((choice, i) => (
    <AnswerChoice
      key={i}
      letter={choice[0]}
      text={choice[1]}
      selected={choice[0] === selected ? true : false}
      handleAnswerClick={() => handleAnswerClick(choice[0])}
    />
  ));
};
AnswerChoices.propTypes = {
  choices: PropTypes.object
};
export default AnswerChoices;
