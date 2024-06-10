<!DOCTYPE html>
<html>
    
         <style>
             /* table {
  border-collapse: collapse;
}
          /* table, th, td {
  border: 1px solid black;
} */ */
         
        </style>
        
<body>
    <div >
    <table width=1300>
        <tbody>
            <td width=30%>
                    <img src='https://chart.googleapis.com/chart?chs=500x500&cht=qr&chl={{$data->kode_box_sistem}}' 
                            style='width:900px;height:900px;'>
              
            </td>
            <td width=70%>
                {{-- <div style="margin-right:0px">
                    <img src="http://ptmitradatasarana.com/arsip/public/uploads/2020-10/d5801db7ccbb889d955f39a73fa7ed44.png"
                    style='width:40px;height:40px;'>
                </div> --}}
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