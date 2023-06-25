<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaporanTabungan extends Controller
{
    protected $pdf;

    public function __construct() {
        $this->pdf = new HeaderLaporan();
    }

    public function LaporanBuatTabunganWadiah(){

        $this->pdf->AliasNbPages();
        $this->pdf->AddPage();
        $this->pdf->SetFont('Arial','',12);

        // Konten
        $this->pdf->Cell(90,5,'Yang bertanda tangan di bawah ini : ',0,1,'L');
        $this->pdf->Ln(5);
        $this->pdf->SetFont('Arial', '',12);

        $this->pdf->Cell(40,10,'Nama',0,0,'L');
        $this->pdf->Cell(10,10,':',0,0,'C');
        $this->pdf->Cell(20,10,'Nanda',0,1,'L');
        // $pdf->Ln(5);

        $this->pdf->Cell(40,10,'Alamat',0,0,'L');
        $this->pdf->Cell(10,10,':',0,0,'C');
        $this->pdf->MultiCell(140,10,'Jl. Simpang Janawa 12 No. 1 Kec. Santuy Kelurahan Manggis Kota Malang Jawa Timur',0,1);

        $this->pdf->Cell(40,10,'No. Identitas',0,0,'L');
        $this->pdf->Cell(10,10,':',0,0,'C');
        $this->pdf->Cell(50,10,'37788709877626',0,1,'L');
        $this->pdf->Ln(10);

        $isi_surat = 'Bersedia untuk membuat produk tabungan syariah di Bank Amana Sejahtera dengan syarat dan ketentuan yang terikat pada surat perjanjian ini. Segala bentuk pelanggaran yang dilakukan oleh nasabah atau bank harus ditegakkan sesuai dengan hukum yang mencakup kegiatan perbankan syariah.';

        $this->pdf->MultiCell(190,10, $isi_surat,0,'FJ');


        $this->pdf->Cell(180,10,'Malang, 24 Juni 2023',0,1,'R');
        $this->pdf->Ln(10);
        $this->pdf->Cell(90,10,'Manajer Tabungan',0,0,'C');
        $this->pdf->Cell(90,10,'Pihak Pertama',0,1,'C');
        $this->pdf->Cell(0,10,'',0,1);
        $this->pdf->Cell(90,20,'',0,0);
        $this->pdf->Cell(20,20,'',0,0);
        $this->pdf->Cell(30,20,'Materai',1,1,'C');
        $this->pdf->Cell(0,10,'',0,1);
        $this->pdf->Cell(90,10,'Anton',0,0,'C');
        $this->pdf->Cell(90,10,'Nanda',0,0,'C');
        $this->pdf->Output();

        exit;
    }
}
