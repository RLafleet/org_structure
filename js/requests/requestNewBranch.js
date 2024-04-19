function requestBranchInformation(city, name, workersCount, address) {
    const params = new URLSearchParams({
        city: city,
        workersCount: workersCount,
        address: address
    });

    window.location.href = '/index.php?' + params.toString();
}

export {
    requestBranchInformation,
}
