import $ from 'jquery';
import { setAuthorId } from './book';

let authorInput;

$(document).ready(function () {
    console.log("Foo");
    authorInput = $('#author'); // Replace with your input field ID

    authorInput.selectize({
        plugins: ['remove_button'],
        delimiter: ',',
        onChange: function(id) {
            setAuthorId(id);
        }
    });
});
