import { Item } from './folder'

export class Search {
    constructor (keywords = '', results = []) {
        this.keywords = keywords
        this.setResults(results)
        this.loading = false
    }

    hasResults () {
        return this.results.length !== 0
    }

    getResults () {
        return this.results
    }

    setResults (results) {
        this.results = results.reduce((a, v) => {
            a.push(new Item(v))
            return a
        }, [])
    }

    getResultsCount () {
        return this.results.length
    }

    isLoading () {
        return this.loading
    }

    hasKeywords () {
        return this.keywords.length !== 0
    }

    reset () {
        this.results = []
        this.keywords = ''
    }
}
