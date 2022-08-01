
        <style>
            #cetakLaporan {
                font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
                border-collapse: collapse;
                width: 100%;
                font-size: 13px;
            }

            #cetakLaporan td, #cetakLaporan th {
                border: 1px solid #ddd;
                padding: 8px;
            }

            #cetakLaporan tr:nth-child(even){background-color: #f2f2f2;}

            #cetakLaporan tr:hover {background-color: #ddd;}

            #cetakLaporan th {
                padding-top: 12px;
                padding-bottom: 12px;
                text-align: left;
                background-color: #4CAF50;
                color: white;
            }
        </style>

    <div style="width: 1px; min-width: 100%;">
      <table id="cetakLaporan" width="100%" border="0" style="border-bottom: 1px solid #ddd;">
        <thead align="center">
          <tr align="center">
            <td width="80px" style="border: 0;">
              <img src="{{asset('/img/icon-logo.png')}}" style="width: 80px; height: 80px;object-fit: contain;">
            </td>
            <td style="border: 0;">
              <h1 style="margin: 0;"><u>CV. Sinar Bintang Teknik</u></h1>
          <p style="margin: 0;">
            Jl. Gn Bromo VIII/Blok V No. 57 Perumnas Monang Maning
            <br>
            Telp. 081 246 381 744
          </p>
            </td>
          </tr>
        </thead>
      </table>
        <h4 align="left">Laporan Tugas Teknisi&nbsp;{{ $rangeTanggal }}</h4>
        <table id="cetakLaporan" width="100%" style="margin-top: 20px;">
            <thead>
                @if(count($laporan) <= 0 )
                <tr>
                  <td style="word-break: break-word; font-weight: bold; text-align: center;">
                    Tidak ada data yang tersedia
                  </td>
                </tr>
                @else
                <tr>
                    <td style="word-break: break-word; font-weight: bold;">No</td>
                    <td style="word-break: break-word; font-weight: bold;">Nama Pelanggan</td>
                    <td style="word-break: break-word; font-weight: bold;">Alamat Pelanggan</td>
                    <td style="word-break: break-word; font-weight: bold;">No Telp Pelanggan</td>
                    <td style="word-break: break-word; font-weight: bold;">Kategori Jasa</td>
                    <td style="word-break: break-word; font-weight: bold;">Teknisi</td>
                    <td style="word-break: break-word; font-weight: bold;">Detail</td>
                    <td style="word-break: break-word; font-weight: bold;">Status</td>
                    <td style="word-break: break-word; font-weight: bold;">Dimulai pada</td>
                    <td style="word-break: break-word; font-weight: bold;">Selesai pada</td>
                </tr>
                @endif
            </thead>
            <tbody>
                @foreach($laporan as $data)
                    <tr>
                        <td style="word-break: break-word;">{{ $loop->index + 1 }}</td>
                        <td style="word-break: break-word;">{{ $data->pelanggan->nama }}</td>
                        <td style="word-break: break-word;">{{ $data->pelanggan->alamat }}</td>
                        <td style="word-break: break-word;">{{ $data->pelanggan->no_telp }}</td>
                        <td style="word-break: break-word;">{{ $data->kategorijasa->nama }}</td>
                        <td style="word-break: break-word;">{{ $data->karyawan->name }}</td>
                        <td style="word-break: break-word;">{{ $data->detail }}</td>
                        <td style="word-break: break-word;">{{ $data->status }}</td>
                        <td style="word-break: break-word;">{{ "Jam: " . $data->jam_mulai . ", Tanggal: ". $data->tanggal_mulai }}</td>
                        <td style="word-break: break-word;">
                          @if($data->status === "finish")
                          {{ "Jam: " . $data->jam_selesai . ", Tanggal: ". $data->tanggal_selesai }}
                          @else
                          -
                          @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>