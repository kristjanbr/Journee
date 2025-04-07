document.addEventListener("DOMContentLoaded", () => {
    img = document.getElementById('img');
    if (img.getAttribute('src')==='') {
        img.setAttribute('src', "https://live.staticflickr.com/750/32191464373_e8864ab8bd_b.jpg");
    }

});


function confirmDeletionPost(event) {
    var userConfirmed = confirm("Are you sure you want to delete this post?");
    if (!userConfirmed) {
        event.preventDefault();
    }
    return userConfirmed;
}
function confirmDeletionComment(event) {
    var userConfirmed = confirm("Are you sure you want to delete this comment?");
    if (!userConfirmed) {
        event.preventDefault();
    }
    return userConfirmed;
}