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
    createPagesPerMonthChart();
    createInputtedRecordsChart();
    createReadingSpeedChart();
});

async function retrieveReadingSpeedChartData(studyTrajectoryId) {
    try {
        const response = await axios.get(
            `/charts/retrieveReadingSpeedChartData/${studyTrajectoryId}`
        );

        const results = response.data;

        return results;
    } catch (error) {
        console.log("Failed sending request");
        console.log(error.response);
        throw error; // Rethrow the error to handle it in the calling function
    }
}

async function retrieveInputtedRecordsChartData(studyTrajectoryId) {
    try {
        const response = await axios.get(
            `/charts/retrieveInputtedRecordsChartdata/${studyTrajectoryId}`
        );

        const results = response.data;

        return results;
    } catch (error) {
        console.log("Failed sending request");
        console.log(error.response);
        throw error; // Rethrow the error to handle it in the calling function
    }
}

async function retrievePagesPerMonthChartData(studyTrajectoryId) {
    try {
        const response = await axios.get(
            `/charts/retrievePagesPerMonthChartData/${studyTrajectoryId}`
        );

        const results = response.data;

        return results;
    } catch (error) {
        console.log("Failed sending request");
        console.log(error.response);
        throw error; // Rethrow the error to handle it in the calling function
    }
}

async function retrieveReadPagesChartData(studyTrajectoryId) {
    try {
        const response = await axios.get(
            `/charts/retrieveReadPagesChartData/${studyTrajectoryId}`
        );

        const results = response.data;

        return results;
    } catch (error) {
        console.log("Failed sending request");
        console.log(error.response);
        throw error; // Rethrow the error to handle it in the calling function
    }
}

async function createReadPagesChart() {
    const readPagesChart = document.getElementById("readPagesChart");

    var readPagesChartData = await retrieveReadPagesChartData(
        studyTrajectoryId
    );

    const labels = readPagesChartData.chartData.map((entry) => entry.date);
    const data = readPagesChartData.chartData.map((entry) => entry.read_pages);

    var chartData = {
        labels: labels,
        datasets: [
            {
                label: "Read pages per entry",
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

async function createPagesPerMonthChart() {
    const pagesByMonthChart = document.getElementById("pagesByMonthChart");

    var readPagesChartData = await retrievePagesPerMonthChartData(
        studyTrajectoryId
    );

    let chartMonths = Object.keys(readPagesChartData);
    let chartReadPages = readPagesChartData;

    const labels = chartMonths;
    const data = {
        labels: labels,
        datasets: [
            {
                label: "Read pages per month",
                data: chartReadPages,
                borderWidth: 1,
            },
        ],
    };

    new Chart(pagesByMonthChart, {
        type: "bar",
        data: data,
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                },
            },
        },
    });
}

async function createInputtedRecordsChart() {
    const inputtedRecordsChart = document.getElementById(
        "inputtedRecordsChart"
    );

    let inputtedRecordsData = await retrieveInputtedRecordsChartData(
        studyTrajectoryId
    );

    let pagesData = inputtedRecordsData["pagesEntryCount"];
    let notesData = inputtedRecordsData["notesEntryCount"];
    let readMinutesData = inputtedRecordsData["readMinutesEntryCount"];

    const data = {
        labels: ["Red", "Blue", "Yellow"],
        datasets: [
            {
                label: "Total inputted study entries",
                data: [pagesData, notesData, readMinutesData],
                backgroundColor: [
                    "rgb(255, 99, 132)",
                    "rgb(54, 162, 235)",
                    "rgb(255, 205, 86)",
                ],
                hoverOffset: 4,
            },
        ],
    };

    new Chart(inputtedRecordsChart, {
        type: "doughnut",
        data: data,
    });
}

async function createReadingSpeedChart() {
    const readingSpeedChart = document.getElementById(
        "readingSpeedChart"
    );

    let readingSpeedData = await retrieveReadingSpeedChartData(studyTrajectoryId);

    debugger;

}