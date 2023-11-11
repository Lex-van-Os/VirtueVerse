<?php

namespace App\DTO;

class ExpectedCompletionEntryDTO
{
    public int $readPages;
    public int $readMinutes;
    public \DateTime $timeNextEntry;

}

class ExpectedCompletionDTO
{
    public int $totalPages;
    public array $entries;
    public \DateTime $trajectoryStartDate;

    public function __construct(int $totalPages, array $entries, \DateTime $trajectoryStartDate)
    {
        $this->totalPages = $totalPages;
        $this->entries = $entries;
        $this->trajectoryStartDate = $trajectoryStartDate;
    }
}