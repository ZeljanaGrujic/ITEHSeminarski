@extends('layouts.app')

@section('content')
    <div class="bg-books">
        <div class="container bg-default ">
            <table id="datatable" class="table table-bordered table-striped ">
                <thead>
                    <tr>
                        <th width="10%">Id porudzbine</th>
                        <th width="10%">Korisnik</th>
                        <th width="10%">Datum i vreme</th>
                        <th width="20%">Ukupna cena</th>
                        <th width="20%">Broj knjiga</th>
                        <th width="10%">Status porudzbine</th>
                        <th width="10%">Akcija</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>


    <div class="success-toast position-fixed top-0 mt-5 shadow-lg p-3 mb-5 start-50 translate-middle p-3 hide  toast align-items-center text-white bg-success border-0"
        data-delay="3000" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">

            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                aria-label="Close"></button>
        </div>
    </div>

    <script>
        $(document).ready(function() {

            let orderStatuses = [];

            getOrderStatuses();
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

            function getOrderStatuses() {
                $.ajax({
                    type: "GET",
                    url: "http://127.0.0.1:8000/api/order-statuses",
                    dataType: "JSON",
                    success: function(response) {
                        orderStatuses = response.statuses || [];
                    }
                });
            }

            function loadDataTable() {
                $('#datatable').dataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "http://127.0.0.1:8000/api/admin/orders"
                    },
                    columns: [{
                            data: 'id',
                            name: 'id'
                        },
                        {
                            data: 'user.name',
                            name: 'user'
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
                            defaultContent: '<b>Nije dodeljen</b>',
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
                            name: 'order_status',
                            render: function(data, type, row, meta) {
                                console.log(orderStatuses)
                                const options = orderStatuses.map(os => {

                                    return `<option ${os.order_status_name === data ? ' selected' : ''} value="${os.id}">${os.order_status_name}</option>`
                                })
                                console.log(options.join(''))
                                return `<div class="mb-3">
                                    <label for="" class="form-label"></label>
                                    <select class="form-select order-status-select" id="${row['id']}">
                                        ${options.join('')}
                                    </select>
                                </div>`
                            }
                        },
                        {
                            data: 'id',
                            name: 'id-link',
                            render: function(data, type, row, meta) {
                                return `<a class="mx-autocomplete" href="/porudzbina/${data}" >
                                    <i class="fas fa-eye"></i>
                                    </a>`
                            }
                        },
                    ]
                })
            }

        });

        $('body').on('change', '.order-status-select', function(e) {
            e.preventDefault();


            $.ajax({
                type: "PUT",
                url: "http://127.0.0.1:8000/api/admin/orders/" + e.target.id,
                data: {
                    order_status_id: $(this).val()
                },
                dataType: "JSON",
                success: function(response) {
                    successToast(response.message);
                },
            });

        });


        const successToast = (message) => {

            $('.success-toast .toast-body').html(message);
            $('.success-toast').toast('show');
        };
    </script>
@endsection
