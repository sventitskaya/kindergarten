<div class="tab-panel" data-tab="teachers">
    <?php if (!empty($teachers)) : ?>
        <div class="group-tabs page-table-container">
            <table class="page-table">
                <thead>
                <tr>
                    <th>Имя</th>
                    <th>Адрес</th>
                    <th>Номер телефона</th>
                    <th>Адрес электронной почты</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($teachers as $teacher) : ?>
                    <tr>
                        <td><?php echo $teacher['full_name']; ?></td>
                        <td><?php echo $teacher['address']; ?></td>
                        <td><?php echo $teacher['contact_phone']; ?></td>
                        <td><?php echo $teacher['email']; ?></td>
                        <td>
                            <div class="button-row">
                                <button class="edit-teacher"
                                        data-teacher-id="<?php echo $teacher['user_id']; ?>"
                                        data-teacher-first-name="<?php echo $teacher['first_name']; ?>"
                                        data-teacher-middle-name="<?php echo $teacher['middle_name']; ?>"
                                        data-teacher-last-name="<?php echo $teacher['last_name']; ?>"
                                        data-teacher-address="<?php echo $teacher['address']; ?>"
                                        data-teacher-phone="<?php echo $teacher['contact_phone']; ?>">
                                    Изменить
                                </button>
                                <?php
                                    $deleteClass = 'delete-teacher';
                                    if (isset($conn)) {
                                        $getLessonsCountQuery = "SELECT COUNT(*) as lesson_count
                                                                FROM Lessons l
                                                                WHERE l.teacher_id = :teacherId";
                                        $stmt = $conn->prepare($getLessonsCountQuery);
                                        $stmt->bindParam(':teacherId', $teacher['user_id']);
                                        $stmt->execute();
                                        $resultLessons = $stmt->fetch(PDO::FETCH_ASSOC);

                                        if (isset($resultLessons) && $resultLessons['lesson_count'] > 0) {
                                            $deleteClass = 'confirm-delete-teacher';
                                        }
                                    }
                                ?>
                                <button class="<?php echo $deleteClass; ?>"
                                        data-teacher-id="<?php echo $teacher['user_id']; ?>">
                                    Уволить
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else : ?>
        <p>Нет учителей для отображения.</p>
    <?php endif; ?>
    <?php include 'teacher-modal.php'; ?>
    <?php include 'delete-teacher-modal.php'; ?>
    <a id="add-teacher">Добавить Учителя</a>
    <script src="../../scripts/teachers.js" type="text/javascript"></script>
</div>
