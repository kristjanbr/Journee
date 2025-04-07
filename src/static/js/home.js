document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll('.container .container-journey').forEach(journey => {
        journey.querySelectorAll('a img').forEach(img => {
            if (img.getAttribute('src')==='') {
                img.setAttribute('src', "https://live.staticflickr.com/750/32191464373_e8864ab8bd_b.jpg");
            }
        });
      });
});