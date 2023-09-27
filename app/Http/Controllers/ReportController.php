<?php

namespace App\Http\Controllers;


use App\Models\RefKecamatan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
   // Function Index
    public function index() {

        $kec        = RefKecamatan::all(); 
        return view('content.report',compact('kec'),["title" => "Report"]);
    }
   // Function Realisasi
    public function Filter_realisasi (Request $request){
     
        $kec        = RefKecamatan::all();
        $tahun_akhir= (request()->tahun_akhir);
        $tahun_awal = (request()->tahun_awal);
        $kecamatan  = (request()->kecamatan);
        $start_date = Carbon::parse(request()->start_date)->format('Y-m-d');
        $end_date   = Carbon::parse(request()->end_date)->format('Y-m-d');

    // Query untuk mengambil data realisasi pajak PBB
        $cek = DB::table('sppt')                
        ->leftJoin('pembayaran_sppt', [   
            ['sppt.kd_propinsi',    '=', 'pembayaran_sppt.kd_propinsi'],
            ['sppt.kd_dati2',    '=', 'pembayaran_sppt.kd_dati2'],
            ['sppt.kd_kecamatan',   '=', 'pembayaran_sppt.kd_kecamatan'],
            ['sppt.kd_kelurahan',   '=', 'pembayaran_sppt.kd_kelurahan'],
            ['sppt.kd_blok',        '=', 'pembayaran_sppt.kd_blok'],
            ['sppt.no_urut',        '=', 'pembayaran_sppt.no_urut'],
            ['sppt.kd_jns_op',      '=', 'pembayaran_sppt.kd_jns_op'],
            ['sppt.thn_pajak_sppt', '=', 'pembayaran_sppt.thn_pajak_sppt']
        ])
        ->leftJoin('dat_objek_pajak', [
   
            ['sppt.kd_propinsi',    '=', 'dat_objek_pajak.kd_propinsi'],
            ['sppt.kd_dati2',    '=', 'dat_objek_pajak.kd_dati2'],
            ['sppt.kd_kecamatan',   '=', 'dat_objek_pajak.kd_kecamatan'],
            ['sppt.kd_kelurahan',   '=', 'dat_objek_pajak.kd_kelurahan'],
            ['sppt.kd_blok',        '=', 'dat_objek_pajak.kd_blok'],
            ['sppt.no_urut',        '=', 'dat_objek_pajak.no_urut'],
            ['sppt.kd_jns_op',      '=', 'dat_objek_pajak.kd_jns_op']
        ])
        ->leftJoin('ref_kelurahan', [
   
            ['sppt.kd_kecamatan',   '=', 'ref_kelurahan.kd_kecamatan'],
            ['sppt.kd_kelurahan',   '=', 'ref_kelurahan.kd_kelurahan'],
        ])
         ->where('sppt.status_pembayaran_sppt', 1);

    // Pencarian berdasarkan Tahun Pajak
        if (!empty($request->query('tahun_awal','tahun_akhir'))) {
            $result = $cek->whereBetween('sppt.thn_pajak_sppt',[ $tahun_awal,$tahun_akhir]);
        }
    // Pencarian berdasarkan Kecamatan     
        if (!empty($request->query('kecamatan'))) {
             $result = $cek->where('sppt.kd_kecamatan', $request->query('kecamatan'));
        }
    // Pencarian berdasarkan Tanggal Bayar      
        if (!empty($request->query('start_date','end_date'))) {
             $result= $cek ->whereBetween('sppt.tgl_pembayaran_sppt', [$start_date,$end_date]);              
         }
             $result= $cek ->get();
            // dd($result);
            return view('content.realisasi_report',compact('result','kec'),["title" => "Report"]);
          }

    // Function Tunggakan
    public function Filter_tunggakan (Request $request)
    {
        $tahunPajakAwal = $request->input('tahunpajak_awal');
        $tahunPajakAkhir= $request->input('tahunpajak_akhir');
        $kdKecamatan    = $request->input('kecamatanop');
    
        // Query untuk mengambil data tagihan pajak PBB
        $query = DB::table('SPPT AS S')
            ->select(
                DB::raw("S.KD_PROPINSI || '.' || S.KD_DATI2 || '.' || S.KD_KECAMATAN || '.' || S.KD_KELURAHAN || '.' || S.KD_BLOK || '.' || S.NO_URUT || '.' || S.KD_JNS_OP AS NOP"),
                'S.NM_WP_SPPT AS NAMA_WP',
                'T.JALAN_OP',
                'S.THN_PAJAK_SPPT AS THN_PAJAK',
                'Y.NM_KECAMATAN',
                'Z.NM_KELURAHAN',
                'S.TGL_TERBIT_SPPT',
                DB::raw("TO_CHAR(S.TGL_JATUH_TEMPO_SPPT, 'DD/MM/YYYY') AS TGL_JTH_TEMPO"),
                DB::raw("ROUND(S.FAKTOR_PENGURANG_SPPT, 0) AS PENGURANG"),
                DB::raw("ROUND(S.PBB_YG_HARUS_DIBAYAR_SPPT, 0) AS POKOK_PBB"),
                DB::raw("ROUND(
                    (
                        CASE WHEN CEIL(MONTHS_BETWEEN(SYSDATE, S.TGL_JATUH_TEMPO_SPPT)) > 24 THEN 24
                            WHEN CEIL(MONTHS_BETWEEN(SYSDATE, S.TGL_JATUH_TEMPO_SPPT)) > 0 THEN CEIL(MONTHS_BETWEEN(SYSDATE, S.TGL_JATUH_TEMPO_SPPT))
                            ELSE 0
                        END
                    ) * 0.02 * S.PBB_YG_HARUS_DIBAYAR_SPPT, 0
                ) AS DENDA"),
                DB::raw("ROUND(
                    S.PBB_YG_HARUS_DIBAYAR_SPPT + (
                        CASE WHEN CEIL(MONTHS_BETWEEN(SYSDATE, S.TGL_JATUH_TEMPO_SPPT)) > 24 THEN 24
                            WHEN CEIL(MONTHS_BETWEEN(SYSDATE, S.TGL_JATUH_TEMPO_SPPT)) > 0 THEN CEIL(MONTHS_BETWEEN(SYSDATE, S.TGL_JATUH_TEMPO_SPPT))
                            ELSE 0
                        END
                    ) * 0.02 * S.PBB_YG_HARUS_DIBAYAR_SPPT, 0
                ) AS TOTAL_HRS_DIBAYAR")
            )
            ->join('REF_KECAMATAN AS Y', function ($join) {
                $join->on('Y.KD_PROPINSI','S.KD_PROPINSI')
                     ->on('Y.KD_DATI2','S.KD_DATI2')
                     ->on('Y.KD_KECAMATAN','S.KD_KECAMATAN');
            })
            ->join('REF_KELURAHAN AS Z', function ($join) {
                $join->on('Z.KD_PROPINSI','Y.KD_PROPINSI')
                     ->on('Z.KD_DATI2','Y.KD_DATI2')
                     ->on('Z.KD_KECAMATAN','Y.KD_KECAMATAN')
                     ->on('Z.KD_KELURAHAN','S.KD_KELURAHAN');
            })
            ->join('DAT_OBJEK_PAJAK AS T', function ($join) {
                $join->on('T.KD_PROPINSI','S.KD_PROPINSI')
                     ->on('T.KD_DATI2','S.KD_DATI2')
                     ->on('T.KD_KECAMATAN','S.KD_KECAMATAN')
                     ->on('T.KD_KELURAHAN','S.KD_KELURAHAN')
                     ->on('T.KD_BLOK','S.KD_BLOK')
                     ->on('T.NO_URUT','S.NO_URUT')
                     ->on('T.KD_JNS_OP','S.KD_JNS_OP');
            })
            ->where('S.STATUS_PEMBAYARAN_SPPT', '0');
            if ($tahunPajakAwal && $tahunPajakAkhir) {
                $query->whereBetween('S.THN_PAJAK_SPPT', [$tahunPajakAwal, $tahunPajakAkhir]);
            }
        
            if ($kdKecamatan) {
                $query->where('S.KD_KECAMATAN', $kdKecamatan);
            }
            $tagihanPajak = $query
            ->orderBy('S.KD_KECAMATAN')
            ->orderBy('S.KD_KELURAHAN')
            ->orderBy('S.KD_BLOK')
            ->orderBy('S.NO_URUT')
            ->orderBy('S.KD_JNS_OP')
            ->orderBy('S.THN_PAJAK_SPPT', 'ASC')
            ->get();
    
        // return response()->json($tagihanPajak);
        return view('content.tunggakan_report',compact('tagihanPajak'),["title" => "Report"]);
    }

}