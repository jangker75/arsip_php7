@extends('crudbooster::admin_template')
@section('content')
<div class="box box-primary">
    <div class="box box-body">
        <p>
            <a href="{{action('AdminBoxController@getIndex')}}" class="btn btn-xs btn-primary">&laquo; Kembali</a>
        </p>
		<div class="panel panel-default">
            <div class="panel-heading">Import Data Box</div>
			<form method="post" enctype="multipart/form-data" action="">
				{!! csrf_field() !!}
			<div class="panel-body">
				
				<div class="form-group">
					<label>File XLS</label>
					<input type="file" class="form-control" required name="userfile">
					<div class="help-block">
						File format .xls, .xlsx. Unduh format template <a href="{{asset('format_import/format import box.xlsx')}}" target="_blank">Klik disini</a>
					</div>
				</div>

			</div>
			<div class="panel-footer">
				<input type="submit" class="btn btn-primary" value="Import">
			</div>
			</form>
        </div>		
    </div>
</div>
@endsection