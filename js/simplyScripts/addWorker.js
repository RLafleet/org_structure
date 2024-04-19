import {requestWorkerInformation} from "../requests/requestNewWorker.js";

const WORK_PAGE_NEW_WORKER = ".work-page__new-worker";
const WORK_PAGE_ADD_WORKER = ".work-page__add-worker";
const ADD_WORKER_BUTTON = ".add-worker__button";
const LABEL_WORKER_NAME = ".label__worker-name";
const LABEL_WORKER_LAST_NAME = ".label__worker-last-name";
const LABEL_WORKER_MIDDLE_NAME = ".label__worker-middle-name";
const LABEL_WORKER_position = ".label__worker-position";
const DISPLAY_NONE = "none";
const DISPLAY_FLEX = "flex";
let fullNameElement = document.querySelector('.worker-full-name');

const newWorker = document.querySelector(WORK_PAGE_NEW_WORKER);
const addWorker = document.querySelector(WORK_PAGE_ADD_WORKER);

const newWorkerButton = document.querySelector(WORK_PAGE_NEW_WORKER);
const addWorkerButton = document.querySelector(ADD_WORKER_BUTTON);

const name = document.querySelector(LABEL_WORKER_NAME);
const lastName = document.querySelector(LABEL_WORKER_LAST_NAME);
const middleName = document.querySelector(LABEL_WORKER_MIDDLE_NAME);
const position = document.querySelector(LABEL_WORKER_position);
const id = fullNameElement.getAttribute('data-value');

export function newWorkerForm(display1 = "none", display2 = "flex") {
    newWorker.style.display = display1;
    addWorker.style.display = display2;
}

export function addWorkerForm() {
    if (name.value.trim() === "" || lastName.value.trim() === "" ||
        middleName.value.trim() === "" || position.value.trim() === "") {
        alert("One or more fields are empty");
        return;
    }
    requestWorkerInformation(id, name.value, lastName.value, middleName.value, position.value);
    setTimeout(function () {
        newWorkerForm(DISPLAY_FLEX, DISPLAY_NONE);
    }, 300);

}

document.addEventListener("DOMContentLoaded", function () {
    newWorkerButton.addEventListener("click", function (event) {
        event.preventDefault();
        newWorkerForm();
    });

    addWorkerButton.addEventListener("click", function (event) {
        event.preventDefault();
        addWorkerForm();
    });
});
