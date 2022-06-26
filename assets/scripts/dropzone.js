// The constructor of Dropzone accepts two arguments:
//
// 1. The selector for the HTML element that you want to add
//    Dropzone to, the second
// 2. An (optional) object with the configuration

import Dropzone from "dropzone";

var previewNode = document.querySelector("#template");
previewNode.id = "";
let previewTemplate = previewNode.parentNode.innerHTML;
previewNode.parentNode.removeChild(previewNode);

let myDropzone = new Dropzone("form#myDropzone", { 
    paramName: "files",
    uploadMultiple: true,
    autoProcessQueue: false,
    parallelUploads: 100,
    createImageThumbnails: true,
    thumbnailMethod: "contain",
    maxFiles: 5,
    previewsContainer: "#previews",
    previewTemplate: previewTemplate,
    url: "/cake/uploadedfiles",
});

let myForm = document.getElementById('myDropzone');

myDropzone.element.querySelector('#dropzoneButton').addEventListener("click", function(e) {
    e.preventDefault();
    const form = new FormData(myForm);
    fetch('/cake/new', {
        method: 'POST',
        body: form
    })
        .then(function() {
            myDropzone.processQueue();
        })
        .then(function() {
            myDropzone.on("sendingmultiple", function() {
            });
        })
        .then(function() {
            myDropzone.on("successmultiple", function() {
            });
        })
        .then(function() {
            window.location.reload();
        });
});