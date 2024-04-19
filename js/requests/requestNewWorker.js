function requestWorkerInformation(id, name, lastName, middleName, position) {
    const params = new URLSearchParams({
        id,
        name,
        lastName,
        middleName,
        position
    });

    window.location.href = '/branch.php?' + params.toString();
}

export {
    requestWorkerInformation,
}
