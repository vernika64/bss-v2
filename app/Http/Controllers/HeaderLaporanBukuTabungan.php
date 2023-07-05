<?php

namespace App\Http\Controllers;

use App\Models\SysBank;
use App\Models\SysUser;
use Fpdf\Fpdf;
use Illuminate\Http\Request;

class HeaderLaporanBukuTabungan extends Fpdf
{
    public function Header() {

        $ModelUser      = new SysUser();
        $data_user      = $ModelUser->getInformasiUser($_COOKIE['tkn']);

        $kd_bank        = $data_user->kd_bank;

        $ModelBank      = new SysBank();
        $data_bank      = $ModelBank->cariDataBankById($kd_bank);

        $this->SetFont('Arial','B',15);
        
        // Move to the right
        $this->Cell(160);
        
        // Title
        $this->Cell(30,10,'D.R',1,0,'C');
        
        // Line break
        $this->Ln(15);
    
        $this->SetFont('Arial', 'B', 24);
        // $this->Cell(60,0, $data_bank->nama_bank,0,1);
        $this->Cell(60,0, $data_bank->nama_bank,0,1);
        $this->SetFont('Arial','I',12);
        $this->Cell(60,10, $data_bank->alamat_bank,0,1);
        // $this->Cell(60,10, 'Jl. Selamat',0,1);

    }

    public function Footer() {
        $this->SetY(-15);

        $this->SetFont('Arial', 'I', 8);

        $this->Cell(0,10, 'Page ' . $this->PageNo() . '/{nb}' ,0,0,'C');
    }
}
