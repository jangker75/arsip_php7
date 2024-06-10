<!-- First, extends to the CRUDBooster Layout -->
@extends('crudbooster::admin_template')
@section('content')
    <!-- Your html goes here -->
    <form method='POST' enctype="multipart/form-data" action='{{ CRUDBooster::mainpath('edit-box') . "/" . $row->id }}' >
        {{ csrf_field() }}
        <div class='panel panel-default'>
            <div class='panel-heading'>
                {{-- <a href="{{ CRUDBooster::mainpath('') }}" class="btn btn-warning"><i
                class="fa fa-chevron-circle-left"></i> Back</a> --}}
                Edit Form - Kode Box {{ $row->kode_box }}</div>

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
                                    <input readonly='true' name='name' required class='form-control'
                                        value='{{ $row->kode_box }}' />
                                </td>
                            </tr>
                            <tr>
                                <td><label>Client</label></td>
                                <td>
                                    <select class="form-control" name="client_id" id="client_id">
                                        @foreach ($client_list as $client)
                                            @php
                                                $selected = ($row->client_id == $client->id) ? "selected" : "";
                                            @endphp
                                            <option {{ $selected }} value="{{ $client->id }}">{{ $client->nama }}</option>    
                                        @endforeach
                                    </select>
                                    {{-- <input readonly='true' name='name' required class='form-control'
                                        value='{{ $row->nama_client }}' /> --}}
                                </td>
                            </tr>
                            <tr>
                                <td><label>Cabang</label></td>
                                <td>
                                    <select class="form-control" name="cabang_id" id="cabang_id">
                                        @foreach ($cabang_list as $cabang)
                                            @php
                                                $selected = ($row->cabang_id == $cabang->id) ? "selected" : "";
                                            @endphp
                                            <option {{ $selected }} value="{{ $cabang->id }}">{{ $cabang->nama }}</option>    
                                        @endforeach
                                    </select>
                                    {{-- <input readonly='true' name='name' required class='form-control'
                                        value='{{ $row->nama_cabang }}' /> --}}
                                </td>
                            </tr>
                            <tr>
                                <td><label>Unit Kerja</label></td>
                                <td>
                                    <select class="form-control" name="unit_kerja_id" id="unit_kerja_id">
                                        @foreach ($unit_kerja_list as $unit_kerja)
                                            @php
                                                $selected = ($row->unit_kerja_id == $unit_kerja->id) ? "selected" : "";
                                            @endphp
                                            <option {{ $selected }} value="{{ $unit_kerja->id }}">{{ $unit_kerja->nama }}</option>    
                                        @endforeach
                                    </select>
                                    {{-- <input readonly='true' name='name' required class='form-control'
                                        value='{{ $row->nama_unit_kerja }}' /> --}}
                                </td>
                            </tr>
                            <tr>
                                <td><label>Nama Pengirim</label></td>
                                <td>
                                    <input name='nama' required class='form-control'
                                        value='{{ $row->nama }}' />
                                </td>
                            </tr>
                            <tr>
                                <td><label>Lokasi Penyimpanan Vault</label></td>
                                <td>
                                    <select name="lokasi_vault_id" id="lokasi_vault_id" class="form-control">
                                        @foreach ($lokasi_vault_list as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $item->id == $row->lokasi_vault_id ? 'selected' : '' }}>
                                                {{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><label>Tanggal Pemindahan</label></td>
                                <td>
                                    <input readonly='true' name='name' required class='form-control'
                                        value='{{ $row->tgl_pemindahan }}' />
                                </td>
                            </tr>
                            <tr>
                                <td><label>Jumlah Bantex</label></td>
                                <td>
                                    <input name='jumlah_dok' class='form-control'
                                        value='{{ $row->jumlah_dok }}' />
                                </td>
                            </tr>
                            <tr>
                                <td><label>Nomor Rak</label></td>
                                <td>
                                    <input name='nomor_rak' class='form-control' value='{{ $row->nomor_rak }}' />
                                </td>
                            </tr>
                            <tr>
                                <td><label>Status</label></td>
                                <td>
                                    <select name="status_id" id="status_id" required class="form-control">
                                        @foreach ($status_list as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $item->id == $row->status_id ? 'selected' : '' }}>{{ $item->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            {{-- <tr>
                                <td><label>Foto Penyimpanan</label></td>
                                <td>
                                        @php
                                            $noimage = 'https://icon-library.com/images/no-image-icon/no-image-icon-20.jpg';
                                            $elementNoimage = "<a data-lightbox='roadtrip' href='".$noimage ."'>
                                                                <img style='max-width:160px' title='Image For Foto'
                                                                    src='".$noimage."' />
                                                              </a>";
                                            $data = collect($row)->toArray();
                                        @endphp
                                        <div class="row">
                                          @for ($i = 1; $i < 4; $i++)
                                            <div class="col-sm-6 col-md-3 form-group">
                                                @if ($data["foto_{$i}"] != '' || $data["foto_{$i}"] != null)
                                                    <a data-lightbox='roadtrip' href='{{ url($data["foto_{$i}"]) }}'>
                                                        <img style='max-width:160px' title="Image For Foto"
                                                            src='{{ url($data["foto_{$i}"]) }}' />
                                                    </a>
                                                @else
                                                    {!! $elementNoimage !!}
                                                @endif
                                                <input type="file" accept="image/*" name="foto_{{ $i }}">
                                            </div>
                                        @endfor
                                      </div>
                                </td>
                            </tr> --}}
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
                        <input type="submit" name="submit" value='Save changes' class="btn btn-success">
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@push('bottom')
<script>
    $(document).ready(function(){

    })
    $("#client_id").on("change", function(){
        let clientId = $(this).find(":selected").val()
        $.ajax({
            type: "get",
            url: '{{ url('get-cabang-list')  }}/' + clientId,
            data: {"_token":"{{ csrf_token() }}"},
            dataType: "json",
            success: function (response) {
                if(response){
                    $("#cabang_id").empty()
                    $.each(response, function(key, cabang){
                        $('select[name="cabang_id"]').append('<option value="'+ cabang['id'] +'">' + cabang['nama']+ '</option>');
                    });
                }else{
                    $("#cabang_id").empty()
                }
                $("#cabang_id").trigger("change")
            }
        });
    })
    $("#cabang_id").on("change", function(){
        let clientId = $("#client_id").find(":selected").val()
        let cabangId = $(this).find(":selected").val()
        $.ajax({
            type: "get",
            url: '{{ url('get-unitkerja-list')  }}/' + clientId+'/' + clientId,
            data: {"_token":"{{ csrf_token() }}"},
            dataType: "json",
            success: function (response) {
                if(response){
                    $("#unit_kerja_id").empty()
                    $.each(response, function(key, unitkerja){
                        $('select[name="unit_kerja_id"]').append('<option value="'+ unitkerja['id'] +'">' + unitkerja['nama']+ '</option>');
                    });
                }else{
                    $("#unit_kerja_id").empty()
                }
            }
        });  
    })
</script>
@endpush