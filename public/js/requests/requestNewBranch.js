function requestBranchInformation(city, address) {
    var xhr = new XMLHttpRequest();

    xhr.open('POST', 'index.php', false);

    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    const params = 'city=' + encodeURIComponent(city) +
        '&workersCount=' +
        '&address=' + encodeURIComponent(address);

    console.log(params);

    xhr.send(params);
    if (xhr.status != 200) {
        console.log( xhr.status + ': ' + xhr.statusText );
    } else {
        location.reload();
    }
}

export { requestBranchInformation };
