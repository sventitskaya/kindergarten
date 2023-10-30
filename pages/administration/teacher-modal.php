<div id="teacherModal" class="modal">
    <div class="modal-content">
        <span class="close" id="closeTeacherModal">&times;</span>
        <h2 id="teacherModalTitle"></h2>
        <form id="teacherForm" method="post" action="">
            <div id="teacherCredentials">
                <label for="teacherUsername">Имя пользователя:</label>
                <input type="text" name="teacherUsername" id="teacherUsername" required>
                <br>

                <label for="teacherPassword">Пароль:</label>
                <input type="password" name="teacherPassword" id="teacherPassword" required>
                <br>

                <label for="teacherEmail">Адрес электронной почты:</label>
                <input type="email" name="teacherEmail" id="teacherEmail" required>
                <br>
            </div>

            <label for="teacherLastName">Фамилия:</label>
            <input type="text" name="teacherLastName" id="teacherLastName" required>
            <br>

            <label for="teacherFirstName">Имя:</label>
            <input type="text" name="teacherFirstName" id="teacherFirstName" required>
            <br>

            <label for="teacherMiddleName">Отчество:</label>
            <input type="text" name="teacherMiddleName" id="teacherMiddleName" required>
            <br>

            <label for="teacherAddress">Адрес:</label>
            <input type="text" name="teacherAddress" id="teacherAddress" required>
            <br>

            <label for="teacherPhone">Номер телефона:</label>
            <input type="tel" name="teacherPhone" id="teacherPhone" required>
            <br>

            <input type="hidden" name="teacherId" id="teacherId">
            <input type="submit" value="Сохранить изменения">
        </form>
    </div>
</div>