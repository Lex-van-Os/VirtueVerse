import { handleError } from "../shared/handlerHelper";
import axios from "axios";

export async function getExpectedCompletionTime() {
    try {
        const response = await axios.post(
            `/api/insights/retrieveExpectedCompletionTime`
        );

        const results = response.data;

        return results;
    } catch (error) {
        await handleError(error);
    }
}
