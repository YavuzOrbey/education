// resources/assets/js/components/App.js

import React, { Component } from "react";
import ReactDOM from "react-dom";
import { BrowserRouter, Route, Switch } from "react-router-dom";
import Header from "./Header";
import QuestionBlock from "./QuestionBlock";
import CreateQuestion from "./CreateQuestion";
import Test from "./Test";
class App extends Component {
    render() {
        return (
            <BrowserRouter>
                <Switch>
                    <div className="container">
                        <Route
                            exact
                            path="/exercises"
                            component={CreateQuestion}
                        />
                    </div>
                </Switch>
            </BrowserRouter>
        );
    }
}

ReactDOM.render(<App />, document.getElementById("app"));
