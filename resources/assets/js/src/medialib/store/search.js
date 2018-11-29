export class Search {
    constructor(keywords='', results={}) {
        this.keywords = keywords
        this.results = results
        this.loading = false
    }

    hasResults() {
        return Object.keys(this.results).length !== 0
    }

    getResults() {
        return this.results
    }

    setResults(results) {
        this.results = results
    }

    getResultsCount() {
        return Object.keys(this.results).length
    }

    isLoading() {
        return this.loading
    }

    hasKeywords() {
        return this.keywords.length !== 0
    }

    reset() {
        this.results = {}
        this.keywords = ''
    }
}
