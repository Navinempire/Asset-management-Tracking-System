<?php

class DeleteHandler extends Database {
    public function delete($assetId) {
        $conn = $this->connection();
        $stmt = $conn->prepare("DELETE FROM asset WHERE asset_id = ?");
        $stmt->execute([$assetId]);

        if ($stmt) {
            echo "<script>alert('Asset deleted successfully.'); window.location.href='index1.php';</script>";
        } else {
            echo "<script>alert('Failed to delete asset.'); window.history.back();</script>";
        }
    }
}
