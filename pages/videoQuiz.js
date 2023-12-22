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
    videoElement.muted = false;
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
    let videoElement = document.querySelector('.videoModal');
    videoElement.muted = true;
    document.getElementById('myModal').style.display = 'none';
}

function saveAnswer(evt, videoBlockID) {
    evt.stopPropagation();
    document.querySelector('.answerYes').classList.add('disabled');
    document.querySelector('.modal-content').classList.add('yes');
    document.querySelector('span.loader.stop').classList.remove('stop');
    
    let scr =  document.querySelector('#myModal > div > video > source').src.replace("http://" + window.location.hostname,".");
    const requestBody = {
        fn : 'saveChoice',
        pathToVideo: scr
    };
    const options = {
        method : 'POST',
        Headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(requestBody)
    };
    let gg = fetch('http://localhost/?fn=saveChoice', options).then(data => {console.log(data)});
    setTimeout(() => {
        window.location.href = '/';
    }, 3000);

}

function handleConfirmation(choice) {
    closeModal();
}

function nothing(evt) {
    evt.stopPropagation();
}
