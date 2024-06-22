<!-- First, extends to the CRUDBooster Layout -->
@extends('crudbooster::admin_template')
@section('content')
    <!-- Your html goes here -->
    <div class='panel panel-default'>
        <div class='panel-heading'>
            {{ $title }}
        </div>

        <div class='panel-body'>
            <div class="row">
                @foreach ($listContact as $item)
                    <div class="col-sm-6 col-md-4">
                        <div class="thumbnail">
                            <img style="object-fit: cover; height: 150px;" src="{{ $listImg->{Str::lower($item->contact_type)} }}">
                            <div class="caption">
                                <h3>{{ $item->name }}</h3>
                                <p style="font-size: 24px"><i  class="fa fa-whatsapp"></i> : {{ $item->phone }}</p>
                                <p style="text-align: right">
                                    <a target="_blank" href="https://wa.me/{{ $item->phone }}" class="btn btn-primary" role="button">Whatsapp Me !</a>
                                </p>
                            </div>
                        </div>
                    </div>    
                @endforeach
                
              </div>
        </div>
    </div>
@endsection