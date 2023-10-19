import $ from 'jquery';
import axios from 'axios';
import { spaceEncoder, parsePublishYear } from '../shared/regexHelper';

export function setBookEditionId(bookEditionId) {
    document.getElementById('book-edition-id').value = bookEditionId;
}