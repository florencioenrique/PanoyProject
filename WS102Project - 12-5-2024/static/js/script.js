document.getElementById("toggleImageUpload").addEventListener("click", function (event) {
    event.preventDefault(); // Prevent default link behavior
    const imageUploadSection = document.getElementById("imageUploadSection");

    if (imageUploadSection.style.display === "none") {
        imageUploadSection.style.display = "block";
    } else {
        imageUploadSection.style.display = "none";
    }
});



