<?php
function redirectByRole($role)
{
    switch ($role) {
        case 'Заведующая':
            header('Location: ../administration/dashboard-admin.php');
            exit;
        case 'Воспитатель':
        case 'Учитель':
            header('Location: ../education/dashboard-educator.php');
            exit;
        case 'Родитель':
            header('Location: ../parenting/dashboard-parent.php');
            exit;
    }
}