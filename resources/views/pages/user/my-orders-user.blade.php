@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <table id="datatable" class="table table-bordered table-striped ">
            <thead>
                <tr>
                    <th width="10%">Id porudzbine</th>
                    <th width="10%">Datum i vreme</th>
                    <th width="20%">Ukupna cena</th>
                    <th width="20%">Broj knjiga</th>
                    <th width="20%">Status porudzbine</th>
                    <th width="10%">Akcija</th>
                </tr>
            </thead>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            loadDataTable();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            function humanizeDate(date_str) {
                month = ['Januar', 'Feburar', 'Mart', 'April', 'Maj', 'Jun', 'Jul', 'Avgust', 'Septembar',
                    'Oktobar', 'Novembar', 'Decembar'
                ];

                date_arr = date_str.split('-');
                return month[Number(date_arr[1]) - 1] + " " + date_arr[2].split('T')[0] + ", " + date_arr[0]
            }
            function loadDataTable() {
                $('#datatable').dataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "http://127.0.0.1:8000/api/my-orders"
                    },
                    columns: [{
                            data: 'id',
                            name: 'id'
                        },
                        {
                            data: 'created_at',
                            name: 'created_at',
                            render: function(data, type, row, meta) {

                                return humanizeDate(data);
                            }
                        },
                        {
                            data: 'books',
                            name: 'price',
                            render: function(data, type, row, meta) {

                                let prices = 0;
                                data.forEach(element => {
                                    prices += element.book_price * element.pivot.quantity;
                                });

                                return prices;
                            }
                        },
                        {
                            data: 'books',
                            name: 'broj_knjiga',
                            render: function(data, type, row, meta) {
                                let prices = 0;
                                data.forEach(element => {
                                    prices += element.pivot.quantity;
                                });

                                return prices;
                            }
                        },
                        {
                            data: 'order_status.order_status_name',
                            name: 'order_stat,us'
                        },
                        {
                            data: 'id',
                            name: 'id-link',
                            render: function(data, type, row, meta) {
                                return `<a href="/porudzbina/${data}" >
                                    <i class="fas fa-eye"></i>
                                    </a>`
                            }
                        },
                    ]
                })
            }

        });
    </script>
@endsection
