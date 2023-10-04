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

export function parsePublishYear(dateString) {
  try {
    if (dateString == null) {
      return null;
    }
    
    const yearPattern = /\b\d{4}\b/;

    const yearMatch = dateString.match(yearPattern);
  
    if (yearMatch && yearMatch.length > 0) {
      return yearMatch[0]; 
    } else {
      return null; 
    }
  }
  catch (error) {
    console.log(error);
    console.log(dateString);
  }
}