import get_value from '../helpers/get_value'

const selection = document.querySelectorAll('[name="card"]')
for (const radio of selection) {
  radio.addEventListener('change', (e) => {
    let value = e.target.value
    if (value != 'new-card') {
      document.getElementById('new-card-form').hidden = true
      document.getElementById('existing-cvc').hidden = false
      document.getElementById('existing-cvc').setAttribute('required', true)
      document.getElementById('new-card-form').hidden = true
      document.getElementById('existing-cvc').hidden = false
      document.getElementById('existing-card-verification').hidden = false
      return;
    }
    document.getElementById('existing-card-verification').hidden = true
    document.getElementById('existing-cvc').removeAttribute('required')
    document.getElementById('new-card-form').hidden = false
    document.getElementById('existing-cvc').hidden = true
  })
}
const paymentForm = document.getElementById('payment-form');

if(paymentForm) {
  paymentForm.addEventListener('submit', (e) => {
    let selectedCard = document.querySelector('[name="card"]:checked')
    let payButton = document.querySelector('button[type="submit"]')
    let encryptedData = document.getElementById('encrypted-data')

    if (encryptedData.value != '') {
      return true;
    }
  
    e.preventDefault()

    let cse = adyen.encrypt.createEncryption(window.CSE_PUBLIC_KEY)

    let encryptableData = {
      cvc: get_value('existing-cvc'), 
      generationtime: get_value('generation-time')
    }

    if (! encryptableData.cvc && (!selectedCard || selectedCard.value == '' || selectedCard.value == 'new-card')) {
      encryptableData['cvc'] = get_value('cvc')
      encryptableData['number'] = get_value('card-number')
      encryptableData['holderName'] = get_value('cardholder-name')
      encryptableData['expiryMonth'] = get_value('expiry-month')
      encryptableData['expiryYear'] = '20' + get_value('expiry-year')
    }

    encryptedData.value = cse.encrypt(encryptableData)
    
    e.target.submit()
    payButton.disabled = true
  })
}