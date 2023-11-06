import $ from "jquery";
import axios from "axios";
import { Chart, LinearScale, registerables } from "chart.js";
import { spaceEncoder } from "../shared/regexHelper";

Chart.register(...registerables);

let studyTrajectoryId = parseInt(
    document.getElementById("study-trajectory-id").value
);

export function setBookEditionId(bookEditionId) {
    document.getElementById("book-edition-id").value = bookEditionId;
}

document.addEventListener("DOMContentLoaded", function () {
    createReadPagesChart();
});

async function retrieveReadPagesChartData(studyTrajectoryId) {
    try {
        const response = await axios.get(
            `/charts/retrieveReadPagesChartData/${studyTrajectoryId}`
        );

        const results = response.data;
        console.log(results);

        return results;
    } catch (error) {
        console.log("Failed sending request");
        console.log(error.response);
        throw error; // Rethrow the error to handle it in the calling function
    }
}

async function createReadPagesChart() {
    console.log("createReadPagesChart");
    const readPagesChart = document.getElementById("readpagesChart");

    var readPagesChartData = await retrieveReadPagesChartData(
        studyTrajectoryId
    );

    const labels = readPagesChartData.chartData.map((entry) => entry.date);
    const data = readPagesChartData.chartData.map((entry) => entry.read_pages);


    var chartData = {
        labels: labels,
        datasets: [
            {
                label: "Read pages",
                data: data,
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
                    suggestedMax: readPagesChartData.totalPages,
                },
            },
        },
    });
}
