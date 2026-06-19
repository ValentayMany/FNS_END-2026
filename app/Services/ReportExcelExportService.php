<?php

namespace App\Services;

use App\Models\AdvanceRequest;
use App\Models\Transaction;
use App\Support\LaoText;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReportExcelExportService
{
    /** Resolved at runtime — see config/reports.php (opened in Excel on the viewer's OS). */
    private function laoFont(): string
    {
        return (string) config('reports.excel_lao_font', 'Lao Sangam MN');
    }

    private const HEADER_FILL = 'FF1E3A5F';

    private const HEADER_FONT = 'FFFFFFFF';

    private const EXPENSE_FONT = 'FF7F1D1D';

    /**
     * @param  array{
     *     incomeTransactions: Collection<int, Transaction>,
     *     expenseTransactions: Collection<int, Transaction>,
     *     requests: Collection<int, AdvanceRequest>,
     *     totalIncome: float|int,
     *     totalExpense: float|int
     * }  $data
     */
    public function build(array $data): Spreadsheet
    {
        $income = $data['incomeTransactions'];
        $expense = $data['expenseTransactions'];
        $requests = $data['requests'];
        $totalIncome = (float) $data['totalIncome'];
        $totalExpense = (float) $data['totalExpense'];

        $spreadsheet = new Spreadsheet;
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle(mb_substr('ລາຍງານ', 0, 31));

        $spreadsheet->getDefaultStyle()->getFont()->setName($this->laoFont())->setSize(11);
        // Lao script needs extra vertical space (descenders + tone marks) when wrap is on.
        $sheet->getDefaultRowDimension()->setRowHeight(24);

        $row = 1;

        // --- ລາຍຮັບ ---
        $row = $this->sectionTitle($sheet, $row, '=== ລາຍຮັບ ===', 6);
        $row = $this->tableHeaderRow($sheet, $row, ['ວັນທີ', 'ປະເພດ', 'ລາຍລະອຽດ', 'ພາກສ່ວນ', 'ວິທີຮັບເງິນ', 'ຈຳນວນ (ກີບ)'], 6);
        foreach ($income as $t) {
            $sheet->setCellValue([1, $row], $t->transaction_date?->format('d/m/Y'));
            $sheet->setCellValue([2, $row], $this->lao($t->category ?? '-'));
            $sheet->setCellValue([3, $row], $this->lao($t->description));
            $sheet->setCellValue([4, $row], $this->lao($t->department?->displayName()));
            
            $method = '—';
            if ($t->payment_method === 'cash') {
                $method = 'ເງິນສົດ';
            } elseif ($t->payment_method === 'transfer') {
                $method = 'ໂອນເຂົ້າ';
            }
            $sheet->setCellValue([5, $row], $this->lao($method));
            
            $this->setAmountCell($sheet, 6, $row, (float) $t->amount);
            $row++;
        }
        if ($income->isNotEmpty()) {
            $sheet->setCellValue([5, $row], $this->lao('ລວມລາຍຮັບ'));
            $sheet->getStyle([5, $row])->getFont()->setBold(true);
            $this->setAmountCell($sheet, 6, $row, (float) $income->sum('amount'));
            $sheet->getStyle([6, $row])->getFont()->setBold(true);
            $row++;
        }
        $row++;

        // --- ລາຍຈ່າຍທົ່ວໄປ ---
        $row = $this->sectionTitle($sheet, $row, '=== ລາຍຈ່າຍທົ່ວໄປ ===', 5);
        $row = $this->tableHeaderRow($sheet, $row, ['ວັນທີ', 'ປະເພດ', 'ລາຍລະອຽດ', 'ພາກສ່ວນ', 'ຈຳນວນ (ກີບ)'], 5);
        foreach ($expense as $t) {
            $sheet->setCellValue([1, $row], $t->transaction_date?->format('d/m/Y'));
            $sheet->setCellValue([2, $row], $this->lao($t->category ?? '-'));
            $sheet->setCellValue([3, $row], $this->lao($t->description));
            $sheet->setCellValue([4, $row], $this->lao($t->department?->displayName()));
            $this->setAmountCell($sheet, 5, $row, (float) $t->amount, true);
            $row++;
        }
        if ($expense->isNotEmpty()) {
            $sheet->setCellValue([4, $row], $this->lao('ລວມລາຍຈ່າຍທົ່ວໄປ'));
            $sheet->getStyle([4, $row])->getFont()->setBold(true);
            $this->setAmountCell($sheet, 5, $row, (float) $expense->sum('amount'), true);
            $sheet->getStyle([5, $row])->getFont()->setBold(true);
            $row++;
        }
        $row++;

        // --- ລາຍຈ່າຍເງິນສົດ ---
        $row = $this->sectionTitle($sheet, $row, '=== ລາຍຈ່າຍເງິນສົດ ===', 6);
        $row = $this->tableHeaderRow($sheet, $row, ['ວັນທີ', 'ຜູ້ຂໍ', 'ລາຍລະອຽດ', 'ພາກສ່ວນ', 'ຈຳນວນ (ກີບ)', 'ສະຖານະ'], 6);
        foreach ($requests as $r) {
            $sheet->setCellValue([1, $row], $r->paymentTransaction?->transaction_date?->format('d/m/Y'));
            $sheet->setCellValue([2, $row], $this->lao($r->requester?->full_name ?? $r->requester?->username));
            $sheet->setCellValue([3, $row], $this->lao($r->description));
            $sheet->setCellValue([4, $row], $this->lao($r->department?->displayName()));
            $this->setAmountCell($sheet, 5, $row, (float) $r->requested_amount, true);
            $sheet->setCellValue([6, $row], $this->lao($r->status === 'cleared' ? 'ສະສາງແລ້ວ' : 'ຈ່າຍແລ້ວ'));
            $row++;
        }
        if ($requests->isNotEmpty()) {
            $sheet->setCellValue([4, $row], $this->lao('ລວມລາຍຈ່າຍເງິນສົດ'));
            $sheet->getStyle([4, $row])->getFont()->setBold(true);
            $this->setAmountCell($sheet, 5, $row, (float) $requests->sum('requested_amount'), true);
            $sheet->getStyle([5, $row])->getFont()->setBold(true);
            $row++;
        }
        $row++;

        // --- ສະຫຼຸບ ---
        $row = $this->sectionTitle($sheet, $row, '=== ສະຫຼຸບ ===', 2);
        $sheet->setCellValue([1, $row], $this->lao('ລາຍຮັບລວມ'));
        $this->setAmountCell($sheet, 2, $row, $totalIncome);
        $sheet->getStyle('A'.$row.':B'.$row)->getFont()->setBold(true);
        $row++;
        $sheet->setCellValue([1, $row], $this->lao('ລາຍຈ່າຍລວມ'));
        $this->setAmountCell($sheet, 2, $row, $totalExpense, true);
        $sheet->getStyle('A'.$row.':B'.$row)->getFont()->setBold(true);
        $row++;
        $net = $totalIncome - $totalExpense;
        $sheet->setCellValue([1, $row], $this->lao('ຍອດຄົງເຫຼືອ'));
        $this->setAmountCell($sheet, 2, $row, $net, $net < 0);
        $sheet->getStyle('A'.$row.':B'.$row)->getFont()->setBold(true);
        $row++;

        $sheet->getColumnDimension('A')->setWidth(14);
        $sheet->getColumnDimension('B')->setWidth(22);
        $sheet->getColumnDimension('C')->setWidth(48);
        $sheet->getColumnDimension('D')->setWidth(18);
        $sheet->getColumnDimension('E')->setWidth(18);
        $sheet->getColumnDimension('F')->setWidth(16);

        $lastRow = $row - 1;
        $sheet->getStyle('A1:F'.$lastRow)->getFont()->setName($this->laoFont());
        $sheet->getStyle('A1:F'.$lastRow)->getAlignment()->setWrapText(true);
        $sheet->getStyle('A1:F'.$lastRow)->getAlignment()->setVertical(Alignment::VERTICAL_TOP);

        $this->applyLaoFriendlyRowHeights($sheet, $lastRow);

        return $spreadsheet;
    }

    /** NFC + ຽ/tone order fix so Excel does not show dotted-circle on ລ້ຽງ-style syllables. */
    private function lao(?string $value): string
    {
        return LaoText::normalize($value);
    }

    private function sectionTitle(Worksheet $sheet, int $row, string $title, int $lastCol): int
    {
        $sheet->setCellValue([1, $row], $this->lao($title));
        $endCol = Coordinate::stringFromColumnIndex($lastCol);
        $sheet->mergeCells('A'.$row.':'.$endCol.$row);
        $sheet->getStyle([1, $row])->getFont()->setName($this->laoFont())->setBold(true)->setSize(12);
        $sheet->getStyle([1, $row])->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

        return $row + 1;
    }

    /**
     * @param  list<string>  $headers
     */
    private function tableHeaderRow(Worksheet $sheet, int $row, array $headers, int $count): int
    {
        for ($c = 1; $c <= $count; $c++) {
            $sheet->setCellValue([$c, $row], $this->lao($headers[$c - 1] ?? ''));
        }
        $lastCol = $count;
        $range = 'A'.$row.':'.Coordinate::stringFromColumnIndex($lastCol).$row;
        $sheet->getStyle($range)->getFont()->setName($this->laoFont())->setBold(true)->getColor()->setARGB(self::HEADER_FONT);
        $sheet->getStyle($range)->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB(self::HEADER_FILL);
        $sheet->getStyle($range)->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_LEFT)
            ->setVertical(Alignment::VERTICAL_CENTER);

        return $row + 1;
    }

    private function setAmountCell(Worksheet $sheet, int $col, int $row, float $value, bool $expenseStyle = false): void
    {
        $sheet->setCellValue([$col, $row], $value);
        $sheet->getStyle([$col, $row])->getNumberFormat()->setFormatCode('#,##0.00');
        if ($expenseStyle) {
            $sheet->getStyle([$col, $row])->getFont()->getColor()->setARGB(self::EXPENSE_FONT);
        }
    }

    /**
     * Excel does not auto-size row height in the file; long Lao text + wrap was clipping descenders.
     */
    private function applyLaoFriendlyRowHeights(Worksheet $sheet, int $lastRow): void
    {
        $charsPerLine = 36;
        $base = 24.0;
        $perExtraLine = 15.0;
        $max = 132.0;

        for ($r = 1; $r <= $lastRow; $r++) {
            $b = $sheet->getCell([2, $r])->getValue();
            $c = $sheet->getCell([3, $r])->getValue();
            $bStr = is_string($b) ? $b : '';
            $cStr = is_string($c) ? $c : '';
            $chars = max(mb_strlen($bStr), mb_strlen($cStr));
            if ($chars === 0) {
                continue;
            }
            $linesFromBreaks = max(
                $bStr === '' ? 1 : substr_count($bStr, "\n") + 1,
                $cStr === '' ? 1 : substr_count($cStr, "\n") + 1,
            );
            $lines = max($linesFromBreaks, (int) ceil($chars / $charsPerLine));
            $height = min($max, $base + ($lines - 1) * $perExtraLine);
            $sheet->getRowDimension($r)->setRowHeight($height);
        }
    }
}
