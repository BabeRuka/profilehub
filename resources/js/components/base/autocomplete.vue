<template>
  <div>
    <input type="text" v-model="query" @input="fetchSuggestions" placeholder="Start typing...">
    <ul v-if="suggestions.length">
      <li v-for="suggestion in suggestions" :key="suggestion.id">{{ suggestion.name }}</li>
    </ul>
  </div>
</template>

<script>
export default {
  data() {
    return {
      query: '',
      suggestions: []
    };
  },
  methods: {
    async fetchSuggestions() {
      if (this.query.length < 2) return; // Only fetch if query is longer than 2 characters

      try {
        const response = await fetch('/autocomplete', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          },
          body: JSON.stringify({ query: this.query })
        });

        this.suggestions = await response.json();
      } catch (error) {
        console.error('Error fetching suggestions:', error);
      }
    }
  }
};
</script>
