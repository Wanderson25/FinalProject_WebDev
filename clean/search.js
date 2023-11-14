function initSearch() {
    var searchInput = document.querySelector(".search");
    var dropdown = document.querySelector(".search-results-dropdown");
    dropdown.style.display = "none";
    // Add an event listener for the "focus" event on the search input
    searchInput.addEventListener("focus", function() {
        // Show the search results dropdown
        dropdown.style.display = "block";
    });
    dropdown.innerHTML = "Gaze into the sky...";

    document.addEventListener("click", function(event) {
        if (!searchInput.contains(event.target)) {
            // Hide the search results dropdown
            dropdown.style.display = "none";
        }
    });

    searchInput.addEventListener("input", function() {
        // Get the search query
        var query = this.value;
        if(query.length < 1) {
            dropdown.innerHTML = "Gaze into the sky...";
            return;
        }
        
        // Open a GET request to the PHP script with the search query as a parameter
        fetch(`search.php?query=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(results => {
                // Check if there are any results
                if (results.length === 0) {
                    // If there are no results, display "No result" in the dropdown
                    dropdown.innerHTML = "No result";
                } else {
                    // Update the search results dropdown with the new results
                    dropdown.innerHTML = results.map(result => `
                        <div class="search-result">
                            ${string_search_result(result.song_id, result.song_title, result.song_artist)}
                        </div>
                    `).join('');
                }
            });
    });
}

function string_search_result(song_id, song_title, song_artist) {
    return `<a href="HomePaged.php?song=${song_id}">${song_title} - ${song_artist}</a>`
}