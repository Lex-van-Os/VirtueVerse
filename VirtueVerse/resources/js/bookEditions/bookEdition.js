import $ from 'jquery';
import axios from 'axios';
import { spaceEncoder, parseDateString, parsePublishYear } from '../shared/regexHelper';
import 'selectize/dist/css/selectize.css';
import 'selectize';
import Vue from 'vue';

const bookEditionQueryInput = document.getElementById('book-edition-search-query');
const bookEditionQueryResults = document.getElementById('book-edition-search-results');
let bookInput;
let retrievedBooks;
let retrievedBookEditions;
let timeoutId = null;
let editionsKey;

$(document).ready(function () {
    bookInput = $('#book'); // Replace with your input field ID

    bookInput.selectize({
        plugins: ['remove_button'],
        delimiter: ',',
        onChange: async function(id) {
            setBookId(id);
            var bookData = await getBookInfo(id);
            fillBookCreateFields(bookData);
            setBookEditionSearchStatus();
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
    editionsKey = document.getElementById('editions-key');

    const bookEditionDropdownContent = new Vue({
        el: '#app',
        data: {
            showDropdown: false,
            editions: [],
            editionsKey: document.getElementById('editions-key').value,
        },
        methods: {
            async getBookEditions() {
                try {
                    query = spaceEncoder(query)
                    var editionsKeyvalue = editionsKey.value
            
                    const response = await axios.get(`/book-edition/getBookEditions?editionsKey=${editionsKeyvalue}`);
            
                    this.editions = response.data.results;
                    console.log(this.editions)
                
                } catch (error) {
                    console.log("Failed sending request")
                    console.log(error.response);
                    throw error; // Rethrow the error to handle it in the calling function
                }
            },
        },
        watch: {
            'editionsKey': function(newVal) {
                if (newVal) {
                    this.getBookEditions(); // If the value is not empty, load editions
                } else {
                    this.showDropdown = false; // Hide the dropdown when the value is empty
                }
            },
        },
    })

    setBookEditionSearchStatus();
    addSearchEventListener(bookEditionQueryInput, bookEditionQueryResults, handleBookEditionInput);
});

async function handleBookEditionInput(query) {
    retrievedBookEditions = await searchBookEditions(query);
    displayBookEditionSearchResults(retrievedBookEditions);
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

function setBookEditionSearchStatus() {
    if (editionsKey.value) {
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
        var editionsKeyValue = editionsKey.value

        const response = await axios.get(`/book-edition/getBookEditions?editionsKey=${editionsKeyValue}`);

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

function setBookId(bookId) {
    document.getElementById('book-id').value = bookId;
}

function fillBookCreateFields(bookData) {
    console.log(bookData);
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