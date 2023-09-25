import axios from 'axios';
import { spaceEncoder, parseDateString } from '../shared/regexHelper';

const queryInput = document.getElementById('search-query');
const queryResults = document.getElementById('search-results');
let retrievedBooks;
let timeoutId = null;

document.addEventListener('DOMContentLoaded', function () {
    queryInput.addEventListener('input', async function () {
        const query = queryInput.value;

        clearTimeout(timeoutId); // Clear any previous pending requests
        queryResults.innerHTML = '';

        if (query.length >= 3) {
            timeoutId = setTimeout(async function() {
                try {
                    retrievedBooks = await searchAuthors(query);
                    displayRetrievedAuthors(retrievedBooks);
                } catch (error) {
                    console.error('Error:', error);
                }
            }, 1000);
        } else {
            queryResults.innerHTML = '';
        }

    });
});

async function searchAuthors(query) {
    try {
        query = spaceEncoder(query) // Replace space with valid character
        const response = await axios.get(`/author/search?query=${query}`);

        const results = response.data.results;
        console.log(results)

        return results;
    } catch (error) {
        console.log("Failed sending request")
        console.log(error.response);
        throw error; // Rethrow the error to handle it in the calling function
    }
}

async function displayRetrievedAuthors(results) {
    results.forEach(function (result) {
        const listItem = document.createElement('li');
        listItem.classList.add('p-2', 'border-b', 'hover:bg-gray-100', 'cursor-pointer');

        listItem.dataset.olid = result.key; // The unique Open Library identifier

        const name = document.createElement('div');
        name.classList.add('font-bold', 'text-lg', 'mb-1');
        name.textContent = result.name;

        const birth_date = document.createElement('div');
        birth_date.classList.add('text-gray-600', 'text-sm', 'mb-1');

        if (result['birth_date'] !== undefined) {
            birth_date.textContent = `Birth date: ${result.birth_date}`;
        } else {
            birth_date.textContent = 'Birth date: Unknown';
        }

        listItem.appendChild(name);
        listItem.appendChild(birth_date);

        listItem.addEventListener('click', async function() {
            console.log(listItem.dataset);
            queryInput.value = result.name;
            queryResults.innerHTML = '';

            var authorData = await getAuthorInfo(listItem.dataset.olid);
            fillAuthorCreateFields(authorData);
        });

        queryResults.appendChild(listItem);
    });
}

async function getAuthorInfo(olid) {
    try {
        const response = await axios.get(`/author/getAuthorInfo?olid=${olid}`);
        
        const results = response.data.author;

        return results;
    } catch (error) {
        console.log("Failed sending request")
        console.log(error.response);
        throw error; // Rethrow the error to handle it in the calling function
    }
}

function fillAuthorCreateFields(authorData) {
    console.log(authorData);

    if (authorData.birthDate != null) {
        authorData.birthDate = parseDateString(authorData.birthDate)
    }

    // Populate your form fields with book information
    document.getElementById('name').value = authorData.name;
    document.getElementById('birthdate').value = authorData.birthDate;
    document.getElementById('biography').value = authorData.biography;
    document.getElementById('open-library-key').value = authorData.openLibraryKey;
}