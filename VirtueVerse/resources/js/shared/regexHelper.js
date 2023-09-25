import moment from 'moment';

export function spaceEncoder(input) {
    return input.replace(/ /g, '%20');
}

export function parseDateString(dateString) {
    const parsedDate = moment(dateString, ['DD MMMM YYYY', 'MMMM DD, YYYY'], 'en', true);

    if (parsedDate.isValid()) {
      return parsedDate.format('YYYY-MM-DD'); // Format as ISO date
    } else {
      return null;
    }
}