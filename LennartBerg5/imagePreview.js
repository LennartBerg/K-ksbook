// https://stackoverflow.com/questions/4459379/preview-an-image-before-it-is-uploaded

let loadFile = function (event) {
    let output = document.getElementById('imagePreview');
    output.classList.remove("hidden");
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = function () {
        URL.revokeObjectURL(output.src) // free memory
    }
};