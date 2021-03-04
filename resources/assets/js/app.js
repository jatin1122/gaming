/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import validateNumber from './helpers/validateNumber'
import addInputRestriction from './helpers/addInputRestriction'
import Swiper from 'swiper'

// import './bootstrap'
import './payment/cse'
import './components/accordian'
import './components/profilePreview'
import './components/glitterStars'

const restrictedElements = document.querySelectorAll('[data-js-restrict-input]')

for (let element of restrictedElements) {
    if (element.dataset.jsRestrictInput.includes('number')) {
        addInputRestriction(element, validateNumber)
    }
}

(function(){
    const homeGameSliders = document.querySelectorAll('.home-game__swiper-container')
    for(let container of homeGameSliders) {
        let swiper = new Swiper(container, {
            // lazy: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: true,
            },
            loop: true,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        })
    }
})();