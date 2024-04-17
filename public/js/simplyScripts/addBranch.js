const WORK_PAGE_NEW_BRANCH = ".work-page__new-branch"
const WORK_PAGE_ADD_BRANCH = ".work-page__add-branch"
const new_branch = document.querySelector(WORK_PAGE_NEW_BRANCH);
const add_branch = document.querySelector(WORK_PAGE_ADD_BRANCH);

const LABEL_BRANCH_CITY = ".label__branch-city"
const LABEL_BRANCH_NAME = ".label__branch-name"
const LABEL_BRANCH_WORKERS_COUNT = ".label__branch-workers-count"
const LABEL_BRANCH_ADDRESS= ".label__branch-address"
const DISPLAY_NONE = "none";
const DISPLAY_FLEX = "flex";
const city = document.querySelector(LABEL_BRANCH_CITY);
const name = document.querySelector(LABEL_BRANCH_NAME);
const workers_count = document.getElementById(LABEL_BRANCH_WORKERS_COUNT);
const address = document.querySelector(LABEL_BRANCH_ADDRESS);

function newBranchForm(display1="none", display2="flex")
{

    new_branch.style.display = display1;
    add_branch.style.display = display2;
}

function addBranchForm()
{
    if (city.value.trim() === "" || name.value.trim() === "" || workers_count.value.trim() === "" || address.value.trim() === "") {
        alert("One or more fields are empty");
        return;
    }

    setTimeout(function () {
        newBranchForm(DISPLAY_FLEX, DISPLAY_NONE);
    }, 300);

    city.value = "";
    name.value = "";
    workers_count.value = "";
    address.value = "";

    console.log(workers_count);
}
