class Autocomplete {
    constructor(inputElement, url) {
        this.inputElement = inputElement;
        this.url = url;
        this.init();
    }

    init() {
        this.inputElement.addEventListener('input', this.fetchSuggestions.bind(this));
    }

    async fetchSuggestions(event) {
        const query = event.target.value;
        if (query.length < 2) return; // Only fetch if query is longer than 2 characters

        try {
            const response = await fetch(this.url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ query })
            });

            const suggestions = await response.json();
            this.showSuggestions(suggestions);
        } catch (error) {
            console.error('Error fetching suggestions:', error);
        }
    }

    showSuggestions(suggestions) {
        // Implement your logic to display suggestions
        console.log(suggestions);
    }
}
