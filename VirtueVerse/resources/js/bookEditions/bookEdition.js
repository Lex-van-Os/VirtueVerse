import $ from 'jquery';
import axios from 'axios';
import { spaceEncoder, parseDateString, parsePublishYear } from '../shared/regexHelper';
import 'selectize/dist/css/selectize.css';
import 'selectize';

// DOM elements
const bookEditionInput = document.getElementById('book-edition-input');
export const bookEditionDropdown = document.getElementById('book-edition-dropdown');

// Global variables
export let editionsKey;
export let retrievedBookEditions = [];
export function modifyRetrievedbookEditions( newValue ) { retrievedBookEditions = newValue; }
let dropdownVisible = false; 
let timeoutId = null; // Used for search functionality
let BookEditionSearchTimeout; // Used for search functionality

if (bookEditionDropdown !== null) {
    // Event listener to toggle the dropdown
    bookEditionInput.addEventListener('click', toggleBookEditionDropdown);

    // Event listener to filter dropdown items based on user input
    bookEditionInput.addEventListener('input', () => {
        const searchText = bookEditionInput.value.trim();
        clearTimeout(BookEditionSearchTimeout);

        BookEditionSearchTimeout = setTimeout(() => {
            filterBookEditionItems(searchText);
        }, 1000);
    });
}

function filterBookEditionItems(searchText) {
    const items = bookEditionDropdown.querySelectorAll('li');
    items.forEach(item => {
      const text = item.textContent.toLowerCase();
      if (text.includes(searchText.toLowerCase())) {
        item.style.display = 'block'; 
      } else {
        item.style.display = 'none';
      }
    });
}

// Event listener to close the dropdown when clicking outside
document.addEventListener('click', (event) => {
    const target = event.target;
    if (dropdownVisible && target !== bookEditionInput && !bookEditionDropdown.contains(target)) {
        toggleBookEditionDropdown();
    }
});

document.addEventListener('DOMContentLoaded', function () {
    editionsKey = document.getElementById('editions-key');
});

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

export function populateBookEditionDropdown() {
    bookEditionDropdown.innerHTML = '';
    retrievedBookEditions.forEach(edition => {
        const listItem = document.createElement('li');
        listItem.classList.add('p-2', 'border-b', 'hover:bg-gray-100', 'cursor-pointer');

        // Set dataset attributes for each item
        listItem.dataset.title = edition.title;
        listItem.dataset.isbn = edition.isbn;
        listItem.dataset.pages = edition.pages;
        listItem.dataset.language = edition.language;
        listItem.dataset.publication_year = parsePublishYear(edition.publicationYear);

        // Create title element
        const title = document.createElement('div');
        title.classList.add('edition-title', 'font-bold', 'text-lg', 'mb-1');
        title.textContent = edition.title;

        // Create pages element
        const pages = document.createElement('div');
        pages.classList.add('edition-pages', 'text-gray-600', 'text-sm', 'mb-1');
        if (edition.pages) {
            pages.textContent = `Total pages: ${edition.pages}`;
        } else {
            pages.textContent = 'Total pages: unknown';
        }

        // Create ISBN number element
        const isbnNumber = document.createElement('div');
        isbnNumber.classList.add('edition-isbn', 'text-gray-600', 'text-sm');
        if (edition.isbn) {
            isbnNumber.textContent = `ISBN number: ${edition.isbn}`;
        } else {
            isbnNumber.textContent = `ISBN number: unknown`;
        }

        // Append elements to the list item
        listItem.appendChild(title);
        listItem.appendChild(pages);
        listItem.appendChild(isbnNumber);

        // Event listener for item selection
        listItem.addEventListener('click', () => {
            bookEditionInput.value = edition.title;
            toggleBookEditionDropdown();
            fillBookEditionCreateFields(listItem.dataset);
        });

        bookEditionDropdown.appendChild(listItem);
    });
}

export async function searchBookEditions(query) {
    try {
        query = spaceEncoder(query);
        const editionsKeyValue = editionsKey.value;

        // Send a request to search for book editions
        const response = await axios.get(`/book-edition/getBookEditions?editionsKey=${editionsKeyValue}`);

        const results = response.data.results;

        return results;
    } catch (error) {
        console.log("Failed sending request");
        console.log(error.response);
        throw error; // Rethrow the error to handle it in the calling function
    }
}

export async function getBookInfo(bookId) {
    try {
        // Send a request to get book information
        const response = await axios.get(`/book/getBook?id=${bookId}`);

        const results = response.data.book;

        return results;
    } catch (error) {
        console.log("Failed sending request");
        console.log(error.response);
        throw error; // Rethrow the error to handle it in the calling function
    }
}

export function setBookId(bookId) {
    // Set the book ID in the form
    document.getElementById('book-id').value = bookId;
}

function toggleBookEditionDropdown() {
    dropdownVisible = !dropdownVisible;
    if (dropdownVisible) {
        bookEditionDropdown.classList.remove('hidden');
    } else {
        bookEditionDropdown.classList.add('hidden');
    }
}

export function fillBookCreateFields(bookData) {
    console.log(bookData);
    // Fill form fields with book information
    document.getElementById('book-id').value = bookData.id;
    document.getElementById('title').value = bookData.title;
    document.getElementById('publication-year').value = bookData.publication_year;
    document.getElementById('editions-key').value = bookData.editions_key;
}

function fillBookEditionCreateFields(bookEditionData) {
    // Fill form fields with book edition information
    document.getElementById('title').value = bookEditionData.title;
    document.getElementById('publication-year').value = bookEditionData.publication_year;
    document.getElementById('isbn').value = bookEditionData.isbn;
    document.getElementById('language').value = bookEditionData.language;
    document.getElementById('pages').value = bookEditionData.pages != null ? bookEditionData.pages : '';
}