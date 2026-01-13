<?php

namespace App\Http\Traits;
use App\Http\Services\MyCustomPDF;
trait ReportsTrait
{
    protected MyCustomPDF $pdf;
    public function InitPdf(
        string $title = 'Reporte',
        bool $autoPageBreak = true,
        string $orientation = 'P' // 'P' = vertical, 'L' = horizontal
    ): MyCustomPDF {
        $this->pdf = new MyCustomPDF($orientation, 'mm', 'A4', true, 'UTF-8', false);

        $this->pdf->SetTitle($title);
        $this->pdf->SetMargins(10, 30, 10); // espacio superior para el header
        $this->pdf->SetAutoPageBreak($autoPageBreak, 20); // espacio inferior para el footer
        $this->pdf->AddPage();

        $this->pdf->reportTitle = $title;
        $this->pdf->logoPath = public_path('uploads/logo_report.png');
        $this->pdf->footerText = 'Generado por MultiStore - ' . now()->format('d/m/Y');

        return $this->pdf;
    }
    public function outputPdf($fileName='file',$modePrint='FI'):void
    {
        $this->pdf->Output(public_path('storage/reports/').$fileName.'.pdf',$modePrint);
    }
    public function reportTitle($title,$x=0,$y=35,$border = 0): void
    {
        $this->pdf->SetLineWidth(0.2);
        $this->pdf->SetXY($x,$y);
        $this->pdf->SetTextColor(255,0,0);
        $this->pdf->SetFont('helvetica','BI',12);
        $this->pdf->Cell(210,5,$title,$border,2,'C');
    }
    public function reportTableHeader(array $columns, float $x = 0, float $y = 35, bool $withIndex = false): void
    {
        $this->pdf->SetTextColor(0, 0, 0);
        $this->pdf->SetXY($x, $y);

        // Si se desea mostrar índice (correlativo)
        if ($withIndex) {
            $this->pdf->Cell(10, 5, '#', 1, 0, 'C'); // columna de índice fija de 10
        }

        foreach ($columns as $col) {
            $width = $col['width'] ?? 30;
            $label = $col['label'] ?? '';
            $align = $col['align'] ?? 'L';

            $this->pdf->Cell($width, 5, $label, 1, 0, $align);
        }

        #$this->pdf->Ln(); // Salto de línea
    }
    public function reportRenderData(
        $data,
        array $columns,
        float $x = 10,
        float $startY = 40,
        bool $withIndex = false,
        int $limit = 30 // cantidad de filas por página
    ): void {
        $y = 0;
        $rowHeight = 5;

        $this->pdf->SetFont('courier', '', 10);

        foreach ($data as $i => $item) {
            // Saltar página al alcanzar el límite de filas
            if ($y > 0 && $y % $limit === 0) {
                $this->pdf->AddPage();
                $this->reportTableHeader($columns, $x, $startY - 5, $withIndex);
                $y = 0; // reinicia para nueva página
            }

            $currentX = $x;
            $posY = $startY + ($y * $rowHeight);

            // Índice
            if ($withIndex) {
                $this->pdf->SetXY($currentX, $posY);
                $this->pdf->Cell(10, $rowHeight, (string)($i + 1), 1, 0, 'C');
                $currentX += 10;
            }

            // Columnas
            foreach ($columns as $col) {
                $key = $col['key'] ?? null;
                $width = $col['width'] ?? 30;
                $align = $col['align'] ?? 'L';
                $value = $key && isset($item->$key) ? $item->$key : '';

                $this->pdf->SetXY($currentX, $posY);
                $this->pdf->Cell($width, $rowHeight, $value, 1, 0, $align);
                $currentX += $width;
            }

            $y++;
        }
    }






}
