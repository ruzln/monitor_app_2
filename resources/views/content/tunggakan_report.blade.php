@extends('master.main')
@section('content')
<!-- Row -->
<div class="row">
	<div class="col-sm-12">
        <div class="panel panel-default border-panel card-view">
            <div class="panel-heading">
                <div class="col-md-4">  
                    <h6 class="panel-title txt-dark">Laporan Tunggakan</h6>
                </div>
                <div class="col-md-6 pull-right">
                                    
				</div>
                <div class="clearfix"></div>
            </div>
		<br>
			<div class="panel-wrapper collapse in">
				<div class="panel-body pt-0">
					<div class="table-wrap">
						<div class="table-responsive">
							<table id="example" class="table table-hover display  pb-30" >
								<thead class="bg-grad-danger">
									<tr>
										
										<th>No</th>
										<th>NOP</th>
										<th>Nama Wajib Pajak</th>
										<th>Letak Objek</th>
										<th>Tahun Pajak</th>
										<th>Kecamatan</th>
										<th>Kelurahan</th>
										<th>Pokok PBB</th>
										<th>Denda</th>
										<th>Total Tagihan</th>
									</tr>
								</thead>
								<tbody>
									<?php $no=1 ?>
									@foreach ($tagihanPajak as $item)
									<tr>
										
										<td>{{ $no++ }}</td>
										<td>{{ $item->nop}}</td>
										<td>{{ $item->nama_wp  }}</td>
										<td>{{ $item->jalan_op  }}</td>
										<td>{{ $item->thn_pajak }}</td>
										<td>{{ $item->nm_kecamatan  }}</td>
										<td>{{ $item->nm_kelurahan  }}</td>
										<td>@currency( $item->pokok_pbb )</td>
										<td>@currency( $item->denda )</td>																				
										<td>@currency( $item->total_hrs_dibayar )</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
        </div>
	</div>
</div>
<!-- /Row -->  
@endsection