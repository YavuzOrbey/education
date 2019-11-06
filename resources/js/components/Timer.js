import React from "react";
const Timer = ({ time }) => (
    <div className="timer-wrapper">
        <div className="timer">
            Time left: {time}
            <div
                className="closeBtn"
                style={{
                    borderRadius: 0,
                    backgroundColor: "rgb(120, 120, 120, 0.9)"
                }}
            ></div>
        </div>
    </div>
);
export default Timer;
