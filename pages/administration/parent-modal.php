<div id="parentModal" class="modal">
    <div class="modal-content">
        <span class="close" id="closeParentModal">&times;</span>
        <h2 id="parentModalTitle"></h2>
        <form id="parentForm" method="post" action="">
            <div id="parentCredentials" hidden>
                <label for="parentUsername">Имя пользователя:</label>
                <input type="text" name="parentUsername" id="parentUsername">
                <br>

                <label for="parentPassword">Пароль:</label>
                <input type="password" name="parentPassword" id="parentPassword">
                <br>

                <label for="parentEmail">Адрес электронной почты:</label>
                <input type="email" name="parentEmail" id="parentEmail">
                <br>
            </div>

            <label for="parentLastName">Фамилия:</label>
            <input type="text" name="parentLastName" id="parentLastName" required>
            <br>

            <label for="parentFirstName">Имя:</label>
            <input type="text" name="parentFirstName" id="parentFirstName" required>
            <br>

            <label for="parentMiddleName">Отчество:</label>
            <input type="text" name="parentMiddleName" id="parentMiddleName" required>
            <br>

            <label for="parentAddress">Адрес:</label>
            <input type="text" name="parentAddress" id="parentAddress" required>
            <br>

            <label for="parentPhone">Номер телефона:</label>
            <input type="tel" name="parentPhone" id="parentPhone" required>
            <br>

            <input type="hidden" name="parentId" id="parentId">
            <input type="submit" value="Сохранить изменения">
        </form>
    </div>
</div>