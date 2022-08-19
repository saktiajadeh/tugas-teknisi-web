<style>
    #cetakLaporan {
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
        font-size: 13px;
    }

    #cetakLaporan td,
    #cetakLaporan th {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #cetakLaporan tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    #cetakLaporan tr:hover {
        background-color: #ddd;
    }

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
                    <img src="{{ asset('/img/icon-logo.png') }}"
                        style="width: 80px; height: 80px;object-fit: contain;">
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
    <h4 align="left">Laporan Statistik Tugas Teknisi&nbsp;{{ $rangeTanggal }}</h4>
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
                    <td style="word-break: break-word; font-weight: bold;">Nama Teknisi</td>
                    <td style="word-break: break-word; font-weight: bold;">No Telp</td>
                    <td style="word-break: break-word; font-weight: bold;">Belum Dikerjakan</td>
                    <td style="word-break: break-word; font-weight: bold;">Sedang Dikerjakan</td>
                    <td style="word-break: break-word; font-weight: bold;">Selesai Dikerjakan</td>
                    <td style="word-break: break-word; font-weight: bold;">Total Tugas</td>
                </tr>
            @endif
        </thead>
        <tbody>
            @foreach($laporan as $data)
                <tr>
                    <td style="word-break: break-word;">{{ $loop->index + 1 }}</td>
                    <td style="word-break: break-word;">{{ $data->name }}</td>
                    <td style="word-break: break-word;">{{ $data->no_telp }}</td>
                    <td style="word-break: break-word;">{{ ($data->tugasteknisinostatus_count + $data->tugasteknisinostatus2_count) }}</td>
                    <td style="word-break: break-word;">{{ ($data->tugasteknisiprogress_count + $data->tugasteknisiprogress2_count) }}</td>
                    <td style="word-break: break-word;">{{ ($data->tugasteknisiselesai_count + $data->tugasteknisiselesai2_count) }}</td>
                    <td style="word-break: break-word;">{{ ($data->tugasteknisitotal_count + $data->tugasteknisitotal2_count) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
