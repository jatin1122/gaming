const handleCloseAccordian = (trigger, element, activeClass) => {
    trigger.classList.remove(activeClass)
    element.classList.remove(activeClass)
    element.hidden = true
}
const handleOpenAccordian = (trigger, element, activeClass) => {
    trigger.classList.add(activeClass)
    element.classList.add(activeClass)
    element.hidden = false
}

const handleAccordianTriggerClick = (trigger, contentElements, activeClass = 'is-active') => {
    for(let element of contentElements) {
        if (element.classList.contains(activeClass)) {
            handleCloseAccordian(trigger, element, activeClass)
        } else {
            handleOpenAccordian(trigger, element, activeClass)
        }
    }
}

const accordianTriggers = document.querySelectorAll('[data-accordian-group][data-accordian-trigger]')

for (let trigger of accordianTriggers) {
    let { accordianGroup, accordianTrigger } = trigger.dataset
    let contentElements = document.querySelectorAll(`
        [data-accordian-group=${accordianGroup}][data-accordian-content='${accordianTrigger}']
    `)
    trigger.addEventListener('click', () => handleAccordianTriggerClick(trigger, contentElements))
}