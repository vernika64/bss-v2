<?php

namespace App\Http\Controllers;

use Fpdf\Fpdf;

class HeaderLaporan extends Fpdf {
    
    public function Header() {
        $this->SetFont('Arial','B',15);
        
        // Move to the right
        $this->Cell(160);
        
        // Title
        $this->Cell(30,10,'S.P',1,0,'C');
        
        // Line break
        $this->Ln(15);
    
        $this->SetFont('Arial', 'B', 24);
        $this->Cell(60,0, 'Bank Amanah Sejahtera',0,1);
        $this->SetFont('Arial','I',12);
        $this->Cell(60,10, 'Jl. Selamat Jalan',0,1);

        $this->Ln(10);
        $this->SetFont('Arial','B',15);
        $this->Cell(90,5,'Surat Perjanjian Pembuatan Buku Tabungan',0,1);
        $this->SetFont('Arial','', 12);
        $this->Cell(90,10,'No : 12/31/S.P.N/TAB.WDA/2023',0,1);

        $this->Ln(15);
    }

    public function Footer() {
        $this->SetY(-15);

        $this->SetFont('Arial', 'I', 8);

        $this->Cell(0,10, 'Page ' . $this->PageNo() . '/{nb}' ,0,0,'C');
    }
}