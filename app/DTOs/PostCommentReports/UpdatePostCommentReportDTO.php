<?php

namespace App\DTOs\PostCommentReports;

use App\Enums\ReportsType;
use App\Models\PostCommentReport;

class UpdatePostCommentReportDTO {
    public ReportsType $reportsType;

    public function __construct(
        string $reportsType,
        public int $reportId
    ) {
        switch ($reportsType) {
            case 'APPROVED':
                $this->reportsType = ReportsType::APPROVED;
                break;
            case 'REJECTED':
                $this->reportsType = ReportsType::REJECTED;
                break;
            default:
                $this->reportsType = ReportsType::OPEN;
                break;
        }
    }
}
