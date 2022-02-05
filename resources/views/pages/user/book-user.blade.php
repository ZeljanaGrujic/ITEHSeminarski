@extends('layouts.app')

<link rel="stylesheet" href="{{ asset('css/book.css') }}">
@section('content')

    <div class="w-100 h-100 d-flex justify-content-center align-items-center">


        <div class="container p-5 bg-teget d-flex rounded" style="position: relative">

            <div style="position: absolute; top: 0; left:5px">


                <button class="btn p-0 icon-btn" data-bs-toggle="modal" data-bs-target="#statistikaModal">
                    <span class="badge bg-secondary">

                        {{-- Statistika --}}
                        <i class="fas fa-chart-line "></i>
                    </span>
                </button>

                <button class="btn p-0 icon-btn" data-bs-toggle="modal" data-bs-target="#qrCodeModal">
                    <span class="badge bg-secondary">

                        {{-- QR Kod --}}
                        <i class="fa fa-qrcode" aria-hidden="true"></i>
                    </span>
                </button>

                <button class="btn p-0 icon-btn" data-bs-toggle="modal" data-bs-target="#currencyModal">
                    <span class="badge bg-secondary">

                        {{-- Exchange --}}
                        <i class="fas fa-euro-sign"></i>
                    </span>
                </button>


            </div>
            <div class="col-4 d-flex justify-content-center">

                <img src="{{ $book->book_image_path ? "/storage/$book->book_image_path" : '/css/img/book-placeholder.png' }}"
                    alt="">
            </div>

            <div class="col-8">

                <h2 class="cl-bez" align="center">{{ $book->book_title }}</h2>
                <i>
                    <h6 class="cl-narandzasta" align="center">Autori:
                        {{ count($book->authors)? implode(', ', array_column($book->authors->toArray(), 'author_name')): 'Nepoznati autori' }}
                    </h6>
                </i>
                <i>
                    <p class="cl-bez">
                        Datum izdavanja: {{ $book->book_publish_year }}
                        <br>
                        Broj strana: {{ $book->book_page_count }}
                        <br>
                        Cena: {{ $book->book_price }} RSD
                    </p>
                </i>
                <p class="cl-bez">
                    {{ $book->book_description }}
                </p>


                <div class="d-grid gap-2">
                    <button type="button" name="" id="{{ $book->id }}" class="btn btn-narandzasta toCart">Dodaj u korpu</button>
                </div>
            </div>
        </div>
    </div>

    @if (Auth::check())

        <div class="success-toast position-fixed top-0 mt-5 shadow-lg p-3 mb-5 start-50 translate-middle p-3 hide  toast align-items-center text-white bg-success border-0"
            data-delay="3000" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">

                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    @else

        <div class="success-toast position-fixed top-0 mt-5 shadow-lg p-3 mb-5 start-50 translate-middle p-3 hide  toast align-items-center text-white bg-success border-0"
            data-delay="7000" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div>
                    <div class="toast-body">

                    </div>
                    <div class="d-grid gap-2">
                        Niste prijavljeni, da biste videli korpu -
                        <button type="button" name="" id="" onclick="location.href='/login'" class="btn btn-primary">Prijavi
                            se</button>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    @endif

    {{-- ---------------------------------- Statistika -------------------------------- --}}

    <div class="modal fade" id="statistikaModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Prodaje ovog proizvoda</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="curve_chart" data-orders="{{ json_encode($book->orders) }}"
                        style="width: 900px; height: 500px"></div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="qrCodeModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">QR Kod </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex justify-content-center align-items-center">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data={{ url()->current() }}"
                        alt="" srcset="">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="currencyModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cena u drugim valutama</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="show-other-currencies" data-price={{ $book->book_price }} class="modal-body">

                </div>
            </div>
        </div>
    </div>



    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        const orders = $('#curve_chart').data('orders');

        orders.forEach(o => {

            o.formattedDate = `0${new Date(o.created_at).getMonth() + 1}.${new Date(o.created_at).getDate()}`
            o.quantity = 0;
        })


        let counts = {};
        for (const o of orders) {


            counts[o.formattedDate] = counts[o.formattedDate] ? counts[o.formattedDate] + 1 : 1;
        }
        // const formattedArray = counts.map(c => ([c.formattedDate, c.]))

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Dan', 'Broj prodaja'],
                ...Object.entries(counts)
            ]);
            console.log('test')
            var options = {
                title: 'Prodaja knjige',
                curveType: 'function',
                legend: {
                    position: 'bottom'
                }
            };

            var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

            chart.draw(data, options);
        }
    </script>

    <script>
        $.ajax({
            type: "GET",
            url: "https://api.exchangerate.host/latest?base=RSD",
            dataType: "JSON",
            success: function(response) {
                const rates = response.rates;
                Object.entries(rates).forEach(rate => {
                    $('#show-other-currencies').append(
                        `
                    <h6><b>${rate[0]}</b>: ${Math.round(rate[1] * $('#show-other-currencies').data('price') * 100)/100 }</h6>
                    <br />
                    `
                    );
                })
            }

        });
    </script>

@endsection
