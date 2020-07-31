import React from "react";
const Timer = ({ time, countdown, visibility, hide }) => (
    <div className="timer-wrapper">
        {visibility && (
            <div
                className="timer"
                style={countdown ? { color: "red" } : { color: "black" }}
            >
                Time left: {time}
            </div>
        )}

        <span id="timer-toggle" onClick={hide}>
            <span className={countdown ? "btn btn-danger" : "btn btn-primary"}>
                {visibility ? "Hide" : "Show Timer"}
            </span>
        </span>
    </div>
);
export default Timer;
