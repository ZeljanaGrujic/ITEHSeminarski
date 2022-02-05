import React, { useEffect, useState } from 'react';
import ReactDOM from 'react-dom';
import { getLanguages, getCategories, getAuthors } from '../../../api';

function Filter(props) {

    const [languages, setLanguages] = useState([]);
    const [categories, setCategories] = useState([]);
    const [authors, setAuthors] = useState([]);

    useEffect(() => {
        loadLanguages();
        loadCategories();
        loadAuthors();
    }, [])

    const loadLanguages = async () => {

        const languages = (await getLanguages()).data.languages;

        setLanguages([...languages]);
    }
    const loadCategories = async () => {

        const categories = (await getCategories()).data.categories;
        setCategories([...categories]);
    }

    const loadAuthors = async () => {

        const authors = (await getAuthors()).data.authors;
        setAuthors([...authors]);
    }

    return (
        <div className="filters-main h-100">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">Filteri</h2>
                    <h5 class="middle-line mt-4"><span>Jezici</span></h5>
                    {languages.map(l => {
                        return <div class="form-check">
                            <input onClick={(e) => { props.toggleFilter('languages', e.target.id) }} type="checkbox" class="form-check-input" name="" id={l.id} value="checkedValue" />
                            <label class="form-check-label" for="">
                                {l.language_name}
                            </label>
                        </div>
                    })}

                    <h5 class="middle-line mt-4"><span>Kategorije</span></h5>
                    {categories.map(l => {
                        return <div class="form-check">
                            <input onClick={(e) => { props.toggleFilter('categories', e.target.id) }} type="checkbox" class="form-check-input" name="" id={l.id} value="checkedValue" />
                            <label class="form-check-label" for="">
                                {l.category_name}
                            </label>
                        </div>
                    })}

                    <h5 class="middle-line mt-4"><span>Autori</span></h5>
                    {authors.map(l => {
                        return <div class="form-check">
                            <input onClick={(e) => { props.toggleFilter('authors', e.target.id) }} type="checkbox" class="form-check-input" name="" id={l.id} value="checkedValue" />
                            <label class="form-check-label" for="">
                                {l.author_name}
                            </label>
                        </div>
                    })}
                </div>
            </div>
        </div>
    );
}

export default Filter;

