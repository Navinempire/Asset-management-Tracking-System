<?php
require_once 'config/connection.php';

class AssetManager extends Database {
    public function getAssets($search = '', $page = 1, $limit = 8) {
        $conn = $this->connection();
        $offset = ($page - 1) * $limit;
        $sql = "
            SELECT * FROM asset
            INNER JOIN category ON asset.category_id = category.category_id
            INNER JOIN asset_type ON category.asset_type_id = asset_type.asset_type_id
        ";

        if (!empty($search)) {
            $search = htmlspecialchars($search);
            $sql .= " WHERE
                asset_name LIKE '%$search%' OR
                asset_type_name LIKE '%$search%' OR
                category_name LIKE '%$search%' OR
                serial_number LIKE '%$search%' OR
                status LIKE '%$search%' OR
                conditions LIKE '%$search%'";
        }

        $sql .= " LIMIT $limit OFFSET $offset";
        return $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countAssets($search = '') {
        $conn = $this->connection();
        $sql = "SELECT COUNT(*) AS total FROM asset";

        if (!empty($search)) {
            $search = htmlspecialchars($search);
            $sql .= " WHERE
                asset_name LIKE '%$search%' OR
                serial_number LIKE '%$search%'";
        }

        $result = $conn->query($sql)->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }
}
