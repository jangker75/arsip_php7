<!-- First, extends to the CRUDBooster Layout -->
@extends('crudbooster::admin_template')
@section('content')
<!-- Your html goes here -->
<div style="margin-bottom: 20px">
    <a class="btn btn-primary btn-sm" href="{{ CRUDBooster::mainpath() }}">Back to {{$page}}</a>
</div>
<div class='panel panel-default'>
    <div class="panel-heading">
        <strong><i class="fa fa-plus"></i> {{$page_title}}</strong>
    </div>
    <div class="panel-body">
        {{-- <form action="{{route('admin.product.update',[$data->id])}}" method="post" enctype="multipart/form-data"> --}}
        <form method="post" enctype="multipart/form-data" action="">
            @csrf
            <input type="hidden" name="id" value="{{$cabang->id}}">
            <div class='table-responsive'>
                <table id='table-detail' class='table table-striped'>
                    <tbody>
                        <tr>
                            <td>
                                <b>Client</b>
                            </td>
                            <td> 
                                {{ $cabang->client->nama }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Cabang</b>
                            </td>
                            <td> 
                                {{ $cabang->nama }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <label for="photo">Foto</label>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div class="form-group">
                                    <div class="needsclick dropzone" id="photo-dropzone">
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class='box-footer'>
                <div class="form-group">
                    <label class="control-label col-sm-2"></label>
                    <div class="col-sm-10">
                    <a href="{{CRUDBooster::mainpath('')}}" class="btn btn-default"><i class="fa fa-chevron-circle-left"></i> Back</a>
                    <input type="submit" name="submit" value='Save changes' class="btn btn-success">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@push('head')
<link href="{{ asset('asset/dropzone/dist/min/dropzone.min.css') }}" rel="stylesheet">
@endpush
@push('bottom')
<script type="text/javascript" src="{{ asset('asset/dropzone/dist/min/dropzone.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            var uploadedPhotoMap = {}
        Dropzone.options.photoDropzone = {
            url: '{{ route('admin.storeMedia') }}',
            maxFilesize: 5, // MB
            addRemoveLinks: true,
            acceptedFiles: ".png,.jpg,.jpeg",
            headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            success: function (file, response) {
                $('form').append('<input type="hidden" name="photo[]" value="' + response.name + '">')
                uploadedPhotoMap[file.name] = response.name
            },
            removedfile: function (file) {
                file.previewElement.remove()
                var name = ''
                if (typeof file.file_name !== 'undefined') {
                    name = file.file_name
                } else {
                    name = uploadedPhotoMap[file.name]
                }
                $('form').find('input[name="photo[]"][value="' + name + '"]').remove()
            },
            init: function () {
                let myDropzone = this;
                @if(isset($cabang) && $cabang->photos)
                    var files =
                    {!! json_encode($cabang->photos) !!}
                    for (var i in files) {
                        var file = files[i]
                        var mockFile = { name: file.name, size: file.size }
                        myDropzone.displayExistingFile(file, file.url)
                        file.previewElement.classList.add('dz-success');
                        file.previewElement.classList.add('dz-complete');
                        $('form').append('<input type="hidden" name="photo[]" value="' + file.file_name + '">')
                    }
                @endif
            }
        }
        })
        
    </script>
@endpush