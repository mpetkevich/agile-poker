// const oldFib = n => {
//     if (n <= 1) {
//         return n;
//     } else {
//         return oldFib(n - 1) + oldFib(n - 2);
//     }
// }
//
// const memoize = f => {
//     const cache = {};
//     return arg => cache[arg] || (cache[arg] = f(arg));
// }
//
// const fibonacci = memoize(oldFib);


function* fibonacci() {
    let fn1 = 1;
    let fn2 = 1;
    while (true) {
        let current = fn2;
        fn2 = fn1;
        fn1 = fn1 + current;
        let reset = yield current;
        if (reset) {
            fn1 = 1;
            fn2 = 1;
        }
    }
}

const fibonacciSequence = fibonacci();


// the next fibonacci after given dec number
export const fibCeil = decNumber => {
    let fibonacciNumber = fibonacciSequence.next(true).value; //reset generator
    while (fibonacciNumber < decNumber) {
        fibonacciNumber = fibonacciSequence.next().value;
    }
    return fibonacciNumber;
}

// the fibonacci number before given dec number
export const fibFloor = decNumber => {
    let fibonacciNumber;
    let nextFibonacciNumber = fibonacciSequence.next(true).value; //reset generator;
    do {
        fibonacciNumber = nextFibonacciNumber;
        nextFibonacciNumber = fibonacciSequence.next().value;
    } while (nextFibonacciNumber <= decNumber)
    return fibonacciNumber;
}