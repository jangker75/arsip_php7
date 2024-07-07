<!-- First, extends to the CRUDBooster Layout -->
@extends('crudbooster::admin_template')
@section('content')
    <!-- Your html goes here -->
    <form method='POST' id="mainform" enctype="multipart/form-data" action='{{ CRUDBooster::mainpath('edit-box') . "/" . $row->id }}' >
        {{ csrf_field() }}
        <p>
            <a href="{{ CRUDBooster::mainpath('')}}" class="btn btn-sm btn-primary">&laquo; Kembali</a>
        </p>
        <div class='panel panel-default'>
            <div class='panel-heading'>
                {{-- <a href="{{ CRUDBooster::mainpath('') }}" class="btn btn-warning"><i
                class="fa fa-chevron-circle-left"></i> Back</a> --}}
                Detail Box {{ $row->kode_box }}</div>

            <div class='panel-body'>
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th style="width: 30%"></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <label>Nomor Box</label>
                                </td>
                                <td>
                                    {{ $row->kode_box }}
                                </td>
                            </tr>
                            <tr>
                                <td><label>Client</label></td>
                                <td>
                                    {{ $row->nama_client }}
                                </td>
                            </tr>
                            <tr>
                                <td><label>Cabang</label></td>
                                <td>
                                    {{ $row->nama_cabang }}
                                </td>
                            </tr>
                            <tr>
                                <td><label>Unit Kerja</label></td>
                                <td>
                                    {{ $row->nama_unit_kerja }}
                                </td>
                            </tr>
                            <tr>
                                <td><label>Nama Pengirim</label></td>
                                <td>
                                    {{ $row->nama }}
                                </td>
                            </tr>
                            <tr>
                                <td><label>Lokasi Penyimpanan Vault</label></td>
                                <td>
                                    {{ $row->nama_lokasi_vault }}
                                </td>
                            </tr>
                            <tr>
                                <td><label>Tanggal Pemindahan</label></td>
                                <td>
                                    {{ $row->tgl_pemindahan }}
                                </td>
                            </tr>
                            <tr>
                                <td><label>Jumlah Bantex</label></td>
                                <td>
                                    {{ $row->jumlah_dok }}
                                </td>
                            </tr>
                            @if (CRUDBooster::myPrivilegeId() <= 2)
                            <tr>
                                <td><label>Nomor Rak</label></td>
                                <td>
                                    {{ $row->nomor_rak_tersimpan }}
                                </td>
                            </tr>    
                            @endif
                            
                            <tr>
                                <td><label>Attachment</label></td>
                                <td>
                                    @foreach ($file_atc as $item)
                                    <a class="btn btn-warning" target="_blank" href="{{ asset($item->path) }}">Download {{ $item->filename }}</a>    
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <td><label>Status</label></td>
                                <td>
                                    {{ $row->nama_status }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class='box-footer'>
                <div class="form-group">
                    <label class="control-label col-sm-2"></label>
                    <div class="col-sm-10">
                        <a href="{{ CRUDBooster::mainpath('') }}" class="btn btn-default"><i
                                class="fa fa-chevron-circle-left"></i> Back</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection