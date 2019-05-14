import React from "react";
import ReactDOM from "react-dom";
import axios from "axios";
let j = 0;

class CreateQuestion extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            currentButton: null,
            history: []
        };
        this.inputButtonValue = this.inputButtonValue.bind(this);
        this.changeHistory = this.changeHistory.bind(this);
    }
    stopPropagation(e) {
        e.stopPropagation();
        e.nativeEvent.stopImmediatePropagation();
    }
    changeHistory(event) {
        this.stopPropagation(event);
        const history = this.state.history;
        switch (event.keyCode) {
            case 8:
                this.setState({
                    history: history.slice(0, history.length - 1)
                });
                break;
            case 16:
                break;
            default:
                this.setState({ history: history.concat(event.key) });
        }
    }
    inputButtonValue(j) {
        // you have to understand that j could be just a latex expression `something` or it could be a full blown frac that has MathInputs as it's params
        const history = this.state.history;
        if (typeof j === Object) {
            console.log(JSON.stringify(j));
        }
        this.setState({
            currentButton: j,
            history: history.concat(j)
        });
    }
    render() {
        return (
            <div className="question-block">
                <Toolbar
                    onClick={this.inputButtonValue}
                    changeHistory={this.changeHistory}
                />
                <MathInput
                    currentButton={this.state.currentButton}
                    changeHistory={this.changeHistory}
                    text={this.state.history}
                />
            </div>
        );
    }
}
class Toolbar extends React.Component {
    renderButton(i, index, whatToDisplay) {
        //here the onclick property of a toolbarbutton is an anoymous function which returns a function (with a argument of i passed to it) passed from the parent
        return (
            <ToolbarButton
                key={index}
                value={i}
                onClick={() => this.props.onClick(whatToDisplay)}
            >
                {/*fsdfsdfsdfsd */}
            </ToolbarButton>
        );
    }
    render() {
        const buttonsObj = {
            "`x`": `x`,
            "`sqrt(x)`": <MathInput changeHistory={this.props.changeHistory} />
        };
        //"`sqrt(" + <MathInput /> + ")`"
        const buttonsAsArray = Object.keys(buttonsObj).map((key, index) => {
            return this.renderButton(key, index, buttonsObj[key]);
        });
        /* const buttons = ["`x`", "`sqrt(x)`", "`z`", "`frac{x}{y}`"];
        const buttonsAsArray = buttons.map((button, index) => {
            return this.renderButton(button, index);
        }); */
        return <div className="toolbar">{buttonsAsArray}</div>;
    }
}

class ToolbarButton extends React.Component {
    handleClick() {}
    render() {
        return (
            <button
                tabIndex="-1"
                onClick={this.props.onClick}
                value={this.props.value}
            >
                {this.props.value}
            </button>
        );
    }
}
class MathInput extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            history: []
        };
        this.textInput = React.createRef();
        this.handleClick = this.handleClick.bind(this);
        this.handleKeyPress = this.handleKeyPress.bind(this);
    }

    handleClick(event) {
        event.stopPropagation();
        console.log(document.activeElement);
        console.log(this.textInput.current);
        //this.textInput.current.focus();
    }
    handleKeyPress(event) {}
    componentDidUpdate() {
        MathJax.Hub.Queue(["Typeset", MathJax.Hub, "output"]);
    }
    componentDidMount() {
        this.textInput.current.focus();
        console.log(document.activeElement);
    }
    render() {
        return (
            <div
                tabIndex="0"
                className="editable"
                onClick={this.handleClick}
                onKeyUp={event => this.props.changeHistory(event)}
                ref={this.textInput}
            >
                {this.props.text}
            </div>
        );
    }
}

export default CreateQuestion;
