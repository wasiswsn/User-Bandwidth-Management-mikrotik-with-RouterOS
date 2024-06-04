@extends('layout.master')
@section('title','Gmedia.Net - Dashboard')
@section('content')

<script type="text/javascript" src="{{ asset('template-dashboard') }}/js/jquery-3.6.0.min.js"></script>
  <script type="text/javascript" src="{{ asset('/') }}highchart/js/highcharts.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/css/bootstrap.min.css" integrity="sha384-VCmXjywReHh4PwowAiWNagnWcLhlEJLA5buUprzK8rxFgeH0kww/aWY76TfkUoSX" crossorigin="anonymous">


<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">INTERFACE</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Interface</li>
            </ol>
            <div class="container">
                <button type="button" class="btn btn-primary btn-sm mt-2">
                    <span class="spinner-grow spinner-grow-sm"></span>
                    Data Realtime
                </button>
            </div>
            <div class="col-md-12 mt-2">
                <div class="card mt-2">
                    <div id="graph"></div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>Interface</th>
                            <th>UPLOAD (TX)</th>
                            <th>DOWNLOAD (RX)</th>
                        </tr>
                        <tr>
                            <td>
                                <select class="form-control form-control" name="interface" id="interface">
                                    @foreach($interface as $data)
                                        <option value="{{ $data['name'] }}">{{ $data['name'] }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <div id="tabletx"></div>
                            </td>
                            <td>
                                <div id="tablerx"></div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </main>
    @include('layout.footer')
</div>

<script>
    $('#select').on('change', function(e) {
        var optionSelected = $("option:selected", this);
        var valueSelected = this.value;
        console.clear();
        encodeURIComponent($("#interface").val(valueSelected));
    });
    var chart;

    function requestDatta(interface) {
        var interfaceValue = $('#interface').val()
        var traffic = encodeURIComponent(interfaceValue);
        $.ajax({
            url: '{{ url('dashboard-special') }}' + '/' + traffic,
            datatype: "json",
            success: function(data) {
                var midata = data;
                if (Object.keys(midata).length > 0) {
                    console.log(midata.tx);
                    var TX = parseInt(midata.tx);
                    var RX = parseInt(midata.rx);
                    var x = (new Date()).getTime();
                    shift = chart.series[0].data.length > 19;
                    chart.series[0].addPoint([x, TX], true, shift);
                    chart.series[1].addPoint([x, RX], true, shift);
                    document.getElementById("tabletx").innerHTML = convert(TX);
                    document.getElementById("tablerx").innerHTML = convert(RX);
                } else {
                    document.getElementById("tabletx").innerHTML = "0";
                    document.getElementById("tablerx").innerHTML = "0";
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                console.error("Status: " + textStatus + " request: " + XMLHttpRequest);
                console.error("Error: " + errorThrown);
            }
        });
    }

    $(document).ready(function() {
        Highcharts.setOptions({
            global: {
                useUTC: false
            }
        });
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'graph',
                animation: Highcharts.svg,
                type: 'spline',
                events: {
                    load: function() {
                        setInterval(function() {
                            requestDatta(document.getElementById("interface").value);
                        }, 1000);
                    }
                }
            },
            title: {
                text: 'Monitoring'
            },
            xAxis: {
                type: 'datetime',
                tickPixelInterval: 150,
                maxZoom: 20 * 1000
            },

            yAxis: {
                minPadding: 0.2,
                maxPadding: 0.2,
                title: {
                    text: 'Traffic'
                },
                labels: {
                    formatter: function() {
                        var bytes = this.value;
                        var sizes = ['bps', 'kbps', 'Mbps', 'Gbps', 'Tbps'];
                        if (bytes == 0) return '0 bps';
                        var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
                        return parseFloat((bytes / Math.pow(1024, i)).toFixed(2)) + ' ' + sizes[i];
                    },
                },
            },
            series: [{
                name: 'TX',
                data: []
            }, {
                name: 'RX',
                data: []
            }],
            tooltip: {
                headerFormat: '<b>{series.name}</b><br/>',
                pointFormat: '{point.x:%Y-%m-%d %H:%M:%S}<br/>{point.y}'
            },


        });
    });

    function convert(bytes) {
        var sizes = ['bps', 'kbps', 'Mbps', 'Gbps', 'Tbps'];
        if (bytes == 0) return '0 bps';
        var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
        return parseFloat((bytes / Math.pow(1024, i)).toFixed(2)) + ' ' + sizes[i];
    }
</script>


@endsection
