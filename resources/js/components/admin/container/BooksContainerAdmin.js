import React, { useEffect, useState } from 'react';
import ReactDOM from 'react-dom';
import FilterComponent from '../components/FilterComponent'
import BooksComponent from '../components/BooksComponent'
import { deleteBook, getBooks } from '../../../api';
import Pagination from "react-js-pagination";
import CreateBookModal from '../modal/CreateBookModal';
import CreateAuthorModal from '../modal/CreateAuthorModal';

function BooksContainerAdmin() {
    const [booksPagination, setBooksPagination] = useState({
        data: []
    });

    const [filters, setFilters] = useState([]);

    useEffect(() => {
        loadBooks();
    }, [])

    const loadBooks = async (pageNumber, filters = null) => {

        const books = (await getBooks(pageNumber, filters)).data.books
        setBooksPagination({ ...books });
    }

    const handleDeleteBook = async (bookToDelete) => {

        deleteBook(bookToDelete).then(res => {alert(res.data.message); loadBooks()});

        const newBooks = booksPagination.data.filter(book => book.id != bookToDelete.id)

        setBooksPagination(booksPagination => {
            return {
                ...booksPagination,
                data: newBooks
            }
        })
    }

    const handleAddFilter = (type, value) => {

        const filter = `${type}[]=${value}`;
        if (filters.includes(filter)) {

            setFilters([...filters.filter(existingFilter => existingFilter !== filter)])
            loadBooks(booksPagination.current_page, [...filters.filter(existingFilter => existingFilter !== filter)]);
        }
        else {
            setFilters([...filters, filter])
            loadBooks(booksPagination.current_page, [...filters, filter]);
        }

    }

    return (
        <div className='d-flex h-100'>
            <div className='col h-100'>
                <FilterComponent
                    toggleFilter={handleAddFilter}
                />
            </div>
            <div className='bg-books h-100 col-9 h-100' style={{ minHeight: '150vh' }}>
                <BooksComponent deleteBook={handleDeleteBook} books={booksPagination.data} />
                <span className='d-flex justify-content-center'>
                    <Pagination

                        activePage={booksPagination?.current_page ? booksPagination?.current_page : 0}
                        itemsCountPerPage={booksPagination?.per_page ? booksPagination?.per_page : 0}
                        totalItemsCount={booksPagination?.total ? booksPagination?.total : 0}
                        onChange={(pageNumber) => {
                            loadBooks(pageNumber)
                        }}
                        pageRangeDisplayed={8}
                        itemClass="page-item"
                        linkClass="page-link bg-teget"
                    />
                </span>
            </div>

            <div class="dropdown open">
                <button class="btn btn-success dropdown-togglee" type="button" id="new-book-btn" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <i class="fas fa-plus-circle" style={{ fontSize: '4rem' }} ></i>
                </button>
                <div class="dropdown-menu" aria-labelledby="triggerId">
                    <div class="d-grid gap-2">
                        <button type="button" name="" id="" data-bs-toggle="modal" data-bs-target="#modelId" class="btn btn-success">
                            Nova knjiga

                        </button>
                    </div>
                    <div class="d-grid gap-2 mt-2">
                        <button type="button" name="" id="" data-bs-toggle="modal" data-bs-target="#modelId2" class="btn btn-success">
                            Novi autor

                        </button>
                    </div>

                </div>
            </div>

            <CreateBookModal />
            <CreateAuthorModal />
        </div>
    );
}

export default BooksContainerAdmin;

if (document.getElementById('books-container-admin')) {
    ReactDOM.render(<BooksContainerAdmin />, document.getElementById('books-container-admin'));
}
