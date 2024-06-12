<!DOCTYPE html>
<html>
    <body>
    <div style="padding-left: 40px; padding-top: 80px">
        <table width=1300>
            <tbody>
                <td width=30%>
                    {{ QrCode::size(670)->generate($data->nomor_rak) }}
                </td>
                <td width=70% style="padding-left: 40px">
                    <h4 style='font-size:72px;'>
                        Nomor Rak :
                    <br>
                        {{ $data->nomor_rak }}
                    <br>
                    <br>
                        Deskripsi :
                    <br>
                        {{ $data->deskripsi }}
                    </h4>
                </td>
            </tbody>
        </table>
    </div>
    
</body>
</html>