require('./bootstrap');

window.addEventListener('DOMContentLoaded', event => {
    const sidebarToggleEl = document.body.querySelector('#sidebarToggle');
    if (sidebarToggleEl) {
        if (localStorage.getItem('sidenav-closed') === "true") {
            document.querySelector("div#app").classList.toggle('sidenav-closed');
        }
        sidebarToggleEl.addEventListener('click', event => {
            event.preventDefault();
            document.querySelector("div#app").classList.toggle('sidenav-closed');
            localStorage.setItem('sidenav-closed', document.querySelector("div#app").classList.contains('sidenav-closed'));
        });
    }

    let windowWidth = window.innerWidth;
    if(windowWidth < 768){
        document.querySelector("div#app").classList.add('sidenav-closed');
        localStorage.setItem('sidenav-closed', document.querySelector("div#app").classList.contains('sidenav-closed'));
    }

    const loadingOverlayEl = document.body.querySelector('#loadingOverlay');
    const spinnerEl = document.body.querySelector('#loadingOverlay .spinner');
    if(loadingOverlayEl && spinnerEl){
        setTimeout(()=>{
            spinnerEl.style.borderTop = "7px solid #f8fafc";

            loadingOverlayEl.style.transition = "0.3s ease-in-out";
            loadingOverlayEl.style.transform = "scale(25)";
            loadingOverlayEl.style.opacity = "0";
            setTimeout(()=>{
                loadingOverlayEl.remove();
            }, 300);
        }, 1000);
    }
});