function requestWorkerInformation(id, name, lastName, middleName, position) {
    var xhr = new XMLHttpRequest();

    xhr.open('POST', 'branch.php?id=' + id, false);

    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    const params =
        'id=' + encodeURIComponent(id) +
        '&name=' + encodeURIComponent(name) +
        '&lastName=' + encodeURIComponent(lastName) +
        '&middleName=' + encodeURIComponent(middleName) +
        '&position=' + encodeURIComponent(position);

    xhr.send(params);
    if (xhr.status != 200) {
        console.log( xhr.status + ': ' + xhr.statusText );
    } else
    {
        location.reload()
    }
}

export {
    requestWorkerInformation,
}
