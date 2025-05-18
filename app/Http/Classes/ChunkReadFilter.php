<?php

namespace App\Http\Classes;

use PhpOffice\PhpSpreadsheet\Reader\IReadFilter;

class ChunkReadFilter implements IReadFilter

{
    private int $startRow = 0;
    private int $endRow = 0;

    public function setRows(int $startRow, int $chunkSize): void
    {
        $this->startRow = $startRow;
        $this->endRow = $startRow + $chunkSize;
    }

    public function readCell(string $column, int $row, string $worksheetName = ''): bool
    {
        // قراءة صف الرأس دائمًا وكل الصفوف في الدفعة الحالية
        return ($row === 1) || ($row >= $this->startRow && $row < $this->endRow);
    }
}
