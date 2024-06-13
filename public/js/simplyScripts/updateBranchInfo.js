import {requestUpdateBranchChanges} from "../requests/requestUpdateBranchChanges.js";

const CITY = "#city-input";
const ADDRESS = "#address-input";
const WORKERS_COUNT = "#workers-count-input";
const city = document.querySelector(CITY);
const workersCount = document.querySelector(WORKERS_COUNT);
const address = document.querySelector(ADDRESS);
const UPDATE_BRANCH_BUTTON = ".update-branch";
const updateBranchButton = document.querySelector(UPDATE_BRANCH_BUTTON)
const branch = document.querySelector('.content__branches-list');
export function updateBranchForm() {
    if (city.value.trim() === ""
        || address.value.trim() === "") {
        alert("One or more fields are empty");
        return;
    }
    requestUpdateBranchChanges(branch.getAttribute('data-value'), city.value, address.value);
}
document.addEventListener("DOMContentLoaded", function () {
    updateBranchButton.addEventListener("click", function (event) {
        event.preventDefault();
        updateBranchForm();
    });
});