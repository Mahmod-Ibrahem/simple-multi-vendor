<?php

namespace App\Exports;

use App\Models\Letter;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class LetterExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithEvents, WithStyles
{
    protected $query;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function collection()
    {
        return $this->query->get();
    }

    public function headings(): array
    {
        return [
            'المعرف',
            'رقم الكتاب',
            'تاريخ الكتاب',
            'الحالة',
            'التصنيف',
            'الموضوع',
            'التكليف',
            'الموظف المسؤول',
            'وارد/صادر',
            'تاريخ الوارد',
            'رقم الوارد',
            'مهلة الرد (أيام)',
            'رقم المذكرة',
            'تاريخ المذكرة',
            'محول إلى قسم',
            'رقم القضية/السنة',
            'حالة الإنجاز',
            'تاريخ الإضافة'
        ];
    }

    public function map($letter): array
    {
        $type = $letter->letter_status_id == 2 ? 'صادر' : 'وارد';

        return [
            $letter->id,
            $letter->letter_number,
            $letter->date ? $letter->date->format('Y-m-d') : '',
            $letter->letterStatus ? $letter->letterStatus->title : '',
            $letter->category ? $letter->category->title : '',
            $letter->subject ? $letter->subject->title : '',
            $letter->assignment ? $letter->assignment->title : '',
            $letter->employee ? $letter->employee->name : '',
            $type,
            $letter->on_going_date ? $letter->on_going_date->format('Y-m-d') : '',
            $letter->on_going_number,
            $letter->reply_deadline_days,
            $letter->memo_number,
            $letter->memo_date ? $letter->memo_date->format('Y-m-d') : '',
            $letter->forwarded_to_department,
            $letter->case_no_year,
            $letter->progress_status,
            $letter->created_at ? $letter->created_at->format('Y-m-d H:i') : '',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                    'size' => 12,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4F46E5'], // Indigo-600
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $sheet->setRightToLeft(true);
                $sheet->freezePane('A2'); // Freeze header row

                // Set row height for header
                $sheet->getRowDimension(1)->setRowHeight(25);

                // Add borders
                $highestColumn = $sheet->getHighestColumn();
                $highestRow = $sheet->getHighestRow();
                $sheet->getStyle("A1:{$highestColumn}{$highestRow}")
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN);

                // Center align all cells
                $sheet->getStyle("A1:{$highestColumn}{$highestRow}")
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                    ->setVertical(Alignment::VERTICAL_CENTER);
            },
        ];
    }
}
