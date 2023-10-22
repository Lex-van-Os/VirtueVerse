import axios from 'axios';
import { setFilterSelection, initializeFilter, filters, initializeSearch } from '../components/dataControl/filterControl';

let bookFilterValues;
let authorFilterValues;
let templateBookImageSrc;
let bookFilter = document.getElementById('book-filter');
let authorFilter = document.getElementById('author-filter');
let bookEditionInput = document.getElementById("book-edition-search");
const bookEditionContainer = document.getElementById("book-editions");

document.addEventListener('DOMContentLoaded', async function () {
    templateBookImageSrc = retrieveTemplateBookImage();
    bookFilterValues = await getBookFilterValues();
    authorFilterValues = await getAuthorFilterValues();

    setFilterSelection('book-filter', bookFilterValues);
    setFilterSelection('author-filter', authorFilterValues);

    initializeFilter('book-filter', getEditionCatalogueData);
    initializeFilter('author-filter', getEditionCatalogueData);
    initializeSearch('book-edition-search', getEditionCatalogueData);

    setInitialFilterValues();
});

function retrieveTemplateBookImage() {
    const bookEditionCards = document.querySelectorAll('.book-edition-card'); // Use the appropriate selector
    let retrievedImagePath;

    if (bookEditionCards.length > 0) {
        const firstBookEditionCard = bookEditionCards[0];

        const firstImage = firstBookEditionCard.querySelector('img');

        if (firstImage) {
            retrievedImagePath = firstImage.getAttribute('src');
        }
    }

    return retrievedImagePath;
}

async function getBookFilterValues() {
    try {
        const response = await axios.get(`/book/getBookFilterValues`);

        const results = response.data.bookFilterValues;

        return results;

    } catch (error) {
        console.log("Failed sending request")
        console.log(error.response);
        throw error; // Rethrow the error to handle it in the calling function
    }
}

async function getAuthorFilterValues() {
    try {
        const response = await axios.get(`/author/getAuthorFilterValues`);

        const results = response.data.authorFilterValues;

        return results;

    } catch (error) {
        console.log("Failed sending request")
        console.log(error.response);
        throw error; // Rethrow the error to handle it in the calling function
    }
}

function setInitialFilterValues() {
    bookFilter.value = parseInt(document.getElementById("selected-book-id").value);
}

function setDisplayBook(displayName) {
    const contentHeader = document.getElementById("book-display-name");

    if(displayName != "") {
        contentHeader.textContent = "Book edition catalogue: " + displayName;
    } else {
        contentHeader.textContent = "Book edition catalogue";
    }
}

async function createBookEditionCard(bookEdition) {
    const { id, title, publication_year, isbn, pages, created_at } = bookEdition;

    const card = document.createElement('a');
    card.href = `/book-edition/${id}`;
    card.className = 'block bg-white rounded-lg shadow-md cursor-pointer';
  
    const img = document.createElement('img');
    img.src = templateBookImageSrc;
    img.alt = title;
    img.className = 'w-full h-48 object-cover rounded-t-lg';
    card.appendChild(img);
  
    const content = document.createElement('div');
    content.className = 'p-4';
  
    const heading = document.createElement('h2');
    heading.className = 'text-lg font-semibold mb-2';
    heading.textContent = title;
    content.appendChild(heading);
  
    const yearParagraph = document.createElement('p');
    yearParagraph.className = 'text-gray-600';
    yearParagraph.textContent = `Publicated on: ${publication_year}`;
    content.appendChild(yearParagraph);
  
    if (isbn) {
      const isbnParagraph = document.createElement('p');
      isbnParagraph.className = 'text-gray-600';
      isbnParagraph.textContent = `ISBN number: ${isbn}`;
      content.appendChild(isbnParagraph);
    }
  
    const pagesParagraph = document.createElement('p');
    pagesParagraph.className = 'text-gray-600';
    pagesParagraph.textContent = `Total pages: ${pages}`;
    content.appendChild(pagesParagraph);
  
    card.appendChild(content);
  
    const createdDate = new Date(created_at);
    const dateParagraph = document.createElement('p');
    dateParagraph.className = 'text-gray-400 text-sm italic';
    dateParagraph.textContent = `Created on: ${createdDate.toLocaleDateString()}`;
    content.appendChild(dateParagraph);
    
    return card;
}

async function displayBookEditions(bookEditions) {
    bookEditionContainer.innerHTML = '';
    console.log(bookEditions);

    for (var bookEdition of bookEditions) {
        let bookEditionCard = await createBookEditionCard(bookEdition);

        console.log(bookEditionCard);
        bookEditionContainer.append(bookEditionCard);
    }
}

export async function getSelectedBookInformation(bookId) {
    try {
        if(bookId != null) {
            const response = await axios.get(`/book/getBook?id=${bookId}`);
        
            const bookInformation = response.data.book;
            return bookInformation;
        }
    } catch (error) {
        console.log("Failed sending request")
        console.log(error.response);
        throw error; // Rethrow the error to handle it in the calling function
    }
}

export async function getEditionCatalogueData(bookEditionFilters) {

    if (!("book-edition" in bookEditionFilters)) {
        bookEditionFilters['book-edition'] = ""
    }

    if (!("book" in bookEditionFilters)) {
        bookEditionFilters['book'] = ""
    }

    if (!("author" in bookEditionFilters)) {
        bookEditionFilters['author'] = ""
    }

    let bookFilter = bookEditionFilters['book'];
    let authorFilter = bookEditionFilters['author'];
    let bookEditionFilter = bookEditionFilters['book-edition'];

    console.log(bookEditionFilters);

    try {
        const response = await axios.get(`/book-edition/retrieveFilteredItems?book=${bookFilter}&author=${authorFilter}&book-edition=${bookEditionFilter}`);
        
        const bookEditions = response.data.results;
        displayBookEditions(bookEditions);

        if (bookFilter != "") {
            const book = await getSelectedBookInformation(parseInt(bookFilter));
            setDisplayBook(book.title);
        } else {
            setDisplayBook("");
        }
    } catch (error) {
        console.log("Failed sending request")
        console.log(error.response);
        throw error; // Rethrow the error to handle it in the calling function
    }
}