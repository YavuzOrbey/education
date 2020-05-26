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

/* function permutation(before, arr) {
    if (arr.length == 1) {
        return before.concat(arr);
    } else {
        let newArr = [];
        for (let i = 0; i < arr.length; i++) {
            let newElement = before.concat(
                permutation(
                    arr[i],
                    arr.filter((e, j) => j != i)
                )
            );
            newArr.push(newElement);
        }
        return newArr;
    }
}
console.log(permAlone("abcd")); */

function permutation(str) {
    if (str.length == 1) {
        return [str];
    } else {
        let permutations = [];
        for (let i = 0; i < str.length; i++) {
            let perm = permutation(
                str.slice(0, i).concat(str.slice(i + 1, str.length))
            );
            perm.forEach(j => {
                permutations.push(str[i] + j);
            });
        }
        return permutations;
    }
}
function permAlone(str) {
    let arrayOfPermuations = permutation(str.split(""));
    console.log(arrayOfPermuations);
    let regex = /(\w)\1/;
    let nonRepeating = arrayOfPermuations
        .flat()
        .filter(perm => !regex.test(perm));
    return nonRepeating.length;
}
console.log(permAlone("abfdefa"));

function sym(...args) {
    let newAcc = [];
    const reducer = (acc, cur) =>
        acc
            .filter(
                (elem, index) =>
                    !cur.includes(elem) && acc.indexOf(elem) == index
            )
            .concat(
                cur.filter(
                    (elem, index) =>
                        !acc.includes(elem) && cur.indexOf(elem) === index
                )
            );
    return args.reduce(reducer).sort();
}
console.log(sym([1, 2, 3, 3], [5, 2, 1, 4]));
