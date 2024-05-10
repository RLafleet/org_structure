import {requestUpdateWorkerChanges} from "../requests/requestUpdateWorkerChanges.js";

const WORKER_ID = "worker";
const BRANCH_ID = "branch"
const NAME_INPUT_ID = "name";
const MIDDLE_NAME_INPUT_ID = "middleName";
const LAST_NAME_INPUT_ID = "lastName";
const PHONE_NUMBER_INPUT_ID = "phoneNumber";
const EMAIL_INPUT_ID = "email";
const SEX_SELECT_ID = "sex-select";
const BIRTH_DATE_INPUT_ID = "birthDate";
const HIRING_DATE_INPUT_ID = "hiringDate";
const POSITION_INPUT_ID = "position";
const COMMENT_INPUT_ID = "comment";
const SAVE_BUTTON_ID = "save";

const worker = document.getElementById(WORKER_ID);
const branch = document.getElementById(BRANCH_ID);

const saveChangesButton = document.getElementById(SAVE_BUTTON_ID);
saveChangesButton.addEventListener('click', function(event) {
    const nameInput = document.getElementById(NAME_INPUT_ID);
    const middleNameInput = document.getElementById(MIDDLE_NAME_INPUT_ID);
    const lastNameInput = document.getElementById(LAST_NAME_INPUT_ID);
    const phoneNumberInput = document.getElementById(PHONE_NUMBER_INPUT_ID);
    const emailInput = document.getElementById(EMAIL_INPUT_ID);
    const sexSelect = document.getElementById(SEX_SELECT_ID);
    const birthDateInput = document.getElementById(BIRTH_DATE_INPUT_ID);
    const hiringDateInput = document.getElementById(HIRING_DATE_INPUT_ID);
    const positionInput = document.getElementById(POSITION_INPUT_ID);
    const commentInput = document.getElementById(COMMENT_INPUT_ID);

    const params = {
        workerId: worker.dataset.value,
        branchId: branch.dataset.value,
        name: nameInput.value,
        middleName: middleNameInput.value,
        lastName: lastNameInput.value,
        phoneNumber: phoneNumberInput.value,
        email: emailInput.value,
        sex: sexSelect.value,
        birthDate: birthDateInput.value,
        hiringDate: hiringDateInput.value,
        position: positionInput.value,
        comment: commentInput.value
    };

    requestUpdateWorkerChanges(params);
});