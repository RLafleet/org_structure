function requestUpdateBranchChanges(branchId, city, workersCount, address) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'updateBranch.php?id=' + branchId);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    const newParams =
        'city=' + encodeURIComponent(city) +
        '&address=' + encodeURIComponent(address) +
        '&workers_count=' + encodeURIComponent(workersCount);

    xhr.send(newParams);
    if (xhr.status != 200) {
        console.log( xhr.status + ': ' + xhr.statusText );
    } else {
        location.reload();
    }
}

export { requestUpdateBranchChanges };
