document.addEventListener("DOMContentLoaded", function () {
    // Display the overlay when the page starts loading
    document.getElementById("loadingOverlay").style.display = "flex";

    // Add an event listener to hide the overlay when all images are loaded
    window.addEventListener("load", function () {
        document.getElementById("loadingOverlay").style.display = "none";
    });
});
function openModal() {
    let v = document.querySelector('#videoBlock1').outerHTML; 
    document.querySelector('.modal-content').innerHTML = v;
    document.getElementById('myModal').style.display = 'block';
}

function closeModal() {
    document.getElementById('myModal').style.display = 'none';
}

function handleConfirmation(choice) {
    closeModal();
}
