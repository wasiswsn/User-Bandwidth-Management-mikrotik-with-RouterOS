@extends('layout.master')
@section('title','Gmedia.Net - Dashboard')
@section('content')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Dashboard</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card bg-info text-black bg-gradient mb-4">
                            <div class="card-body">
                                <h4 class="card-title">Router Information</h4>
                                <div class="numbers">
                                    <p class="card-category">| CPU Load: <span id="cpu"></span></p>
                                    <p class="card-category">| UP Time: <span id="uptime"></span></p>
                                    <p class="card-category">| RAM: {{ formatBytes($freememory) }}</p>
                                    <p class="card-category">| Storage: {{ formatBytes($freehdd) }}</p>
                                    <p class="card-category">| Model: {{ $model }}</p>
                                    <p class="card-category">| Board: {{ $boardname }}</p>
                                    <p class="card-category">| OS: {{ $version }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-primary text-white bg-gradient mb-4">
                            <div class="card-body"> <i class="fa-solid fa-ticket"></i> &nbsp; Total Voucher : <?= $totalhotspotuser ?></div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="{{ route('voucher') }}">Voucher</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                    @if(Auth::check() && Auth::user()->level == 'admin')
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-warning text-white bg-gradient mb-4">
                            <div class="card-body"><i class="fas fa-globe"></i> &nbsp; Total Voucher Profile : <?= $totalhotspotprofile ?></div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="{{ route('profile') }}">Voucher Profile</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-success text-white bg-gradient mb-4">
                            <div class="card-body"><i class="fas fa-coins"></i> &nbsp; Rp {{ number_format($totalPrice, 0, ',' , '.') }}</div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="{{ route('transaksi') }}">Penjualan Voucher</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-success text-white bg-gradient mb-4">
                            <div class="card-body"><i class="fas fa-coins"></i> &nbsp; Rp {{ number_format($total, 0, ',' , '.') }} </div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="{{ route('keranjang') }}">Pembelian Mitra</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        @include('layout.footer')
    </div>

    <script type="text/javascript">
        setInterval('cpu();', 1000);
        function cpu() {
            $('#cpu').load('{{ route('dashboard.cpu') }}')
        }

        setInterval('uptime();', 1000);
        function uptime() {
            $('#uptime').load('{{ route('dashboard.uptime') }}')
        }

        <?php
        function formatBytes($bytes, $decimal = null)
        {
            $satuan = ['Bytes', 'Kb', 'Mb', 'Gb', 'Tb'];
            $i = 0;
            while ($bytes > 1024) {
                $bytes /= 1024;
                $i++;
            }
            return round($bytes, $decimal) . '' . $satuan[$i];
        }
        ?>
    </script>
@endsection
