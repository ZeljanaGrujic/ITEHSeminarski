import React from 'react';
import ReactDOM from 'react-dom';
import { getBooks } from '../../../api';

function BookComponent({ book }) {

    return (
        <div class="card p-2 bg-default">
            <img class="card-img-top" height="" src={book.book_image_path ? book.book_image_path : '/css/img/book-placeholder.png'} alt="" />
            <div class="card-body">
                <h4 class="card-title">{book.book_title}</h4>
                <p class="card-text book-description">{book.book_description}</p>
                <div class="d-grid gap-2">
                  <button type="button" onClick={() => location.href = `/knjiga/${book.id}`} name="" id="" class="btn btn-teget cl-bez">Više...</button>
                </div>
            </div>
        </div>
    );
}

export default BookComponent;

