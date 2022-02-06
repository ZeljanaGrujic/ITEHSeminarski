

import React, { useEffect, useState } from 'react';
import ReactDOM from 'react-dom';
import FilterComponent from '../components/FilterComponent'
import BooksComponent from '../components/BooksComponent'
import { createBook, getAuthors, getBooks, getCategories, getLanguages } from '../../../api';
import Pagination from "react-js-pagination";

function CreateBookModal() {

    const [selects, setSelect] = useState({
        languages: [],
        categories: [],
        authors: [],
    })

    useEffect(() => {
        loadSelects()
    }, [])

    const loadSelects = async () => {
        const languages = (await getLanguages()).data.languages;
        const categories = (await getCategories()).data.categories;
        const authors = (await getAuthors()).data.authors;

        setSelect({
            languages,
            categories,
            authors,
        })
    }

    const createNewBook = async function (e) {
        e.preventDefault();

        const formdata = new FormData(document.getElementById('form-new-book'))

        formdata.append('authors', $('select[name="authors"]').val())
        const response = (await createBook(formdata)).data;
        $('#form-new-book')[0].reset();
        alert(response.message);
    }



    return (
        <div>
            <div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Dodavanje knjige</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form onSubmit={createNewBook} id="form-new-book">
                            <div class="modal-body">


                                <div class="mb-3">
                                    <label for="book_title" class="form-label">Naslov knjige</label>
                                    <input required type="text" class="form-control" name="book_title" id="book_title" aria-describedby="helpId" placeholder="" />
                                    <small id="helpId" class="form-text text-muted">Unesite Naslov knjige</small>
                                </div>

                                <div class="mb-3">
                                    <label for="book_description" class="form-label">Opis knjige</label>
                                    <input required type="text" class="form-control" name="book_description" id="book_description" aria-describedby="helpId" placeholder="" />
                                    <small id="helpId" class="form-text text-muted">Unesite opis knjige</small>
                                </div>

                                <div class="row">
                                    <div class="mb-3 col">
                                        <label for="book_page_count" class="form-label">Broj stranica</label>
                                        <input required type="number" class="form-control" name="book_page_count" id="book_page_count" aria-describedby="helpId" placeholder="" />
                                        <small id="helpId" class="form-text text-muted">Unesite broj stranica knjige</small>
                                    </div>

                                    <div class="mb-3 col">
                                        <label for="book_publish_year" class="form-label">Godina izdavanja</label>
                                        <input required type="number" class="form-control" name="book_publish_year" id="book_publish_year" aria-describedby="helpId" placeholder="" />
                                        <small id="helpId" class="form-text text-muted">Unesite godinu izdavanja</small>
                                    </div>

                                    <div class="mb-3 col">
                                        <label for="book_price" class="form-label">Cena</label>
                                        <input required type="number" class="form-control" name="book_price" id="book_price" aria-describedby="helpId" placeholder="" />
                                        <small id="helpId" class="form-text text-muted">Unesite cenu knjige</small>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="" class="form-label">Jezik</label>
                                    <select class="form-control" name="language_id" id="">
                                        {
                                            selects.languages.map((l) => {
                                                return <option value={l.id}>{l.language_name}</option>
                                            })
                                        }
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="" class="form-label">Kategorija</label>
                                    <select class="form-control" name="category_id" id="">
                                        {
                                            selects.categories.map((l) => {
                                                return <option value={l.id}>{l.category_name}</option>
                                            })
                                        }
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="" class="form-label">Autori</label>
                                    <select class="form-control" name="authors" multiple id="">
                                        {
                                            selects.authors.map((l) => {
                                                return <option value={l.id}>{l.author_name}</option>
                                            })
                                        }
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="book_picture" class="form-label">Slika knjige</label>
                                    <input required type="file" class="form-control" name="book_picture" id="book_picture" aria-describedby="helpId" placeholder="" />
                                    <small id="helpId" class="form-text text-muted">Dodajte sliku knjige</small>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Izadji</button>
                                <input type="submit" class="btn btn-primary" value="Napravi" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>




        </div>
    );
}

export default CreateBookModal;

