import React, { useEffect, useState } from 'react';
import ReactDOM from 'react-dom';
import FilterComponent from '../components/FilterComponent'
import BooksComponent from '../components/BooksComponent'
import { getBooks } from '../../../api';
import Pagination from "react-js-pagination";

function BooksContainer() {
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
            <div className=' bg-books h-100 col-9' style={{ minHeight: '150vh' }}>
                <BooksComponent books={booksPagination.data} />
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
        </div>
    );
}

export default BooksContainer;

if (document.getElementById('books-container')) {
    ReactDOM.render(<BooksContainer />, document.getElementById('books-container'));
}
