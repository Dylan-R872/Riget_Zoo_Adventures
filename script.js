// Toggleable Sidebar

function openNav() {
  document.getElementById("sideMenu").style.width = "250px";
  document.getElementById("contentArea").style.marginLeft = "250px";
}

function closeNav() {
  document.getElementById("sideMenu").style.width = "0px";
  document.getElementById("contentArea").style.marginLeft = "0px";
}

function showContent(content) {
  document.getElementById("contentTitle").textContent = content + " Page";
  closeNav()
}

// Carousel

let nextDom = document.getElementById('next');
let prevDom = document.getElementById('prev');

let carouselDom = document.querySelector('.carousel');
let SliderDom = carouselDom.querySelector('.carousel .list');
let thumbnailBorderDom = document.querySelector('.carousel .thumbnail');
let thumbnailItemsDom = thumbnailBorderDom.querySelectorAll('.item');
let timeDom = document.querySelector('.carousel .time');

thumbnailBorderDom.appendChild(thumbnailItemsDom[0]);
let timeRunning = 3000;
let timeAutoNext = 7000;

nextDom.onclick = function(){
    showSlider('next');    
}

prevDom.onclick = function(){
    showSlider('prev');    
}
let runTimeOut;
let runNextAuto = setTimeout(() => {
    next.click();
}, timeAutoNext)
function showSlider(type){
    let  SliderItemsDom = SliderDom.querySelectorAll('.carousel .list .item');
    let thumbnailItemsDom = document.querySelectorAll('.carousel .thumbnail .item');
    
    if(type === 'next'){
        SliderDom.appendChild(SliderItemsDom[0]);
        thumbnailBorderDom.appendChild(thumbnailItemsDom[0]);
        carouselDom.classList.add('next');
    }else{
        SliderDom.prepend(SliderItemsDom[SliderItemsDom.length - 1]);
        thumbnailBorderDom.prepend(thumbnailItemsDom[thumbnailItemsDom.length - 1]);
        carouselDom.classList.add('prev');
    }
    clearTimeout(runTimeOut);
    runTimeOut = setTimeout(() => {
        carouselDom.classList.remove('next');
        carouselDom.classList.remove('prev');
    }, timeRunning);

    clearTimeout(runNextAuto);
    runNextAuto = setTimeout(() => {
        next.click();
    }, timeAutoNext)
}

// FAQ

document.addEventListener("DOMContentLoaded", () =>{
  const questions = document.querySelectorAll(".faq-question");
  
  questions.forEach(question => {
    question.addEventListener("click", ()=> {
      question.classList.toggle("active");
      const answer = question.nextElementSibling;
      const icon = question.querySelector(".icon");
      
      if (answer.style.display === "block") {
        answer.style.display = "none";
        icon.textContent = "+";
      } else {
        answer.style.display = "block";
        icon.textContent ="-";
      }
    });
  });
  
  
});


// Cookie Popup

window.addEventListener("DOMContentLoaded", () => {
    const cookiePopup = document.getElementById("cookiePopup");
    const acceptBtn = document.getElementById("acceptCookies");
    const declineBtn = document.getElementById("declineCookies");
    const resetBtn = document.getElementById("resetCookies");
    const resetWrap = document.querySelector(".footer-reset");
  
    if (!cookiePopup || !acceptBtn || !declineBtn || !resetBtn) {
      console.warn("Cookie popup elements not found.");
      return;
    }
  
    
    function showCookiePopup() {
      cookiePopup.classList.add("active");
    }
    function hideCookiePopup() {
      cookiePopup.classList.remove("active");
    }
  
    
    const saved = localStorage.getItem("cookiesAccepted");
    if (saved !== "true" && saved !== "false") {
      showCookiePopup();
      resetBtn.classList.add("hidden"); 
    } else {
      
      resetBtn.classList.remove("hidden");
    }
  
    
    acceptBtn.addEventListener("click", () => {
      localStorage.setItem("cookiesAccepted", "true");
      hideCookiePopup();
      resetBtn.classList.remove("hidden");
    });
  
   
    declineBtn.addEventListener("click", () => {
      localStorage.setItem("cookiesAccepted", "false");
      hideCookiePopup();
      resetBtn.classList.remove("hidden");
    });
  

    resetBtn.addEventListener("click", () => {
      localStorage.removeItem("cookiesAccepted");
      showCookiePopup();
      resetBtn.classList.add("hidden"); 

      cookiePopup.style.zIndex = 20040;
    });
  
    
    cookiePopup.addEventListener("click", (e) => {
      if (e.target === cookiePopup) hideCookiePopup();
    });
  
    //Accessibility Toolbar
    
    const toolbarSelectors = [
      ".acctoolbar",   
      "#acctoolbar",
      ".access-toolbar",
      ".acc-toolbar",
      ".acctoolbar-wrapper"
    ];
    const toolbar = toolbarSelectors.map(s => document.querySelector(s)).find(Boolean);
  
    if (toolbar && resetWrap) {
      
      const tRect = toolbar.getBoundingClientRect();
      const rRect = resetWrap.getBoundingClientRect();
  
      const rectsOverlap = (a, b) => !(a.right < b.left || a.left > b.right || a.bottom < b.top || a.top > b.bottom);
  
      
      if (rectsOverlap(tRect, rRect)) {
        
        const newBottom = (window.innerHeight - tRect.top) + 12; 
        resetWrap.style.bottom = `${newBottom}px`;
        resetWrap.style.right = "18px";
      }
    }
  });


  

