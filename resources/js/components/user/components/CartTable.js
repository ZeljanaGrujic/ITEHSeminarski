import React, { useState } from 'react';
import ReactDOM from 'react-dom';
import { getBooks } from '../../../api';

function CartTable(props) {

    const [books, setBooks] = useState(props.books || [])

    const deleteBook = (e) => {

        const oldBooks = books;

        const newBooks = JSON.parse(sessionStorage.getItem('cartItems')).filter(book => book != e.target.id);


        setBooks(books => books.filter(b => b.id != e.target.id));
        sessionStorage.setItem('cartItems', JSON.stringify(newBooks));
    }
    return (
        <table class="table table-striped table-bordered table-hover table-inverse bg-bez table-primary table-responsive">
            <thead class="thead-inverse">
                <tr>
                    <th>Sifra</th>
                    <th>Naziv</th>
                    <th>Slika</th>
                    <th>Kolicina</th>
                    <th>Izbaci</th>
                </tr>
            </thead>
            <tbody>

                {books.map((book) => {
                    return <tr>
                        <td scope="row">{book.id}</td>
                        <td>{book.book_title}</td>
                        <td>
                            <img class="" height="100" src={book.book_image_path ? book.book_image_path : '/css/img/book-placeholder.png'} alt="" />
                        </td>
                        <td>
                            {book.quantity}
                        </td>
                        <td>
                            <button onClick={deleteBook} type="button" name="" id={book.id} class="btn btn-danger">X</button>
                        </td>
                    </tr>
                })}
            </tbody>
        </table>
    );
}

export default CartTable;

