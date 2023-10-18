import $ from 'jquery';
import axios from 'axios';
import { spaceEncoder, parsePublishYear } from '../shared/regexHelper';
import 'selectize/dist/css/selectize.css';
import 'selectize';

let authorInput;
const queryInput = document.getElementById('search-query');
const queryResults = document.getElementById('search-results');
let retrievedBooks;
let timeoutId = null;

$(document).ready(function () {
    authorInput = $('#author'); // Replace with your input field ID

    authorInput.selectize({
        plugins: ['remove_button'],
        delimiter: ',',
        onChange: function(id) {
            setAuthorId(id);
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
    queryInput.addEventListener('input', async function () {
        const query = queryInput.value;

        clearTimeout(timeoutId); // Clear any previous pending requests
        queryResults.innerHTML = '';

        if (query.length >= 3) {
            timeoutId = setTimeout(async function() {
                try {
                    retrievedBooks = await searchBooks(query);
                    displaySearchResults(retrievedBooks);
                } catch (error) {
                    console.error('Error:', error);
                }
            }, 1000);
        } else {
            queryResults.innerHTML = '';
        }

    });
});

async function displaySearchResults(results) {
    results.forEach(function (result) {
        const listItem = document.createElement('li');
        listItem.classList.add('p-2', 'border-b', 'hover:bg-gray-100', 'cursor-pointer');

        listItem.dataset.olid = result.edition_key[0]; // The unique Open Library identifier

        const title = document.createElement('div');
        title.classList.add('font-bold', 'text-lg', 'mb-1');
        title.textContent = result.title;

        const author = document.createElement('div');
        author.classList.add('text-gray-600', 'text-sm', 'mb-1');
        if (result.author_name && result.author_name.length > 0) {
            author.textContent = `Author: ${result.author_name.join(', ')}`;
        } else {
            author.textContent = 'Author: Unknown';
        }

        const publicationYear = document.createElement('div');
        publicationYear.classList.add('text-gray-600', 'text-sm');
        publicationYear.textContent = `Publication Year: ${result.first_publish_year}`;

        listItem.appendChild(title);
        listItem.appendChild(author);
        listItem.appendChild(publicationYear);

        listItem.addEventListener('click', async function() {
            console.log(listItem.dataset);
            queryInput.value = result.title;
            queryResults.innerHTML = '';

            var bookData = await getBookInfo(listItem.dataset.olid);
            fillCreateFields(bookData);
        });

        queryResults.appendChild(listItem);
    });
}

async function searchBooks(query) {
    try {
        query = spaceEncoder(query) // Replace space with valid character
        debugger;
        const response = await axios.get(`/book/search?query=${query}`);

        const results = response.data.results.docs;
        console.log(results)

        return results;
    } catch (error) {
        console.log("Failed sending request")
        console.log(error.response);
        throw error; // Rethrow the error to handle it in the calling function
    }
}

async function getBookInfo(olid) {
    try {
        const response = await axios.get(`/book/getBookInfo?olid=${olid}`);
        
        const results = response.data.book;

        return results;
    } catch (error) {
        console.log("Failed sending request")
        console.log(error.response);
        throw error; // Rethrow the error to handle it in the calling function
    }
}

function setAuthorId(authorId) {
    document.getElementById('author-id').value = authorId;
}

function fillCreateFields(bookData) {
    console.log(bookData);
    // Populate your form fields with book information
    document.getElementById('title').value = bookData.title;
    document.getElementById('publication-year').value = parsePublishYear(bookData.publicationYear);
    document.getElementById('open-library-key').value = bookData.openLibraryKey;
    document.getElementById('author').value = bookData.author;
    document.getElementById('description').value = "";
}