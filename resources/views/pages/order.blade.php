@extends('layouts.app')


<link rel="stylesheet" href="{{ asset('css/book.css') }}">
@section('content')

    <div class='bg-teget p-5 cl-bez p-5 cart-items rounded h-75 mx-auto mt-5 w-75'>

        <h4>Informacije o porudzbini</h4>
        <table class="table cl-bez">

            <tbody>
                <tr>
                    <th>Ime i prezime</th>
                    <td>{{ $order->user->name }}</td>
                </tr>
                <tr>
                    <th>Drzava</th>
                    <td>{{ $order->user->state }}</td>
                </tr>
                <tr>
                    <th>Opstina</th>
                    <td>{{ $order->user->town }}</td>
                </tr>
                <tr>
                    <th>Adresa</th>
                    <td>{{ $order->user->address }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{ $order->orderStatus->order_status_name }}</td>
                </tr>
            </tbody>
        </table>


        <div class="container mt-5">
            <table
                class="table table-striped table-bordered table-hover table-inverse bg-bez table-primary table-responsive">
                <thead class="thead-inverse">
                    <tr>
                        <th>Sifra</th>
                        <th>Naziv</th>
                        <th>Slika</th>
                        <th>Kolicina</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($books as $book)

                        <tr>
                            <td scope="row">{{ $book->id }}</td>
                            <td>{{ $book->book_title }}</td>
                            <td>
                                <img class="" height="100"
                                    src={{ $book->image_path ? $book->image_path : '/css/img/book-placeholder.png' }}
                                    alt="" />
                            </td>
                            <td>{{ $book->pivot->quantity }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
