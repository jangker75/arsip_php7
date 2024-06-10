@extends('crudbooster::admin_template')
@section('content')

<div class="row">
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-yellow"><i class="fa fa-pencil"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Jumlah Client</span>
        <span class="info-box-number">
          {{	$countClient}}
        </span>
      </div>

    </div>

  </div>
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-yellow"><i class="fa fa-pencil"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Jumlah Box Jepara</span>
        <span class="info-box-number">
          {{	$countBoxJepara}}
        </span>

      </div>

    </div>

  </div>
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-yellow"><i class="fa fa-pencil"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Jumlah Box Cibitung</span>
        <span class="info-box-number">
          {{$countBoxCibitung}}
        </span>

      </div>

    </div>

  </div>

  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-yellow"><i class="fa fa-pencil"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Total Box All Lokasi</span>
        <span class="info-box-number">
          {{$countBoxall1}}

        </span>
      </div>

    </div>

  </div>

  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-yellow"><i class="fa fa-pencil"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Total Box Tersimpan</span>
        <span class="info-box-number">
          {{$countBoxTersimpan}}

        </span>
      </div>

    </div>

  </div>

  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-yellow"><i class="fa fa-pencil"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Total Box Dipinjam</span>
        <span class="info-box-number">
          {{$countBoxDipinjam}}

        </span>
      </div>

    </div>

  </div>

  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-yellow"><i class="fa fa-pencil"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Total Box Diambil</span>
        <span class="info-box-number">
          {{$countBoxDiambil}}

        </span>
      </div>

    </div>

  </div>

  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-yellow"><i class="fa fa-pencil"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Total Box All Status</span>
        <span class="info-box-number">
          {{$countBoxall2}}

        </span>
      </div>

    </div>

  </div>

  {{-- <div class='tableauPlaceholder' id='viz1590724758276' style='position: relative'>
    <noscript><a href='#'>
        <img alt=' '
          src='https:&#47;&#47;public.tableau.com&#47;static&#47;images&#47;Bo&#47;Book1_15907246567100&#47;Sheet1&#47;1_rss.png'
          style='border: none' /></a></noscript><object class='tableauViz' style='display:none;'>
      <param name='host_url' value='https%3A%2F%2Fpublic.tableau.com%2F' />
      <param name='embed_code_version' value='3' />
      <param name='site_root' value='' />
      <param name='name' value='Book1_15907246567100&#47;Sheet1' />
      <param name='tabs' value='no' />
      <param name='toolbar' value='yes' />
      <param name='static_image'
        value='https:&#47;&#47;public.tableau.com&#47;static&#47;images&#47;Bo&#47;Book1_15907246567100&#47;Sheet1&#47;1.png' />
      <param name='animate_transition' value='yes' />
      <param name='display_static_image' value='yes' />
      <param name='display_spinner' value='yes' />
      <param name='display_overlay' value='yes' />
      <param name='display_count' value='yes' /></object></div>
  <script type='text/javascript'>
    var divElement = document.getElementById('viz1590724758276');                    var vizElement = divElement.getElementsByTagName('object')[0];                    vizElement.style.width='100%';vizElement.style.height=(divElement.offsetWidth*0.75)+'px';                    var scriptElement = document.createElement('script');                    scriptElement.src = 'https://public.tableau.com/javascripts/api/viz_v1.js';                    vizElement.parentNode.insertBefore(scriptElement, vizElement);       
  </script> --}}

</div>
</div>

@endsection