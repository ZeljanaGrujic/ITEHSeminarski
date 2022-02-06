

import React, { useEffect, useState } from 'react';
import ReactDOM from 'react-dom';
import FilterComponent from '../components/FilterComponent'
import BooksComponent from '../components/BooksComponent'
import { createAuthor, createBook, getAuthors, getBooks, getCategories, getLanguages } from '../../../api';
import Pagination from "react-js-pagination";

function CreateAuthorModal() {

    const createNewAuthor = async function (e) {
        e.preventDefault();

        const formdata = new FormData(document.getElementById('form-new-author'))
        const response = (await createAuthor(formdata)).data;
        $('#form-new-author')[0].reset();
        alert(response.message);
    }

    return (
        <div>
            <div class="modal fade" id="modelId2" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Dodavanje autora</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form onSubmit={createNewAuthor} id="form-new-author">
                            <div class="modal-body">


                                <div class="mb-3">
                                    <label for="author_name" class="form-label">Ime autora</label>
                                    <input required type="text" class="form-control" name="author_name" id="author_name" aria-describedby="helpId" placeholder="" />
                                    <small id="helpId" class="form-text text-muted">Unesite ime autora</small>
                                </div>

                                <div class="mb-3">
                                    <label for="author_description" class="form-label">Opis autora</label>
                                    <input required type="text" class="form-control" name="author_description" id="author_description" aria-describedby="helpId" placeholder="" />
                                    <small id="helpId" class="form-text text-muted">Unesite opis autora</small>
                                </div>

                                <div class="row">
                                    <div class="mb-3 col">
                                        <label for="author_year_of_birth" class="form-label">Godina rodjenja</label>
                                        <input required type="number" class="form-control" name="author_year_of_birth" id="author_year_of_birth" aria-describedby="helpId" placeholder="" />
                                        <small id="helpId" class="form-text text-muted">Unesite godinu rodjenja</small>
                                    </div>

                                    <div class="mb-3 col">
                                        <label for="author_year_of_death" class="form-label">Godina smrti</label>
                                        <input required type="number" class="form-control" name="author_year_of_death" id="author_year_of_death" aria-describedby="helpId" placeholder="" />
                                        <small id="helpId" class="form-text text-muted">Unesite godinu smrti (unesite 0 ako je autor ziv)</small>
                                    </div>
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

export default CreateAuthorModal;

