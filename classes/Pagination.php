<?php

class Pagination {
    // You can add pagination helpers here if needed
    public function generateLinks($currentPage, $totalPages, $search = '') {
        $links = '';
        for ($i = 1; $i <= $totalPages; $i++) {
            $active = ($i == $currentPage) ? 'btn-dark' : 'btn-secondary';
            $links .= "<a class='btn btn-sm $active' style='margin:2px' href='?page=$i&search=" . urlencode($search) . "'>$i</a>";
        }
        return $links;
    }
}
