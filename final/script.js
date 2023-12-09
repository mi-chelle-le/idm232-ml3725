// Protein Filter
function toggleFilter(filter, element) {
    let url = new URL(window.location);
    let filters = url.searchParams.get('filters') ? url.searchParams.get('filters').split(',') : [];
    
    const index = filters.indexOf(filter);
    if (index > -1) {
        filters.splice(index, 1);
        element.classList.remove('active'); 
    } else {
        filters.push(filter); 
        element.classList.add('active'); 
    }

    url.searchParams.set('filters', filters.join(','));
    window.location.href = url.href;
}

function clearFilters() {
    let url = new URL(window.location);
    url.searchParams.delete('filters');
    window.location.href = url.href;

    document.querySelectorAll('.filter-button').forEach(button => {
        button.classList.remove('active');
    });
}

function initializeButtonStates() {
    let url = new URL(window.location);
    let filters = url.searchParams.get('filters') ? url.searchParams.get('filters').split(',') : [];

    document.querySelectorAll('.filter-button').forEach(button => {
        const filterValue = button.getAttribute('data-filter');
        if (filters.includes(filterValue)) {
            button.classList.add('active');
        } else {
            button.classList.remove('active');
        }
    });
}

// Cooktime Filter

// function toggleCookTimeFilter(cooktime, element) {
//     let url = new URL(window.location);
//     url.searchParams.set('cooktime', cooktime);
//     window.location.href = url.href;

//     document.querySelectorAll('.cooktime').forEach(button => {
//         if (button.getAttribute('data-cooktime') === cooktime) {
//             button.classList.add('active');
//         } else {
//             button.classList.remove('active');
//         }
//     });
// }


document.addEventListener('DOMContentLoaded', initializeButtonStates);


