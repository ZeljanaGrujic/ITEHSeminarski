import React, { useEffect, useState } from 'react';
import ReactDOM from 'react-dom';
import FilterComponent from '../components/FilterComponent'
import BooksComponent from '../components/BooksComponent'
import { createOrder, getBooksByIds } from '../../../api';
import Pagination from "react-js-pagination";
import CartTable from '../components/CartTable';

function CartContainer() {
    const [books, setBooks] = useState([]);

    useEffect(() => {
        loadBooks();
    }, [])

    const loadBooks = async () => {

        const cartItems = JSON.parse(sessionStorage.getItem('cartItems'));
        const books = (await getBooksByIds(JSON.parse(sessionStorage.getItem('cartItems')))).data.books

        books.forEach(book => {
            book.quantity = 0;
        })

        cartItems.forEach(ci => {

            books.forEach(book => {

                if (book.id == ci) {

                    book.quantity += 1;
                }
            })

        })
        setBooks([...books]);
    }

    const createOrder2 = () => {

        const sessionBooks = [...new Set(JSON.parse(sessionStorage.getItem('cartItems')))];
        const books = [];

        const cartItems = JSON.parse(sessionStorage.getItem('cartItems'));
        sessionBooks.forEach(book => {
            books.push({
                id: book,
                quantity: 0
            })
        })

        cartItems.forEach(ci => {

            books.forEach(book => {

                if (book.id == ci) {

                    book.quantity += 1;
                }
            })

        })
        createOrder(books).then(res => {alert(res.data.message); sessionStorage.setItem('cartItems', '[]')});
    }

    return (
        <div className='bg-teget cl-bez p-5 cart-items rounded h-75 mx-auto mt-5 w-75'>
            <h2>Vasa korpa:</h2>
            {books.length ? <CartTable books={books} /> : <h3>Vasa korpa je prazna...</h3>}
            <div class="d-grid gap-2">
                <button type="button" name="" onClick={() => createOrder2()} id="" className="btn btn-success sticky-top">Naruci</button>
            </div>
        </div >
    );
}

export default CartContainer;

if (document.getElementById('cart-container')) {
    ReactDOM.render(<CartContainer />, document.getElementById('cart-container'));
}
