<?php
include('../../../src/auth-guard.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($conn)) {
        try {
            $groupId = $_POST['childrenGroupName'];
            $selectedChildren = $_POST['children'];

            // Перебираем выбранные группы и создаем связи
            $isSuccessful = true;
            foreach ($selectedChildren as $childId) {
                // Добавляем связи между группой и выбранными детьми
                $updateGroupQuery = "UPDATE Children SET group_id = :groupId WHERE child_id = :childId";
                $stmt = $conn->prepare($updateGroupQuery);
                $stmt->bindParam(':groupId', $groupId);
                $stmt->bindParam(':childId', $childId);
                $isSuccessful = $stmt->execute();
            }

            if ($isSuccessful) {
                // Перенаправляем обратно на страницу dashboard-admin.php
                header('Location: ../dashboard-admin.php');
                exit;
            }
        } catch (PDOException $e) {
            echo "Ошибка при выполнении запроса: " . $e->getMessage();
        }
    }
}
?>
