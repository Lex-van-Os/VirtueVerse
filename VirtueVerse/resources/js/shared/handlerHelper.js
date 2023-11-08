export async function handleError(error) {
    console.log("Failed sending request");
    console.log(error.response);
    throw error; // Rethrow the error to handle it in the calling function
}