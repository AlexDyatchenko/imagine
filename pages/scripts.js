document.addEventListener("DOMContentLoaded", function () {
    // Display the overlay when the page starts loading
    document.getElementById("loadingOverlay").style.display = "flex";

    // Add an event listener to hide the overlay when all images are loaded
    window.addEventListener("load", function () {
        document.getElementById("loadingOverlay").style.display = "none";
    });
});

function openModal(videoBlockID) {
    let v = document.querySelector('#' + videoBlockID).innerHTML; 
    let videoElement = document.querySelector('.videoModal');
    videoElement.innerHTML = v;
    videoElement.load();

    let modalElement = document.querySelector('.answerYes');
    modalElement.addEventListener(
        "click",
        (evt) =>
          (saveAnswer(evt, 1)),
    )
    let modalContent = document.querySelector('.modal-content');
    modalContent.addEventListener(
        "click",
        (evt) =>
          (nothing(evt)),
    )
    

    document.getElementById('myModal').style.display = 'flex';
}

function closeModal() {
    document.getElementById('myModal').style.display = 'none';
}

function saveAnswer(evt, videoBlockID) {
    evt.stopPropagation();
    document.querySelector('.answerYes').classList.add('disabled');
    document.querySelector('.modal-content').classList.add('yes');
    document.querySelector('span.loader.stop').classList.remove('stop');
    
    let modalElement = document.querySelector('.modal');
    //var element = document.getElementById("your-element-id");
    //modalElement.replaceWith(modalElement.cloneNode(true));

    
    // modalElement.removeEventListener("click", closeModal);
    let modalContentElement = document.querySelector('.modal-content');
    //modalContentElement.replaceWith(modalContentElement.cloneNode(true));
    // modalContentElement.removeEventListener("click", closeModal);
    setTimeout(() => {
        window.location.href = '/';
    }, 5000);

}

function handleConfirmation(choice) {
    closeModal();
}

function nothing(evt) {
    evt.stopPropagation();
}
