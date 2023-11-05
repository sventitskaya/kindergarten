<?php
include '../../../src/auth-guard.php';

if (isset($conn)) {
    $selectGroupsAndChildrenQuery = "SELECT cg.group_name, COUNT(c.child_id) as child_count
                          FROM ChildrenGroups cg LEFT JOIN Children c on cg.group_id = c.group_id
                          GROUP BY cg.group_name";
    $stmt = $conn->prepare($selectGroupsAndChildrenQuery);
    $stmt->execute();
    $groupsChildren = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $chartData = [];

    if (count($groupsChildren) > 0) {
        foreach ($groupsChildren as $pair) {
            $groupName = $pair['group_name'];
            $childCount = $pair['child_count'];
            $data[$groupName] = $childCount;
        }
    }

    header('Content-Type: application/json');
    echo json_encode($data);
}
?>