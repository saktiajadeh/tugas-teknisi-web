
        <style>
            #cetakLaporan {
                font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
                border-collapse: collapse;
                width: 100%;
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
        <table id="cetakLaporan" width="100%">
            <thead>
                <tr>
                    <td style="word-break: break-word; font-weight: bold;">No</td>
                    <td style="word-break: break-word; font-weight: bold;">Nama Pelanggan</td>
                    <td style="word-break: break-word; font-weight: bold;">Alamat Pelanggan</td>
                    <td style="word-break: break-word; font-weight: bold;">No Telp Pelanggan</td>
                    <td style="word-break: break-word; font-weight: bold;">Kategori Jasa</td>
                    <td style="word-break: break-word; font-weight: bold;">Detail</td>
                    <td style="word-break: break-word; font-weight: bold;">Teknisi</td>
                    <td style="word-break: break-word; font-weight: bold;">Dimulai pada</td>
                    <td style="word-break: break-word; font-weight: bold;">Selesai pada</td>
                </tr>
            </thead>
            <tbody>
                @foreach($laporan as $data)
                    <tr>
                        <td style="word-break: break-word;">{{ $loop->index + 1 }}</td>
                        <td style="word-break: break-word;">{{ $data->pelanggan->nama }}</td>
                        <td style="word-break: break-word;">{{ $data->pelanggan->alamat }}</td>
                        <td style="word-break: break-word;">{{ $data->pelanggan->no_telp }}</td>
                        <td style="word-break: break-word;">{{ $data->kategorijasa->nama }}</td>
                        <td style="word-break: break-word;">{{ $data->detail }}</td>
                        <td style="word-break: break-word;">{{ $data->karyawan->name }}</td>
                        <td style="word-break: break-word;">{{ "Jam: " . $data->jam_mulai . ", Tanggal: ". $data->tanggal_mulai }}</td>
                        <td style="word-break: break-word;">{{ "Jam: " . $data->jam_selesai . ", Tanggal: ". $data->tanggal_selesai }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>