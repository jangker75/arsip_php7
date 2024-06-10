<!-- First you need to extend the CB layout -->
@extends('crudbooster::admin_template')
@section('content')

<div class="box-tools pull-{{ trans('crudbooster.right') }}" style="position: relative;margin-top: -5px;margin-right: -10px">
          
    @if($button_filter)
    <a style="margin-top:-23px" href="javascript:void(0)" id='btn_advanced_filter' data-url-parameter='{{$build_query}}' title='{{trans('crudbooster.filter_dialog_title')}}' class="btn btn-sm btn-default {{(Request::get('filter_column'))?'active':''}}">                               
      <i class="fa fa-filter"></i> {{trans("crudbooster.button_filter")}}
    </a>
    @endif
    

<form method='get' style="display:inline-block;width: 260px;" action='{{Request::url()}}'>
    <div class="input-group">
      <input type="text" name="q" value="{{ Request::get('q') }}" class="form-control input-sm pull-{{ trans('crudbooster.right') }}" placeholder="{{trans('crudbooster.filter_search')}}"/>
      {!! CRUDBooster::getUrlParameters(['q']) !!}
      <div class="input-group-btn">
        @if(Request::get('q'))
        <?php 
          $parameters = Request::all();
          unset($parameters['q']);
          $build_query = urldecode(http_build_query($parameters));
          $build_query = ($build_query)?"?".$build_query:"";
          $build_query = (Request::all())?$build_query:"";
        ?>
        <button type='button' onclick='location.href="{{ CRUDBooster::mainpath().$build_query}}"' title="{{trans('crudbooster.button_reset')}}" class='btn btn-sm btn-warning'><i class='fa fa-ban'></i></button>
        @endif
        <button type='submit' class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
      </div>
    </div>
</form>

<form method='get' id='form-limit-paging' style="display:inline-block" action='{{Request::url()}}'>                        
    {!! CRUDBooster::getUrlParameters(['limit']) !!}
    <div class="input-group">
      <select onchange="$('#form-limit-paging').submit()" name='limit' style="width: 56px;"  class='form-control input-sm'>
          <option {{($limit==5)?'selected':''}} value='5'>5</option> 
          <option {{($limit==10)?'selected':''}} value='10'>10</option>
          <option {{($limit==20)?'selected':''}} value='20'>20</option>
          <option {{($limit==25)?'selected':''}} value='25'>25</option>
          <option {{($limit==50)?'selected':''}} value='50'>50</option>
          <option {{($limit==100)?'selected':''}} value='100'>100</option>
          <option {{($limit==200)?'selected':''}} value='200'>200</option>
      </select>                              
    </div>
  </form>
</div>
<!-- Your custom  HTML goes here -->
<table class='table table-striped table-bordered'>
  <thead>
      <tr>
        <th>Nama Pengirim</th>
        <th>Nomor Box</th>
        <th>Nomor Rak</th>
        <th>Action</th>
       </tr>
  </thead>
  <tbody>
    @foreach($result as $row)
      <tr>
        <td>{{$row->nama}}</td>
        <td>{{$row->kode_box}}</td>
        <td>{{$row->nomor_rak}}</td>
        <td>
          <!-- To make sure we have read access, wee need to validate the privilege -->
          @if(CRUDBooster::isUpdate() && $button_edit)
          <a class='btn btn-success btn-sm' href='{{CRUDBooster::mainpath("edit/$row->id")}}'>Edit</a>
          @endif
          
          @if(CRUDBooster::isDelete() && $button_edit)
          <a class='btn btn-success btn-sm' href='{{CRUDBooster::mainpath("delete/$row->id")}}'>Delete</a>
          @endif
        </td>
       </tr>
    @endforeach
  </tbody>
</table>


<!-- ADD A PAGINATION -->
<p>{!! urldecode(str_replace("/?","?",$result->appends(Request::all())->render())) !!}</p>
@endsection