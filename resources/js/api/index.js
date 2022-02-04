import axios from "axios";


export async function getBooks(pageNumber = 1, filters) {
    if (filters)
        return axios.get('/api/books?page=' + pageNumber + '&' + filters?.join('&'));
    return axios.get('/api/books?page=' + pageNumber);
}

export async function getLanguages() {
    return axios.get('/api/languages');
}

export async function getCategories() {
    return axios.get('/api/categories');
}

export async function getAuthors() {
    return axios.get('/api/authors');
}

export async function getBooksByIds(ids) {
    const query = ids.map((id) => {

        return `ids[]=${id}`
    }).join('&');
    return axios.get(`/api/books-by-ids?${query}`)
}

export async function createOrder(books) {

    return axios.post(`/api/orders`, { books: books })
}

export async function createBook(formData) {


    return axios.post(`/api/admin/books`, formData)
}

export async function deleteBook(book) {


    return axios.delete(`/api/admin/books/` + book.id)
}

export async function createAuthor(formData) {


    return axios.post(`/api/admin/author`, formData)
}
