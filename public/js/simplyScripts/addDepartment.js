// addDepartment.js
document.querySelector('.add-department__button').addEventListener('click', () => {
    const branchId = new URLSearchParams(window.location.search).get('id');
    const departmentName = document.querySelector('.label__department-name').value;

    if (!departmentName) {
        alert('Please enter a department name');
        return;
    }

    fetch('../../addDepartment.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `branch_id=${branchId}&department_name=${encodeURIComponent(departmentName)}`,
    })
        .then(response => {
            if (response.ok) {
                window.location.reload();
            } else {
                alert('Failed to add department');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
});