@extends('master.main')
@section('content')

<div class="row">
    <div class="col-sm-12">
    <div class="row">
{{-- Card Jumlah SPPT --}}
        <div class="col-sm-3 col-xs-12">
            <div class="panel panel-default card-view pa-0">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body pa-0">
                        <div class="sm-data-box">
                            <div class="container-fluid">
                                <div class="row">
                                                                                         
                                    <div class="col-xs-9 data-wrap-left">
                                        <span class="capitalize-font block">Jumlah SPPT</span>
                                        <span class="txt-dark block"><span class="counter inline-block"><span class="counter-anim">
                                            
                                            @foreach ($resultCard as $p) 

                                            @if(!empty($p->jumlah_sppt))
                                            {{ $p->jumlah_sppt }}                                    
                                            @else 
                                            {{ 0 }}
                                            @endif
                                        </span></span></span>
                                    </div>
                                    <div class="col-xs-3 text-center  pl-0 pr-0 data-wrap-right">
                                        <i class="zmdi zmdi-storage data-right-rep-icon bg-grad-sunset"></i>
                                    </div>
                                </div>
                                <div class="progress-anim">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-grad-success 
                                        wow animated progress-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
{{-- Card Target PBB  --}}
        <div class="col-sm-3 col-xs-12">
            <div class="panel panel-default card-view pa-0">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body pa-0">
                        <div class="sm-data-box">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-9 data-wrap-left">
                                        <span class="capitalize-font block">Target PBB</span>
                                            <span class="txt-dark block">
                                                <span class="counter inline-block">
                                                    @if(!empty($p->jumlah_sppt))
                                                    @currency($p->target )                                    
                                                    @else 
                                                    {{ 0 }}
                                                    @endif                                             
                                                </span>
                                            </span>
                                    </div>
                                    <div class="col-xs-3 text-center  pl-0 pr-0 data-wrap-right">
                                        <i class="zmdi zmdi-trending-up data-right-rep-icon bg-grad-warning"></i>
                                    </div>
                                </div>
                                <div class="progress-anim">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-grad-warning 
                                        wow animated progress-animated" role="progressbar" aria-valuenow="
                                        @if(!empty($p->realisasi_pokok))
                                        {{ $p->realisasi_pokok/$p->target*100 }}" aria-valuemin="0" aria-valuemax="{{ $p->target }}
                                        @else 
                                        {{ 0 }}
                                        @endif">
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {{-- Card Realisasi PBB  --}}
        <div class="col-sm-3 col-xs-12">
            <div class="panel panel-default card-view pa-0">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body pa-0">
                        <div class="sm-data-box">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-9 data-wrap-left">
                                        <span class="capitalize-font block">Realisasi</span>
                                        <span class="txt-dark block">
                                            <span class="counter inline-block">
                                                @if(!empty($p->jumlah_sppt))
                                                @currency($p->realisasi_total)                                    
                                                    @else 
                                                    {{ 0 }}
                                                    @endif                                                                                          
                                            </span>
                                        </span>
                                    </div>
                                    <div class="col-xs-3 text-center  pl-0 pr-0 data-wrap-right">
                                        <i class="zmdi zmdi-assignment-check data-right-rep-icon bg-grad-info"></i>
                                    </div>
                                </div>
                                <div class="progress-anim">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-grad-primary 
                                        wow animated progress-animated" role="progressbar" aria-valuenow="
                                        @if(!empty($p->realisasi_pokok))
                                        {{ $p->realisasi_pokok/$p->target*100 }}" aria-valuemin="0" aria-valuemax="{{ $p->target }}
                                        @else 
                                        {{ 0 }}
                                        @endif
                                        "></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {{-- Card Persentase Realisasi  --}}
        <div class="col-sm-3 col-xs-12">
            <div class="panel panel-default card-view pa-0">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body pa-0">
                        <div class="sm-data-box">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-9 data-wrap-left">
                                        <span class="capitalize-font block">Persentase</span>
                                            <span class="txt-dark block">
                                                <span class="counter inline-block">
                                                    @if(!empty($p->jumlah_sppt))
                                                    @persen($p->realisasi_pokok/$p->target*100) %                                    
                                                        @else 
                                                        {{ 0 }}
                                                        @endif                                                      
                                                </span>
                                        </span>
                                    </div>
                                    <div class="col-xs-3 text-center  pl-0 pr-0 data-wrap-right">
                                        <i class="zmdi zmdi-lamp data-right-rep-icon bg-grad-danger"></i>
                                    </div>
                                </div>
                                <div class="progress-anim">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-grad-danger 
                                        wow animated progress-animated" role="progressbar" aria-valuenow="
                                        @if(!empty($p->jumlah_sppt))
                                        {{ $p->realisasi_pokok/$p->target*100 }}
                                        " 
                                        aria-valuemin="0" aria-valuemax="
                                        {{ $p->target }}
                                        @else 
                                        {{ 0 }}
                                        @endif
                                        ">
                                        @endforeach  
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
{{-- Tabel Tahun Berjalan --}}
        <div class="col-sm-12 col-xs-12">
            <div class="panel panel-default border-panel card-view panel-refresh">
                <div class="refresh-container">
                    <div class="la-anim-1"></div>
                </div>
                <div class="panel-heading">
                    <div class="pull-left">
                        <h6 class="panel-title txt-dark">Penerimaan Tahun Aktif</h6>
                    </div>
                    <div class="pull-right">
                        <a href="#" class="pull-left inline-block refresh mr-15">
                            <i class="zmdi zmdi-replay"></i>
                        </a>
                        <a href="#" class="pull-left inline-block full-screen mr-15">
                            <i class="zmdi zmdi-fullscreen"></i>
                        </a>

                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body row pa-0">
                        <div class="table-wrap">
                            <div class="table-responsive">
                                @php
                                    $bulanIndonesia = [
                                        1 => 'Januari',
                                        2 => 'Februari',
                                        3 => 'Maret',
                                        4 => 'April',
                                        5 => 'Mei',
                                        6 => 'Juni',
                                        7 => 'Juli',
                                        8 => 'Agustus',
                                        9 => 'September',
                                        10 => 'Oktober',
                                        11 => 'November',
                                        12 => 'Desember',
                                    ];
                                @endphp
                                <table style="border: 1px"  class="table table-hover mb-0">
                                    
                                    <thead>
                                        <tr>
                                            @foreach ($bulanIndonesia as $bulan)
                                                <th>{{ $bulan }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            @foreach ($result as $totalBulan)
                                                <td>{{ number_format($totalBulan, 0, ',', '.') }}</td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <td align="center" class="panel-title txt-dark" colspan="11">Total </td>
                                            <td class="text-right strong">{{ 'Rp ' . number_format($totalKeseluruhan, 0, ',', '.') }}</td>
                                        </tr>
                                    </tbody>
                                    </table>
                            </div>
                        </div>	
                    </div>	
                </div>
            </div>
        </div>
{{-- Tabel Piutang --}}
        <div class="col-sm-12 col-xs-12">
            <div class="panel panel-default border-panel card-view panel-refresh">
                <div class="refresh-container">
                    <div class="la-anim-1"></div>
                </div>
                <div class="panel-heading">
                    <div class="pull-left">
                        <h6 class="panel-title txt-dark">Penerimaan Piutang</h6>
                    </div>
                    <div class="pull-right">
                        <a href="#" class="pull-left inline-block refresh mr-15">
                            <i class="zmdi zmdi-replay"></i>
                        </a>
                        <a href="#" class="pull-left inline-block full-screen mr-15">
                            <i class="zmdi zmdi-fullscreen"></i>
                        </a>

                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body row pa-0">
                        <div class="table-wrap">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>                                            
                                            @foreach ($bulanIndonesia as $bulan)
                                                <th>{{ $bulan }}</th>
                                            @endforeach            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>           
                                            @foreach ($resultNonAktif as $totalBulanNonAktif)
                                                <td>{{ number_format($totalBulanNonAktif, 0, ',', '.') }}</td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <td align="center" class="panel-title txt-dark" colspan="11">Total </td>
                                            <td>{{ 'Rp ' . number_format($totalKeseluruhanNonAktif, 0, ',', '.') }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>	
                    </div>	
                </div>
            </div>
        </div>
 
    </div>
    </div>
    </div>

@endsection