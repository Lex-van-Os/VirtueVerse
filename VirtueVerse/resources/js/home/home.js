import { handleError } from "../shared/handlerHelper";
import axios from "axios";

document.addEventListener("DOMContentLoaded", async function () {
    // Commented API methods till further implementation
    // let popularBooks = await getPopularBooks();
    // console.log("Popular books:");
    // console.log(popularBooks);

    // let bookRecommendations = await getBookRecommendations();
    // console.log("Book recommendations:");
    // console.log(bookRecommendations);
});

export async function getPopularBooks() {
    try {
        const response = await axios.post(`/api/insights/retrievePopularBooks`);

        const results = response.data;

        return results;
    } catch (error) {
        await handleError(error);
    }
}

export async function getBookRecommendations() {
    try {
        const response = await axios.post(
            `/api/insights/retrieveBookRecommendations`
        );

        const results = response.data;

        return results;
    } catch (error) {
        await handleError(error);
    }
}
