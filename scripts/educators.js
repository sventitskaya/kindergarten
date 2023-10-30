// Найти все кнопки "Изменить" и добавить для каждой обработчик события на нажатие
const editEducators = document.querySelectorAll('.edit-educator');
// Открывает диалоговое окно при клике на кнопку "Изменить"
editEducators.forEach(button => {
    button.addEventListener('click', (event) => {
        const educatorId = event.target.getAttribute('data-educator-id');
        const educatorFirstName = event.target.getAttribute('data-educator-first-name');
        const educatorMiddleName = event.target.getAttribute('data-educator-middle-name');
        const educatorLastName = event.target.getAttribute('data-educator-last-name');
        const educatorAddress = event.target.getAttribute('data-educator-address');
        const educatorPhone = event.target.getAttribute('data-educator-phone');

        // Заполните поля формы в диалоговом окне
        document.getElementById('educatorId').value = educatorId;
        document.getElementById('educatorFirstName').value = educatorFirstName;
        document.getElementById('educatorMiddleName').value = educatorMiddleName;
        document.getElementById('educatorLastName').value = educatorLastName;
        document.getElementById('educatorAddress').value = educatorAddress;
        document.getElementById('educatorPhone').value = educatorPhone;

        // Открывает диалоговое окно
        document.getElementById('educatorModal').style.display = 'flex';
        document.getElementById('educatorModalTitle').innerHTML = 'Редактировать воспитателя';
        document.getElementById('educatorForm').action = 'services/process-edit-educator.php';
        document.getElementById('educatorCredentials').setAttribute('hidden', 'true');
        document.getElementById('educatorUsername').removeAttribute('required');
        document.getElementById('educatorPassword').removeAttribute('required');
        document.getElementById('educatorEmail').removeAttribute('required');
    });
});

document.getElementById('add-educator').addEventListener('click', () => {
    // Открывает диалоговое окно
    document.getElementById('educatorModal').style.display = 'flex';

    document.getElementById('educatorModalTitle').innerHTML = 'Добавить воспитателя';
    document.getElementById('educatorForm').action = 'services/process-add-educator.php';

    document.getElementById('educatorId').value = null;
    document.getElementById('educatorFirstName').value = null;
    document.getElementById('educatorMiddleName').value = null;
    document.getElementById('educatorLastName').value = null;
    document.getElementById('educatorAddress').value = null;
    document.getElementById('educatorPhone').value = null;
    document.getElementById('educatorCredentials').removeAttribute('hidden');
    document.getElementById('educatorUsername').setAttribute('required', 'true');
    document.getElementById('educatorPassword').setAttribute('required', 'true');
    document.getElementById('educatorEmail').setAttribute('required', 'true');
});

// Закрывает диалоговое окно при клике на крестик или вне диалогового окна
document.getElementById('closeEducatorModal').addEventListener('click', () => {
    document.getElementById('educatorModal').style.display = 'none';
});

window.addEventListener('click', (event) => {
    if (event.target === document.getElementById('educatorModal')) {
        document.getElementById('educatorModal').style.display = 'none';
    }
});