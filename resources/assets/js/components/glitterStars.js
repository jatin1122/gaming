  (function() {
  var body1 = document.querySelector('#starshine'),
      body2 = document.querySelector('#starshine2'),
      body3 = document.querySelector('#starshine3'),
      template = document.querySelector('.template.shine'),
      size = 'small',
      stars =  300,
      sparkle = 20;
  
  var createStar = function(body) {
    newTemplate = template.cloneNode(true)
    newTemplate.removeAttribute('id')
    newTemplate.style.top = (Math.random() * 100) + '%'
    newTemplate.style.left = (Math.random() * 100) + '%'
    newTemplate.style.webkitAnimationDelay = (Math.random() * sparkle) + 's'
    newTemplate.style.mozAnimationDelay = (Math.random() * sparkle) + 's'
    newTemplate.classList.add(size)
    body.appendChild(newTemplate)
  };


  if(body1) {    
    for(var i = 0; i < stars; i++) {
      if(i % 2 === 0) {
        size = 'small';
      } else if(i % 3 === 0) {
        size = 'medium';
      } else {
        size = 'large';
      }      
      createStar(body1);
    }
  }

  if(body2) {    
    for(var i = 0; i < stars; i++) {
      if(i % 2 === 0) {
        size = 'small';
      } else if(i % 3 === 0) {
        size = 'medium';
      } else {
        size = 'large';
      }      
      createStar(body2);
    }
  }

  if(body3) {    
    for(var i = 0; i < stars; i++) {
      if(i % 2 === 0) {
        size = 'small';
      } else if(i % 3 === 0) {
        size = 'medium';
      } else {
        size = 'large';
      }      
      createStar(body3);
    }
  }

})();