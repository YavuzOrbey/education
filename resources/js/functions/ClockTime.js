const compose = (...fns) => arg =>
    fns.reduce((composed, f) => {
        return f(composed);
    }, arg);

/* // compose = function(...fns){
        return function(arg){
            return fns.reduce(function(composed,f){
                return f(composed)
            }, arg)
        }
    } */
const display = target => time => target(time);
const oneSecond = () => 1000;
const convertToMilliseconds = seconds => seconds * oneSecond();
const serializeClockTime = time => {
    let hours = Math.floor(time / (oneSecond() * 60 * 60));
    let remainingTime = time - hours * 60 * 60 * oneSecond();
    let minutes = Math.floor(remainingTime / (oneSecond() * 60));
    remainingTime = remainingTime - minutes * 60 * oneSecond();
    let seconds = Math.floor(remainingTime / oneSecond());
    return {
        hours,
        minutes,
        seconds
    };
};
const prependZero = key => clockTime => ({
    ...clockTime,
    [key]: clockTime[key] < 10 ? "0" + clockTime[key] : clockTime[key]
});
const doubleDigits = civilianTime =>
    compose(
        prependZero("hours"),
        prependZero("minutes"),
        prependZero("seconds")
    )(civilianTime);
const formatClock = format => time => {
    return format
        .replace("hh", time.hours)
        .replace("mm", time.minutes)
        .replace("ss", time.seconds);
};
// ClockTime accepts three arguments: a function that sets the time in state, a function that clears the interval and submits answers, and a timeLimit integer
const ClockTime = (setTime, endFunction, limit = 60) => {
    let timer = setInterval(() => {
        compose(
            convertToMilliseconds,
            serializeClockTime,
            doubleDigits,
            formatClock("hh:mm:ss"),
            display(setTime)
        )(limit);
        endFunction((limit -= 1), timer);
    }, oneSecond());
    return timer;
};
export default ClockTime;
