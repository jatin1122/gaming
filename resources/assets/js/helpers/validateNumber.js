function validateNumber(evt) {
    let theEvent = evt || window.event
    let key = theEvent.keyCode || theEvent.which

    const exceptions = {
        backspace: 8,
        delete: 46,
        leftArrow: 37,
        rightArrow: 39,
        tab: 9,
        enter: 13,
        home: 35,
        end: 36,
        decimalPoint: 110,
        period: 190
    }

    // use (key === 86 && event.ctrlKey) to allow paste
    for (let name in exceptions) {
        if (exceptions[name] === key) {
            return
        }
    }

    // Numpad keys
    if (key >= 96 && key <= 105) {
        key -= 48
    }

    key = String.fromCharCode(key)

    var regex = /[0-9]|\./
    if (
        //doesn't match a number
        !regex.test(key) 
        //shift is being pressed
        || theEvent.shiftKey
    ) {
        theEvent.returnValue = false
        if (theEvent.preventDefault) {
            theEvent.preventDefault()
        }
    }
}

export default validateNumber