import $ from "jquery";
import axios from "axios";
import { Chart, LinearScale, registerables } from "chart.js";
import { spaceEncoder } from "../shared/regexHelper";

Chart.register(...registerables);

export function setBookEditionId(bookEditionId) {
    document.getElementById("book-edition-id").value = bookEditionId;
}

document.addEventListener("DOMContentLoaded", function () {
    createReadPagesChart();
});

async function retrieveReadPagesChartData() {
    try {
        query = spaceEncoder(query);
        const response = await axios.get(`/book/search?query=${query}`);

        const results = response.data.results.docs;
        console.log(results);

        return results;
    } catch (error) {
        console.log("Failed sending request");
        console.log(error.response);
        throw error; // Rethrow the error to handle it in the calling function
    }
}

async function createReadPagesChart() {
    const readPagesChart = document.getElementById("readpagesChart");

    chartData = {
        labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
        datasets: [
            {
                label: "# of Votes",
                data: [12, 19, 3, 5, 2, 3],
                borderWidth: 1,
            },
        ],
    };

    new Chart(readPagesChart, {
        type: "line",
        data: chartData,
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                },
            },
        },
    });
}
