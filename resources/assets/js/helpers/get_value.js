export default function get_value (element) {
  element = document.getElementById(element)
  return element ? element.value : ''
}