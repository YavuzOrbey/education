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

        <span className="" onClick={hide}>
            Hide
        </span>
    </div>
);
export default Timer;
