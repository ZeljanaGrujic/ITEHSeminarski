import React from 'react';
import ReactDOM from 'react-dom';
import { getBooks } from '../../../api';
import BookComponent from './BookComponent';

function BooksComponent(props) {

    console.log(props.books);
    return (
        <div className="h-100">
            <div className='row w-100 m-0'>
                {props.books ? props.books.map(book => {


                    return <div className='col-4 d-flex justify-content-center p-4'>
                        <div className='col-10'>
                            <BookComponent book={book} />
                        </div>
                    </div>
                }) : ''}
            </div>
        </div>
    );
}

export default BooksComponent;

