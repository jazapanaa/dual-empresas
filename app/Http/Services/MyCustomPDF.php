<?php

namespace App\Http\Services;
use App\Http\Traits\CompanyTrait;
use TCPDF;
class MyCustomPDF extends TCPDF
{
    use CompanyTrait;
    public string $footerText = 'MultiStore S.A.C - Todos los derechos reservados.';

    public function Header():void
    {
        $company = $this->getCompany(1);
        if ($company->logo ) {
            //&& file_exists($company->logo)
            $imagen = env('APP_URL').'/storage/'.$company->logo;
            $this->Image($imagen, 15, 8, 40); // x, y, width
        }

        $this->SetFont('helvetica', 'B', 12);

        $this->SetXY(58, 10);
        if($company->name!='null')
        $this->Cell(0, 10, $company->name, 0, 1, 'L');

        $this->Ln(5); // Espacio extra
    }

    public function Footer():void
    {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(0, 5, $this->footerText, 'T', 0, 'L');
        $this->Cell(0, 5, 'Página ' . $this->getAliasNumPage() . ' de ' . $this->getAliasNbPages(), 'T', 0, 'R');
    }
}
