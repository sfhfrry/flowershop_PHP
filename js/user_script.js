const userBtn = document.querySelector('#user-btn');  
userBtn.addEventListener('click', function() {  
    const userBox = document.querySelector('.profile');  
    userBox.classList.toggle('active');  
});  

// Navbar section  
const toggle = document.querySelector('#menu-btn');  
toggle.addEventListener('click', function() {  
    const navbar = document.querySelector('.navbar');  
    navbar.classList.toggle('active');  
});  

// Search section  
let searchForm = document.querySelector('.search-form');  
document.querySelector('#search-btn').onclick = () => {  
    searchForm.classList.toggle('active');  
    const userBox = document.querySelector('.profile'); // Đảm bảo userBox được khai báo  
    userBox.classList.remove('active');  
};  

// Slider section  
let slider = document.querySelectorAll('.slider-item');  
let sliderIndex = 0;  // Đổi tên biến để tránh xung đột với biến index trong phần testimonial  

function nextSlide() {  
    slider[sliderIndex].classList.remove('active');  
    sliderIndex = (sliderIndex + 1) % slider.length;  
    slider[sliderIndex].classList.add('active');  
}  

function prevSlide() {  
    slider[sliderIndex].classList.remove('active');  
    sliderIndex = (sliderIndex - 1 + slider.length) % slider.length;  
    slider[sliderIndex].classList.add('active');  
}  

// Testimonial section  
let testimonialSlides = document.querySelectorAll('.testimonial-item');  
let testimonialIndex = 0;  // Đổi tên biến để tránh xung đột  

function rightSlide() {  
    testimonialSlides[testimonialIndex].classList.remove('active');  
    testimonialIndex = (testimonialIndex + 1) % testimonialSlides.length;  
    testimonialSlides[testimonialIndex].classList.add('active');  
}  

function leftSlide() {  
    testimonialSlides[testimonialIndex].classList.remove('active');  
    testimonialIndex = (testimonialIndex - 1 + testimonialSlides.length) % testimonialSlides.length;  
    testimonialSlides[testimonialIndex].classList.add('active');  
}  

// Timer  
(function () {  
    const second = 1000,  
        minute = second * 60,  
        hour = minute * 60,  
        day = hour * 24;  

    let today = new Date(),  
        dd = String(today.getDate()).padStart(2, "0"),  
        mm = String(today.getMonth() + 1).padStart(2, "0"),  
        yyyy = today.getFullYear(),  
        nextYear = yyyy + 1,  
        dayMonth = "09-30-",  
        birthday = dayMonth + yyyy;  

    // Kiểm tra ngày hôm nay và thiết lập ngày sinh nhật  
    today = mm + "/" + dd + "/" + yyyy;  
    if (today > birthday) {  
        birthday = dayMonth + nextYear;  
    }  

    const countDown = new Date(birthday).getTime();  

    const x = setInterval(function () {  
        const now = new Date().getTime(),  
            distance = countDown - now;  

        // Tính toán thời gian còn lại  
        const days = Math.floor(distance / day);  
        const hours = Math.floor((distance % day) / hour);  
        const minutes = Math.floor((distance % hour) / minute);  
        const seconds = Math.floor((distance % minute) / second);  

        // Cập nhật các phần tử HTML  
        document.getElementById("days").innerText = days;  
        document.getElementById("hours").innerText = hours;   
        document.getElementById("minutes").innerText = minutes;  
        document.getElementById("seconds").innerText = seconds;  

        // Nếu thời gian đếm ngược đã hết, dừng lại  
        if (distance < 0) {  
            clearInterval(x);  
            document.getElementById("countdown").innerHTML = "Thời gian đã hết!";  
        }  
    }, 1000); // Cập nhật mỗi giây  
}());