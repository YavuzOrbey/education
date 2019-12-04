const reducer = (accumulator, currentValue) => {
    if (accumulator.length) {
        if (currentValue[1] === accumulator[accumulator.length - 1][1]) {
            accumulator.push([
                currentValue[0] + accumulator[accumulator.length - 1][0],
                accumulator[accumulator.length - 1][1]
            ]);
            accumulator.splice(accumulator.length - 2, 1);
            return accumulator;
        }
    }
    accumulator.push(currentValue);
    return accumulator;
};
var curInv = [
    [21, "Bowling Ball"],
    [2, "Dirty Sock"],
    [1, "Hair Pin"],
    [5, "Microphone"]
];

var newInv = [
    [2, "Hair Pin"],
    [3, "Half-Eaten Apple"],
    [67, "Bowling Ball"],
    [7, "Toothpaste"]
];
function updateInventory(arr1, arr2) {
    // All inventory must be accounted for or you're fired!
    let newArr = arr1.concat(arr2).sort((a, b) => a[1].localeCompare(b[1]));
    return newArr.reduce(reducer, []);
}
updateInventory(curInv, newInv);
