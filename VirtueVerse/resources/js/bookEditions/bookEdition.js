import axios from 'axios';
import { spaceEncoder, parseDateString, parsePublishYear } from '../shared/regexHelper';

const bookQueryInput = document.getElementById('book-search-query');
const bookQueryResults = document.getElementById('book-search-results');
const bookEditionQueryInput = document.getElementById('book-edition-search-query');
const bookEditionQueryResults = document.getElementById('book-edition-search-results');
let retrievedBooks;
let retrievedBookEditions;
let timeoutId = null;

document.addEventListener('DOMContentLoaded', function () {
    setBookEditionSearchStatus();
    addSearchEventListener(bookQueryInput, bookQueryResults, handleBookInput);
    addSearchEventListener(bookEditionQueryInput, bookEditionQueryResults, handleBookEditionInput);
});

async function handleBookEditionInput(query) {
    retrievedBookEditions = await searchBookEditions(query);
    displayBookEditionSearchResults(retrievedBookEditions);
}

async function handleBookInput(query) {
    retrievedBooks = await searchStoredBooks(query);
    displaySearchResults(retrievedBooks);
}

function addSearchEventListener(inputElement, resultsElement, callback) {
    inputElement.addEventListener('input', async function () {
        const query = inputElement.value;

        clearTimeout(timeoutId); // Clear any previous pending requests
        resultsElement.innerHTML = '';

        if (query.length >= 3) {
            timeoutId = setTimeout(async function() {
                try {
                    callback(query);
                } catch (error) {
                    console.error('Error:', error);
                }
            }, 1000);
        } else {
            resultsElement.innerHTML = '';
        }
    });
}

async function displaySearchResults(results) {
    results.forEach(function (result) {
        const listItem = document.createElement('li');
        listItem.classList.add('p-2', 'border-b', 'hover:bg-gray-100', 'cursor-pointer');

        listItem.dataset.bookId = result.id; // Book id to retrieve information with

        const title = document.createElement('div');
        title.classList.add('font-bold', 'text-lg', 'mb-1');
        title.textContent = result.title;

        const author = document.createElement('div');
        author.classList.add('text-gray-600', 'text-sm', 'mb-1');
        author.textContent = `Author: ${result.author.name}`;

        const publicationYear = document.createElement('div');
        publicationYear.classList.add('text-gray-600', 'text-sm');
        publicationYear.textContent = `Publication Year: ${result.publication_year}`;

        listItem.appendChild(title);
        listItem.appendChild(author);
        listItem.appendChild(publicationYear);

        listItem.addEventListener('click', async function() {
            bookQueryInput.value = result.title;
            bookQueryResults.innerHTML = '';

            var bookData = await getBookInfo(listItem.dataset.bookId);
            fillBookCreateFields(bookData);
            setBookEditionSearchStatus();
        });

        bookQueryResults.appendChild(listItem);
    });
}

function setBookEditionSearchStatus() {
    const editionsKey = document.getElementById('editions-key').value;

    if (editionsKey) {
      // Enable the input field
      bookEditionQueryInput.removeAttribute('disabled');
      bookEditionQueryInput.classList.remove('bg-gray-200'); // Remove greyed-out style
    } else {
      // Disable the input field
      bookEditionQueryInput.setAttribute('disabled', 'true');
      bookEditionQueryInput.classList.add('bg-gray-200'); // Add greyed-out style
    }
}

function displayBookEditionSearchResults(results) {
    results.forEach(function (result) {
        const listItem = document.createElement('li');
        listItem.classList.add('p-2', 'border-b', 'hover:bg-gray-100', 'cursor-pointer');

        listItem.dataset.title = result.title;
        listItem.dataset.isbn = result.isbn;
        listItem.dataset.pages = result.pages;
        listItem.dataset.language = result.language;
        listItem.dataset.publication_year = parsePublishYear(result.publicationYear);

        const title = document.createElement('div');
        title.classList.add('edition-title', 'font-bold', 'text-lg', 'mb-1');
        title.textContent = result.title;

        const pages = document.createElement('div');
        pages.classList.add('edition-pages', 'text-gray-600', 'text-sm', 'mb-1');

        if (result.pages) {
            pages.textContent = `Total pages: ${result.pages}`;
        } else {
            pages.textContent = 'Total pages: unknown';
        }

        const isbnNumber = document.createElement('div');
        isbnNumber.classList.add('edition-isbn', 'text-gray-600', 'text-sm');

        if (result.isbn) {
            isbnNumber.textContent = `ISBN number: ${result.isbn}`;
        } else {
            isbnNumber.textContent = `ISBN number: unknown`;
        }

        listItem.appendChild(title);
        listItem.appendChild(pages);
        listItem.appendChild(isbnNumber);

        listItem.addEventListener('click', async function() {
            bookEditionQueryInput.value = result.title;
            bookEditionQueryResults.innerHTML = '';

            fillBookEditionCreateFields(listItem.dataset);
        });

        bookEditionQueryResults.appendChild(listItem);
    });
}

async function searchStoredBooks(query) {
    try {
        query = spaceEncoder(query) // Replace space with valid character
        const response = await axios.get(`/book/searchStoredBooks?query=${query}`);

        const results = response.data.results;
        console.log(results)

        return results;

    } catch (error) {
        console.log("Failed sending request")
        console.log(error.response);
        throw error; // Rethrow the error to handle it in the calling function
    }
}

async function searchBookEditions(query) {
    try {
        query = spaceEncoder(query)
        var editionsKey = document.getElementById('editions-key').value;

        const response = await axios.get(`/book-edition/getBookEditions?editionsKey=${editionsKey}`);

        const results = response.data.results;
        console.log(results)

        return results;

    } catch (error) {
        console.log("Failed sending request")
        console.log(error.response);
        throw error; // Rethrow the error to handle it in the calling function
    }
}

async function getBookInfo(bookId) {
    try {
        const response = await axios.get(`/book/getBook?id=${bookId}`);
        
        const results = response.data.book;

        return results;
    } catch (error) {
        console.log("Failed sending request")
        console.log(error.response);
        throw error; // Rethrow the error to handle it in the calling function
    }
}

function fillBookCreateFields(bookData) {
    document.getElementById('book-id').value = bookData.id;
    // document.getElementById('book').value = bookData.title;
    document.getElementById('title').value = bookData.title;
    document.getElementById('publication-year').value = bookData.publication_year;
    document.getElementById('editions-key').value = bookData.editions_key;
}

function fillBookEditionCreateFields(bookEditionData) {
    document.getElementById('title').value = bookEditionData.title;
    document.getElementById('publication-year').value = bookEditionData.publication_year;
    document.getElementById('isbn').value = bookEditionData.isbn;
    document.getElementById('language').value = bookEditionData.language;
    document.getElementById('pages').value = bookEditionData.pages != null ? bookEditionData.pages : '';
}