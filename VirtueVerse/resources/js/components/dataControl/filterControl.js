export let filters = {};
let searchTimeoutId;

export function initializeFilter(componentId, callback) {
    const filter = document.getElementById(componentId);

    filter.addEventListener('input', async function () {
        const modelAttribute = filter.getAttribute('model');
        filters[modelAttribute] = filter.value;

        callback(filters);
    });
}

export function initializeSearch(componentId, callback) {
    const search = document.getElementById(componentId);

    search.addEventListener('input', async function () {
        const modelAttribute = search.getAttribute('model');
        filters[modelAttribute] = search.value;

        clearTimeout(searchTimeoutId); // Clear any previous pending requests

        searchTimeoutId = setTimeout(async function() {
            callback(filters);
        }, 1000);

    });
}

export function setFilterSelection(componentId, filterValues) {
    const filter = document.getElementById(componentId);
    console.log(filterValues);

    filterValues.forEach(item => {
        const option = document.createElement('option');
        option.value = item.id; 
        option.textContent = item.value;
        filter.appendChild(option);
    });
}