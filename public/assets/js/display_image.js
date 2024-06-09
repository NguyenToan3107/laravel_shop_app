const fileInput = document.getElementById('image');
fileInput.addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
        const imageURL = URL.createObjectURL(file);
        const imageDisplay = document.getElementById('imageDisplay');
        imageDisplay.src = imageURL;
    }
});
