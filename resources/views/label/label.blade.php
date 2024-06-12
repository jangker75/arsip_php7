<!DOCTYPE html>
<html>
    <body>
    <div style="padding-left: 40px">
        <table width=1300>
            <tbody>
                <td width=30%>
                        {{-- <img src='https://chart.googleapis.com/chart?chs=500x500&cht=qr&chl={{$data->kode_box_sistem}}' 
                                style='width:900px;height:900px;'> --}}
                        {{ QrCode::size(670)->generate($data->kode_box_sistem) }}
                
                </td>
                <td width=70% style="padding-left: 40px">
                        <h4 style="font-size:72px">{{$client->nama}}
                            <br>
                        {{-- <br>Nomor Rak : {{$data->nomor_rak}} --}}
                        <br>Kode Box: <br>{{$data->kode_box_sistem}}
                        <br>
                        <br>Nomor Box: <br>{{$data->kode_box}}</h4>
                    
                </td>
            </tbody>
        </table>
    </div>
    
</body>
</html>