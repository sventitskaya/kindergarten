<div id="educatorModal" class="modal">
    <div class="modal-content">
        <span class="close" id="closeEducatorModal">&times;</span>
        <h2 id="educatorModalTitle"></h2>
        <form id="educatorForm" method="post" action="">
            <div id="educatorCredentials">
                <label for="educatorUsername">Имя пользователя:</label>
                <input type="text" name="educatorUsername" id="educatorUsername" required>
                <br>

                <label for="educatorPassword">Пароль:</label>
                <input type="password" name="educatorPassword" id="educatorPassword" required>
                <br>

                <label for="educatorEmail">Адрес электронной почты:</label>
                <input type="email" name="educatorEmail" id="educatorEmail" required>
                <br>
            </div>

            <label for="educatorLastName">Фамилия:</label>
            <input type="text" name="educatorLastName" id="educatorLastName" required>
            <br>

            <label for="educatorFirstName">Имя:</label>
            <input type="text" name="educatorFirstName" id="educatorFirstName" required>
            <br>

            <label for="educatorMiddleName">Отчество:</label>
            <input type="text" name="educatorMiddleName" id="educatorMiddleName" required>
            <br>

            <label for="educatorAddress">Адрес:</label>
            <input type="text" name="educatorAddress" id="educatorAddress" required>
            <br>

            <label for="educatorPhone">Номер телефона:</label>
            <input type="tel" name="educatorPhone" id="educatorPhone" required>
            <br>

            <input type="hidden" name="educatorId" id="educatorId">
            <input type="submit" value="Сохранить изменения">
        </form>
    </div>
</div>