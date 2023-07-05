<?php

namespace App\Http\Controllers;

use App\Models\BankBukuTabunganWadiah;
use App\Models\BankCIF;
use App\Models\BankLaporanPerjanjian;
use App\Models\SysBank;
use App\Models\SysUser;
use Illuminate\Http\Request;
use stdClass;

class LaporanTabungan extends Controller
{
    protected $pdf;

    public function __construct() {
        $this->pdf = new HeaderLaporan();
    }

    public function LaporanBuatTabunganWadiah(Request $re){

        try {
            $token              = $re->cookie('tkn');
            $tipe_id            = $re->tipe_id;
            $kode_id            = $re->kode_id;
            
            $ModelUser          = new SysUser();
            $data_user          = $ModelUser->getInformasiUser($token);
            
            if($data_user->status == true) {
                
                $list_data              = new stdClass;
                $list_data->tipe_id     = $tipe_id;
                $list_data->nomer_id    = $kode_id;
                $list_data->kd_bank     = $data_user->kd_bank;

                $ModelCIF           = new BankCIF();
                $data_cif           = $ModelCIF->cariInfoCIFByIdDanBank($list_data);

                if($data_cif->status == true ) {

                    $tahun_sekarang             = date('Y');
                    $bulan_sekarang             = date('m');
                    $hari_sekarang              = date('d');
    
                    $HitungLaporan              = new BankLaporanPerjanjian();
                    $nomor_laporan              = $HitungLaporan->hitungJumlahLaporan($data_user->kd_bank);
                    $total_laporan              = $nomor_laporan->count + 1;
    
                    $format_nomor_laporan       = $tahun_sekarang . '/' . 17001 . '/' . $bulan_sekarang . '/' . $hari_sekarang . '/' . $total_laporan;
    
                    $data_laporan                       = new stdClass;
    
                    $data_laporan->kd_laporan           = 17001;
                    $data_laporan->no_laporan           = $format_nomor_laporan;
                    $data_laporan->judul_laporan        = 'Buat Surat Perjanjian untuk pembuatan tabungan baru';
                    $data_laporan->deskripsi            = 'Buat Surat Perjanjian untuk pembuatan tabungan baru';
                    $data_laporan->kd_karyawan          = $data_user->user_id;
                    $data_laporan->kd_bank              = $data_user->kd_bank;
    
                    $RecordLaporanBaru                  = new BankLaporanPerjanjian();
                    $ProsesRecord                       = $RecordLaporanBaru->buatLaporanPerjanjian($data_laporan);
    
                    if($ProsesRecord->status == true) {
                        $data                   = new stdClass;
                        $data->kd_identitas     = $data_cif->kd_identitas;
                        $data->nama             = $data_cif->nama;
                        $data->alamat           = $data_cif->alamat;
                        $data->no_laporan       = $format_nomor_laporan;
                        
                        $CetakPDF   = new LaporanTabungan;
                        $CetakPDF->TampilkanPDFBuatTabungan($data);
                    } else {
                        die('Error terakhir');
                    }
                } else {
                    die('Data CIF tidak ditemukan');
                }
            } else {
                die('Data Pengguna tidak ditemukan');
            }

        } catch (\Exception $th) {
            die('Error throw: ' . $th->getMessage());
        }

    }

    function TampilkanPDFBuatTabungan($data) {

        $this->pdf->AliasNbPages();
        $this->pdf->AddPage();

        $this->pdf->Ln(10);
        $this->pdf->SetFont('Arial','B',15);
        $this->pdf->Cell(90,5,'Surat Perjanjian Pembuatan Buku Tabungan',0,1);
        $this->pdf->SetFont('Arial','', 12);
        $this->pdf->Cell(90,10, 'No : ' . $data->no_laporan,0,1);

        $this->pdf->Ln(15);

        $this->pdf->SetFont('Arial','',12);

        // Konten
        $this->pdf->Cell(90,5,'Yang bertanda tangan di bawah ini : ',0,1,'L');
        $this->pdf->Ln(5);
        $this->pdf->SetFont('Arial', '',12);

        $this->pdf->Cell(40,10,'Nama',0,0,'L');
        $this->pdf->Cell(10,10,':',0,0,'C');
        $this->pdf->Cell(20,10, $data->nama ,0,1,'L');
        // $pdf->Ln(5);

        $this->pdf->Cell(40,10,'Alamat',0,0,'L');
        $this->pdf->Cell(10,10,':',0,0,'C');
        $this->pdf->MultiCell(140,10, $data->alamat,0,1);

        $this->pdf->Cell(40,10,'No. Identitas',0,0,'L');
        $this->pdf->Cell(10,10,':',0,0,'C');
        $this->pdf->Cell(50,10, $data->kd_identitas ,0,1,'L');
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
        $this->pdf->Cell(90,10, $data->nama,0,0,'C');
        $this->pdf->Output();

        exit;
    }
}
