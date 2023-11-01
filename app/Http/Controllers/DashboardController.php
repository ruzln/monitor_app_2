<?php

namespace App\Http\Controllers;

use App\Models\dasboarModel;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
  public function index(){
    $tahun  = Carbon::now()->format('Y');
    $tahunSelainAktif = [];
    $result = [];
    $resultNonAktif = [];
    $totalKeseluruhan = 0;
    $totalKeseluruhanNonAktif = 0;
    $dataAktif = [];
    $datanonAktif = [];

    // Menghitung total penerimaan untuk tahun aktif
    for ($bulan = 1; $bulan <= 12; $bulan++) {
        $dataBulan = dasboarModel::selectRaw('SUM(pembayaran_sppt.jml_sppt_yg_dibayar) as total_bayar')
            ->whereRaw("EXTRACT(MONTH FROM pembayaran_sppt.tgl_pembayaran_sppt) = $bulan")
            ->whereRaw("EXTRACT(YEAR FROM pembayaran_sppt.tgl_pembayaran_sppt) = $tahun")
            ->where('pembayaran_sppt.thn_pajak_sppt', $tahun)
            ->first();

        $totalBulan = $dataBulan->total_bayar ?? 0;
        $result[] = $totalBulan;
        $totalKeseluruhan += $totalBulan;
        $dataAktif[] = $totalBulan;
    }

    // Menghitung total penerimaan untuk tahun selain aktif
    for ($bulan = 1; $bulan <= 12; $bulan++) {
        $dataBulanNonAktif = dasboarModel::selectRaw('SUM(pembayaran_sppt.jml_sppt_yg_dibayar)-SUM(pembayaran_sppt.denda_sppt) as total_bayar')
          ->whereRaw("EXTRACT(MONTH FROM pembayaran_sppt.tgl_pembayaran_sppt) = $bulan")
          ->whereRaw("EXTRACT(YEAR FROM pembayaran_sppt.tgl_pembayaran_sppt) = $tahun")
          ->where('pembayaran_sppt.thn_pajak_sppt','!=', $tahun)
          ->first();

      $totalBulanNonAktif = $dataBulanNonAktif->total_bayar ?? 0;
      $resultNonAktif[] = $totalBulanNonAktif;
      $totalKeseluruhanNonAktif += $totalBulanNonAktif;
      $datanonAktif[] = $totalBulanNonAktif;
      
    }

    // Query untuk card
      $selectRawCard = '
          SUM(sppt.pbb_yg_harus_dibayar_sppt) as target,
          COUNT(sppt.pbb_yg_harus_dibayar_sppt) as jumlah_sppt,
          SUM(pembayaran_sppt.jml_sppt_yg_dibayar) as realisasi_total,
          SUM(pembayaran_sppt.jml_sppt_yg_dibayar) - SUM(pembayaran_sppt.denda_sppt) as realisasi_pokok,
          (SUM(pembayaran_sppt.jml_sppt_yg_dibayar) - SUM(pembayaran_sppt.denda_sppt)) / NULLIF(SUM(sppt.pbb_yg_harus_dibayar_sppt), 0) * 100 as persen
      ';
  
      $resultCard = DB::table('sppt')
          ->leftJoin('pembayaran_sppt', function ($join) {
              $join ->on('sppt.kd_kecamatan', '=', 'pembayaran_sppt.kd_kecamatan')
                    ->on('sppt.kd_kelurahan', '=', 'pembayaran_sppt.kd_kelurahan')
                    ->on('sppt.kd_blok', '=', 'pembayaran_sppt.kd_blok')
                    ->on('sppt.no_urut', '=', 'pembayaran_sppt.no_urut')
                    ->on('sppt.kd_jns_op', '=', 'pembayaran_sppt.kd_jns_op')
                    ->on('sppt.thn_pajak_sppt', '=', 'pembayaran_sppt.thn_pajak_sppt');
          })
          ->selectRaw($selectRawCard)
          ->where('sppt.thn_pajak_sppt', $tahun)
          ->get();
  
      return view('home', [
          "title" => "Dashboard",
          'result' => $result,
          'resultNonAktif' => $resultNonAktif,
          'totalKeseluruhan' => $totalKeseluruhan,
          'totalKeseluruhanNonAktif' => $totalKeseluruhanNonAktif,
          'tahun' => $tahun,
          'tahunSelainAktif' => $tahunSelainAktif,
          'resultCard' => $resultCard,
          'dataAktif' => $dataAktif,
          'datanonAktif' => $datanonAktif,
      ]);
  }

}