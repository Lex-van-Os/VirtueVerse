import moment from 'moment';

export function spaceEncoder(input) {
    return input.replace(/ /g, '%20');
}

// Cases:
// Year only
// 14 september 1896
export function parseDateString(dateString) {
  if (/^\d{4}$/.test(dateString)) {
      // For the "YYYY" format, add a default month and day, then parse
      dateString = `1 January ${dateString}`;
  }

  const validFormats = ['DD MMMM YYYY', 'MMMM DD, YYYY', 'D MMMM YYYY'];

  for (const format of validFormats) {
      const parsedDate = moment(dateString, format, 'en', true);

      if (parsedDate.isValid()) {
          return parsedDate.format('YYYY-MM-DD'); // Format as ISO date
      }
  }

  return null; // Return null if no valid date format is found
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