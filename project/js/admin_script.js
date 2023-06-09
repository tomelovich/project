let navbar = document.querySelector('.header .navbar');
let accountBox = document.querySelector('.header .account-box');

document.querySelector('#menu-btn').onclick = () =>{
   navbar.classList.toggle('active');
   accountBox.classList.remove('active');
}

document.querySelector('#user-btn').onclick = () =>{
   accountBox.classList.toggle('active');
   navbar.classList.remove('active');
}

window.onscroll = () =>{
   navbar.classList.remove('active');
   accountBox.classList.remove('active');
}

const openModalBtns = document.querySelectorAll('.openModal');
const closeModalBtns = document.querySelectorAll('.close');

openModalBtns.forEach((openModalBtn) => {
    openModalBtn.onclick = function() {
        const reviewId = this.dataset.reviewId;
        const modal = document.getElementById(`myModal-${reviewId}`);
        modal.style.display = 'block';
    };
});

closeModalBtns.forEach((closeModalBtn) => {
    closeModalBtn.onclick = function() {
        const modal = this.closest('.modal');
        modal.style.display = 'none';
    };
});

window.onclick = function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.style.display = 'none';
    }
};

const filterToggleBtn = document.querySelector('.filter-toggle-btn');
const filterContainer = document.querySelector('.filter');

filterToggleBtn.addEventListener('click', () => {
   const isCollapsed = filterContainer.classList.toggle('collapsed');
   filterToggleBtn.setAttribute('aria-expanded', !isCollapsed);
});
