import axios from 'axios';
import { spaceEncoder, parseDateString } from '../shared/regexHelper';

// DOM elements
const queryInput = document.getElementById('search-query');
const queryResults = document.getElementById('search-results');

// Global variables
let retrievedAuthors; // Used to set dropdown value
let timeoutId = null; // Used for timeout 

// Wait for the DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function () {
    // Listen for input in the search query input field
    queryInput.addEventListener('input', async function () {
        const query = queryInput.value;

        clearTimeout(timeoutId); // Clear any previous pending requests
        queryResults.innerHTML = '';

        if (query.length >= 3) {
            // Delay the search to avoid excessive requests
            timeoutId = setTimeout(async function () {
                try {
                    retrievedAuthors = await searchAuthors(query);
                    displayRetrievedAuthors(retrievedAuthors);
                } catch (error) {
                    console.error('Error:', error);
                }
            }, 1000);
        } else {
            queryResults.innerHTML = '';
        }
    });
});

// Search for authors based on the user's query
async function searchAuthors(query) {
    try {
        query = spaceEncoder(query) // Replace space with a valid character
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

// Display the retrieved authors in the search results
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

        listItem.addEventListener('click', async function () {
            console.log(listItem.dataset);
            queryInput.value = result.name;
            queryResults.innerHTML = '';

            var authorData = await getAuthorInfo(listItem.dataset.olid);
            authorData = formatAuthorData(authorData);
            fillAuthorCreateFields(authorData);
        });

        queryResults.appendChild(listItem);
    });
}

// Fetch detailed author information using Open Library identifier
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

function formatAuthorData(authorData) {
    if (authorData.birthDate != null) {
        authorData.birthDate = parseDateString(authorData.birthDate);
    }

    authorData.biography = extractAuthorBiography(authorData.biography);

    return authorData
}

function extractAuthorBiography(biography) {
    let returnBiography;

    if (biography === null) {
        returnBiography = "";
    } else if (typeof biography === 'string') {
        returnBiography = biography;
    } else if (typeof biography === 'object' && biography.value) {
        returnBiography = biography.value;
    }

    return returnBiography
}

// Populate author creation form fields with retrieved author data
function fillAuthorCreateFields(authorData) {
    console.log(authorData);

    // Populate your form fields with author information
    document.getElementById('name').value = authorData.name;
    document.getElementById('birthdate').value = authorData.birthDate;
    document.getElementById('biography').value = authorData.biography;
    document.getElementById('open-library-key').value = authorData.openLibraryKey;
}