import $ from 'jquery';
import 'selectize/dist/css/selectize.css';
import 'selectize';
import { setBookEditionId } from './studyTrajectory';

let bookEditionInput;

$(document).ready(function () {
    bookEditionInput = $('#book-edition');

    bookEditionInput.selectize({
        plugins: ['remove_button'],
        delimiter: ',',
        onChange: function(id) {
            setBookEditionId(id);
        }
    });
});
