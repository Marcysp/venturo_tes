<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TES - Venturo Camp Tahap 2</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
        table {
            font-size: 11px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="card" style="margin: 2rem 0rem;">
            <div class="card-header">
                Venturo - Laporan penjualan tahunan per menu
            </div>
            <div class="card-body">
                <form action="" method="get">
                    @csrf
                    <div class="row">
                        <div class="col-2">
                            <div class="form-group">
                                <select id="my-select" class="form-control" name="tahun">
                                    <option value="" @if($tahun == null) selected @endif>Pilih Tahun</option>
                                    <option value="2021" @if($tahun == 2021) selected @endif>2021</option>
                                    <option value="2022" @if($tahun == 2022) selected @endif>2022</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <button type="submit" class="btn btn-primary">Tampilkan</button>
                            @if ($tahun != null)
                                <a href="http://tes-web.landa.id/intermediate/menu" target="_blank" title="JSON Menu" class="btn btn-secondary">Json Menu</a>
                                <a href="http://tes-web.landa.id/intermediate/transaksi?tahun={{ $tahun }}" target="_blank" title="JSON Transaksi" class="btn btn-secondary">Json Transaksi</a>
                                <a href="#" class="btn btn-secondary">Download Example</a>
                            @endif
                        </div>
                    </div>
                </form>
                <hr>
                @if ($tahun != null)
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" style="margin: 0;">
                        <thead>
                            <tr class="table-dark">
                                <th rowspan="2" style="text-align:center;vertical-align: middle;width: 250px;">Menu</th>
                                <th colspan="12" style="text-align: center">Periode Pada {{ $tahun }}</th>
                                <th rowspan="2" style="text-align:center;vertical-align: middle;width: 75px;">Total</th>
                            </tr>
                            <tr class="table-dark">
                                @foreach (range(1, 12) as $month)
                                    <th style="text-align: center;width: 75px;">{{ date('M', mktime(0, 0, 0, $month, 1)) }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (['makanan', 'minuman'] as $kategori)
                                <tr>
                                    <td class="table-secondary" colspan="14"><b>{{ ucfirst($kategori) }}</b></td>
                                </tr>
                                @foreach ($menu as $m)
                                    @if ($m['kategori'] == $kategori)
                                        <tr>
                                            <td>{{ $m['menu'] }}</td>
                                            @foreach (range(1, 12) as $month)
                                                <td style="text-align: right;">
                                                    @if (isset($totalPerMenu[$month][$m['menu']]))
                                                        {{ number_format($totalPerMenu[$month][$m['menu']]) }}
                                                    @endif
                                                </td>
                                            @endforeach
                                            <td style="text-align: right;"><b>{{ number_format(array_sum(array_column($totalPerMenu, $m['menu']))) }}</b></td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endforeach
                            <tr class="table-dark">
                                <td><b>Total</b></td>
                                @php
                                    $totalPendapatan = 0;
                                @endphp
                                @foreach (range(1, 12) as $month)
                                    <td style="text-align: right;">
                                        <b>
                                            @if (isset($totalMenuPerBulan[$month]))
                                                {{ number_format($totalMenuPerBulan[$month]) }}
                                                @php
                                                    $totalPendapatan += $totalMenuPerBulan[$month];
                                                @endphp
                                            @endif
                                        </b>
                                    </td>
                                @endforeach
                                <td style="text-align: right;"><b>{{ number_format($totalPendapatan) }}</b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
