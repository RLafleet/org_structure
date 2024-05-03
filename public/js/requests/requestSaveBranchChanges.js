function requestSaveBranchChanges(params) {
    var xhr = new XMLHttpRequest();

    xhr.open('POST', 'updateBranch.php?id=' + params.branchId);

    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    const newParams =
        'city=' + encodeURIComponent(params.city) +
        '&address=' + encodeURIComponent(params.address) +
        '&workers_count=' + encodeURIComponent(params.workers_count);

    xhr.send(newParams);
    if (xhr.status != 200) {
        console.log( xhr.status + ': ' + xhr.statusText );
    } else {
        location.reload();
    }
}

export { requestSaveWorkerChanges };
