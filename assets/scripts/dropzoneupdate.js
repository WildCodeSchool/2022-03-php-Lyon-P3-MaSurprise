import Dropzone from "dropzone";

var previewNode = document.querySelector("#template");
previewNode.id = "";
let previewTemplate = previewNode.parentNode.innerHTML;
previewNode.parentNode.removeChild(previewNode);

let dropzoneUpdate = new Dropzone("form#dropzoneUpdate", { 
    paramName: "files",
    uploadMultiple: true,
    autoProcessQueue: false,
    parallelUploads: 100,
    createImageThumbnails: true,
    thumbnailMethod: "contain",
    maxFiles: 5,
    previewsContainer: "#previews",
    previewTemplate: previewTemplate,
    url: "/gateau/updated-files",
});

let deleteBtns = document.getElementsByClassName('deleteBtns');
let deleteBtn = document.getElementById('deleteBtn');
let path = deleteBtn.value;
let deleteUrl = 'gateau/' + id + path + '/delete-files';
let pictureDivs = document.getElementsByClassName('picture-div');

for (let i = 0; i < deleteBtns.length; i++) {
    deleteBtns[i].addEventListener("click", function(e) {
        e.preventDefault();
        fetch(deleteUrl)
            .then(function() {
                for (const pictureDiv of pictureDivs) {
                    if (path == pictureDiv.id) {
                        pictureDiv.remove();
                    }
                }
            })
    });
}

let updateForm = document.getElementById('dropzoneUpdate');
let id = document.getElementById('cakeId').innerHTML;

dropzoneUpdate.element.querySelector('#updateButton').addEventListener("click", function(e) {
    e.preventDefault();
    const form = new FormData(updateForm);
    fetch('/gateau/' + id + '/modifier', {
        method: 'POST',
        body: form,
    })
        .then(function() {
            dropzoneUpdate.processQueue();
        })
        .then(function() {
            dropzoneUpdate.on("sendingmultiple", function() {
            });
        })
        .then(function() {
            dropzoneUpdate.on("successmultiple", function() {  
            });
        })
        .then(function() {
            alert('Bravo, votre gâteau a bien été mis à jour !')
        })
        .then(function() {
            window.location.href = '/gateau/' + id + '/modifier';
        });
});