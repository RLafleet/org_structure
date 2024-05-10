function requestUpdateWorkerChanges(params) {
    var xhr = new XMLHttpRequest();

    xhr.open('POST', 'worker.php?id=' + params.workerId +"&branch_id=" + params.branchId, false);

    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    const newParams =
        'name=' + encodeURIComponent(params.name) +
        '&lastName=' + encodeURIComponent(params.lastName) +
        '&middleName=' + encodeURIComponent(params.middleName) +
        '&phoneNumber=' + encodeURIComponent(params.phoneNumber) +
        '&birthDate=' + encodeURIComponent(params.birthDate) +
        '&hiringDate=' + encodeURIComponent(params.hiringDate) +
        '&sex=' + encodeURIComponent(params.sex) +
        '&comment=' + encodeURIComponent(params.comment) +
        '&email=' + encodeURIComponent(params.email) +
        '&position=' + encodeURIComponent(params.position);

    xhr.send(newParams);
    if (xhr.status != 200) {
        console.log( xhr.status + ': ' + xhr.statusText );
    } else {
        location.reload();
    }
}

export { requestUpdateWorkerChanges };
