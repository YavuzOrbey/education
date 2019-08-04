// resources/assets/js/components/App.js

import React, { Component } from "react";
import ReactDOM from "react-dom";
import { BrowserRouter, Route, Switch } from "react-router-dom";
import Header from "./Header";
import QuestionApp from "./QuestionApp";
import CreateQuestionApp from "./CreateQuestionApp";
import Test from "./Test";
class App extends Component {
    render() {
        return (
            <div className="container">
                <BrowserRouter>
                    <Switch>
                        <Route
                            exact
                            path="/exercises"
                            component={QuestionApp}
                        />
                        <Route
                            exact
                            path="/questions/create"
                            component={CreateQuestionApp}
                        />
                    </Switch>
                </BrowserRouter>
            </div>
        );
    }
}

ReactDOM.render(<App />, document.getElementById("app"));
