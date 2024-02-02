<?php

namespace App\DTOs\PostCommentReports;

use App\Enums\ReportsType;

class PaginatePostCommentReportsDTO {
    public ?ReportsType $reportsType;

    public function __construct(
        public int $page = 1,
        public int $perPage = 10,
        ?string $reportsType = null
    ) {
        $this->setReportsType($reportsType);
    }

    private function setReportsType(?string $reportsType) {
        switch ($reportsType) {
            case 'REJECTED':
                $this->reportsType = ReportsType::REJECTED;
                break;
            case 'APPROVED':
                $this->reportsType = ReportsType::APPROVED;
                break;
            case 'OPEN':
                $this->reportsType = ReportsType::OPEN;
                break;
            default:
                $this->reportsType = null;
                break;
        }
    }
}
