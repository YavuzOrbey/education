import React from "react";
import ReactDOM from "react-dom";
import axios from "axios";
let j = 0;

class QuestionBlock extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            currentQuestion: {
                question: { 0: "This is an example question" },
                question_choices: { A: "A", B: "B", C: "C", D: "D" }
            },
            questions: [],
            counter: 0
        };
    }

    componentDidMount() {
        axios.get("/api/questions1").then(response => {
            this.setState({
                questions: response.data,
                currentQuestion: response.data[0]
            });
        });
    }
    handleClick(j) {
        let counter = this.state.counter;
        j ? counter++ : counter--;
        if (counter > this.state.questions.length - 1 || counter < 0) return;
        this.setState({
            currentQuestion: this.state.questions[counter],
            counter: counter
        });
    }
    render() {
        const { question, question_choices } = this.state.currentQuestion;
        return (
            <div className="question-block">
                <Question data={question} />
                <QuestionChoices choices={question_choices} />
                <QuestionNav onClick={j => this.handleClick(j)} />
            </div>
        );
    }
}
QuestionBlock.defaultProps = {
    currentQuestion: {
        question: { 0: "This is an example question" },
        question_choices: { A: "A", B: "B", C: "C", D: "D" }
    },
    counter: 0
};
const Question = props => (
    <div className="question-proper">
        <div className="question-number">{Object.keys(props.data)[0]}</div>
        <div className="question-text editable" onClick={props.onClick}>
            {props.data[Object.keys(props.data)[0]]}
        </div>
    </div>
);
class QuestionChoices extends React.Component {
    renderChoice(i) {
        return (
            <QuestionChoice
                letter={i /*Object.keys(this.props.choices[i])*/}
                text={this.props.choices[i]}
                onClick={j => this.props.onClick(j)}
            />
        );
    }
    render() {
        return (
            <div className="question-choices">
                {this.renderChoice("A")}
                {this.renderChoice("B")}
                {this.renderChoice("C")}
                {this.renderChoice("D")}
            </div>
        );
    }
}
const QuestionChoice = ({ letter, text, onClick }) => (
    <div className="question-choice">
        <div className="question-letter-choice">{letter}</div>
        <div className="question-choice-text editable" onClick={onClick}>
            {text}
        </div>
        <div className="question-choice-eliminate" />
    </div>
);

const QuestionNav = props => (
    <div className="question-nav">
        <button className="nav-button back" onClick={() => props.onClick(0)}>
            BACK
        </button>
        <button className="nav-button mark" onClick={() => props.onClick(1)}>
            MARK
        </button>
        <button className="nav-button next" onClick={() => props.onClick(1)}>
            NEXT
        </button>
    </div>
);

export default QuestionBlock;
