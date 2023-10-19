import $ from 'jquery';
import { editionsKey, bookEditionDropdown, setBookId, getBookInfo, fillBookCreateFields, searchBookEditions, populateBookEditionDropdown, modifyRetrievedbookEditions } from './bookEdition';

let bookInput;

$(document).ready(function () {
    console.log("ready");
    bookInput = $('#book'); // Replace with your input field ID

    bookInput.selectize({
        plugins: ['remove_button'],
        delimiter: ',',
        onChange: async function(id) {
            console.log("Change");
            setBookId(id);

            // Only perform dropdown functionality in case element exists on page
            if (bookEditionDropdown !== null) {
                var bookData = await getBookInfo(id);
                fillBookCreateFields(bookData);
    
                console.log(editionsKey.value);
                if (editionsKey.value && editionsKey.value != "")
                {
                    var bookEditions = await searchBookEditions("Doesnt matter");
                    modifyRetrievedbookEditions(bookEditions)
                    populateBookEditionDropdown();
                } else {
                    modifyRetrievedbookEditions([]);
                    bookEditionDropdown.innerHTML = "";
                }
            }
        }
    });
});