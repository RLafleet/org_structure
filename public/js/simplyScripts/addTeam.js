// addTeam.js
document.querySelector('.add-team__button').addEventListener('click', (event) => {
    event.preventDefault(); // Предотвращаем отправку формы по умолчанию

    const form = document.querySelector('.add-team-section form');
    const formData = new FormData(form);

    fetch('../addDepartmentTeam.php', {
        method: 'POST',
        body: formData,
    })
        .then(response => {
            if (response.ok) {
                window.location.reload();
            } else {
                alert('Failed to add team');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
});