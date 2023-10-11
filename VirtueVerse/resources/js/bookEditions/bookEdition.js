import $ from 'jquery';
import axios from 'axios';
import { spaceEncoder, parseDateString, parsePublishYear } from '../shared/regexHelper';
import 'selectize/dist/css/selectize.css';
import 'selectize';

const bookEditionInput = document.getElementById('book-edition-input');
const bookEditionDropdown = document.getElementById('book-edition-dropdown');
let bookInput;
let retrievedBookEditions = [];
let dropdownVisible = false;
let timeoutId = null;
let editionsKey;
let BookEditionSearchTimeout;

bookEditionInput.addEventListener('click', toggleBookEditionDropdown);

bookEditionInput.addEventListener('input', () => {
    const searchText = bookEditionInput.value.trim();
    clearTimeout(BookEditionSearchTimeout);
  
    BookEditionSearchTimeout = setTimeout(() => {
        filterBookEditionItems(searchText);
    }, 1000);
});

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

// Event listener to close dropdown when clicking outside
document.addEventListener('click', (event) => {
    const target = event.target;
    console.log("Click");
    if (dropdownVisible && target !== bookEditionInput && !bookEditionDropdown.contains(target)) {
        console.log("Toggling");
        toggleBookEditionDropdown();
    }
  });

document.addEventListener('DOMContentLoaded', function () {
    editionsKey = document.getElementById('editions-key');

    // addSearchEventListener(bookEditionQueryInput, bookEditionQueryResults, handleBookEditionInput);
    // addSearchEventListener(bookEditionInput, bookEditionDropdown, handleBookEditionInput);
});

$(document).ready(function () {
    bookInput = $('#book'); // Replace with your input field ID

    bookInput.selectize({
        plugins: ['remove_button'],
        delimiter: ',',
        onChange: async function(id) {
            setBookId(id);
            var bookData = await getBookInfo(id);
            fillBookCreateFields(bookData);

            console.log(editionsKey.value);
            if (editionsKey.value && editionsKey.value != "")
            {
                retrievedBookEditions = await searchBookEditions("Doesnt matter");
                console.log(retrievedBookEditions);
                populateBookEditionDropdown();
            } else {
                retrievedBookEditions = [];
                bookEditionDropdown.innerHTML = "";
            }

        }
    });
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

function populateBookEditionDropdown() {
    bookEditionDropdown.innerHTML = '';
    retrievedBookEditions.forEach(edition => {
        const listItem = document.createElement('li');
        listItem.classList.add('p-2', 'border-b', 'hover:bg-gray-100', 'cursor-pointer');

        listItem.dataset.title = edition.title;
        listItem.dataset.isbn = edition.isbn;
        listItem.dataset.pages = edition.pages;
        listItem.dataset.language = edition.language;
        listItem.dataset.publication_year = parsePublishYear(edition.publicationYear);

        const title = document.createElement('div');
        title.classList.add('edition-title', 'font-bold', 'text-lg', 'mb-1');
        title.textContent = edition.title;

        const pages = document.createElement('div');
        pages.classList.add('edition-pages', 'text-gray-600', 'text-sm', 'mb-1');

        if (edition.pages) {
            pages.textContent = `Total pages: ${edition.pages}`;
        } else {
            pages.textContent = 'Total pages: unknown';
        }

        const isbnNumber = document.createElement('div');
        isbnNumber.classList.add('edition-isbn', 'text-gray-600', 'text-sm');

        if (edition.isbn) {
            isbnNumber.textContent = `ISBN number: ${edition.isbn}`;
        } else {
            isbnNumber.textContent = `ISBN number: unknown`;
        }

        listItem.appendChild(title);
        listItem.appendChild(pages);
        listItem.appendChild(isbnNumber);

        listItem.addEventListener('click', () => {
            bookEditionInput.value = edition.title;
            toggleBookEditionDropdown();

            fillBookEditionCreateFields(listItem.dataset);
        });

        bookEditionDropdown.appendChild(listItem);
    });
}

async function searchBookEditions(query) {
    try {
        query = spaceEncoder(query)
        var editionsKeyValue = editionsKey.value

        const response = await axios.get(`/book-edition/getBookEditions?editionsKey=${editionsKeyValue}`);

        const results = response.data.results;

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

function toggleBookEditionDropdown() {
    dropdownVisible = !dropdownVisible;
    if (dropdownVisible) {
      bookEditionDropdown.classList.remove('hidden');
    } else {
      bookEditionDropdown.classList.add('hidden');
    }
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