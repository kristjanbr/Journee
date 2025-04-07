document.addEventListener("DOMContentLoaded", () => {
    let file
    const inputFields = document.querySelectorAll("input[type=text], textarea");
    inputFields.forEach(function (input) {
        input.addEventListener("input", function () {
            if (this.value.length > 0) {
                this.classList.add("text-present");
            } else {
                this.classList.remove("text-present");
            }
            if (document.getElementById("text-name").value.length > 0 && document.getElementById("text-desc").value.length > 0) {
                document.getElementById("upload").classList.add("upload-present")
            }
            else {
                document.getElementById("upload").classList.remove("upload-present")
            }
            if (document.getElementById("text-img").value.length > 0 && file){
                document.getElementById("text").textContent = "*THE UPLOADED IMAGE WILL BE USED";
            }
            else{
                document.getElementById("text").textContent = "";
            }
        });
    });


    document.getElementById('file-upload').addEventListener('change', function(event) {
        file = event.target.files[0];
        if (file) {
            let upload = document.getElementById('imageupload');
            upload.textContent = file.name;
            upload.classList.add("text-present");
            if (document.getElementById("text-img").value.length > 0)
                document.getElementById("text").textContent = "*THE UPLOADED IMAGE WILL BE USED";
        }
    });
});