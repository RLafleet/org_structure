import {requestBranchInformation} from "../requests/requestNewBranch.js";

const WORK_PAGE_NEW_BRANCH = ".work-page__new-branch";
const WORK_PAGE_ADD_BRANCH = ".work-page__add-branch";
const ADD_BRANCH_BUTTON = ".add-branch__button";
const LABEL_BRANCH_CITY = ".label__branch-city";
const LABEL_BRANCH_WORKERS_COUNT = ".label__branch-workers-count";
const LABEL_BRANCH_ADDRESS = ".label__branch-address";
const DISPLAY_NONE = "none";
const DISPLAY_FLEX = "flex";

const newBranch = document.querySelector(WORK_PAGE_NEW_BRANCH);
const addBranch = document.querySelector(WORK_PAGE_ADD_BRANCH);

const newBranchButton = document.querySelector(WORK_PAGE_NEW_BRANCH);
const addBranchButton = document.querySelector(ADD_BRANCH_BUTTON);

const city = document.querySelector(LABEL_BRANCH_CITY);
const workersCount = document.querySelector(LABEL_BRANCH_WORKERS_COUNT);
const address = document.querySelector(LABEL_BRANCH_ADDRESS);

export function newBranchForm(display1 = "none", display2 = "flex") {
    newBranch.style.display = display1;
    addBranch.style.display = display2;
}

export function addBranchForm() {
    if (city.value.trim() === "" || address.value.trim() === "") {
        alert("One or more fields are empty");
        return;
    }

    requestBranchInformation(city.value, address.value);
    setTimeout(function () {
        newBranchForm(DISPLAY_FLEX, DISPLAY_NONE);
    }, 300);
}

document.addEventListener("DOMContentLoaded", function () {
    newBranchButton.addEventListener("click", function (event) {
        event.preventDefault();
        newBranchForm();
    });

    addBranchButton.addEventListener("click", function (event) {
        event.preventDefault();
        addBranchForm();
    });
});
