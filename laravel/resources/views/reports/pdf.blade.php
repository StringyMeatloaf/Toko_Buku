<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <style>

        body {
            font-family: DejaVu Sans;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
        }

        th {
            background: #eeeeee;
        }

        h2 {
            text-align: center;
        }

    </style>

</head>
<body>

    <h2>
        Laporan Inventaris Buku
    </h2>

    <table>

        <thead>

            <tr>

                <th>Tanggal</th>
                <th>ISBN</th>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Jenis</th>
                <th>Jumlah</th>
                <th>Stok</th>

            </tr>

        </thead>

        <tbody>

            @foreach($reports as $report)

            <tr>

                <td>
                    {{ $report['date'] }}
                </td>

                <td>
                    {{ $report['isbn'] }}
                </td>

                <td>
                    {{ $report['title'] }}
                </td>

                <td>
                    {{ $report['category'] }}
                </td>

                <td>
                    {{ $report['type'] }}
                </td>

                <td>
                    {{ $report['quantity'] }}
                </td>

                <td>
                    {{ $report['stock'] }}
                </td>

            </tr>

            @endforeach

        </tbody>

    </table>

</body>
</html>