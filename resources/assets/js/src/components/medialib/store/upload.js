export class Upload {
    constructor () {
        this.files = [] // needs length attribute just as FileList for seamless operations
        this.initialised = false
        this.progress = false
        this.label = 'Upload'
        this.ouputMessages = []
    }

    inProgress () {
        return this.progress
    }

    getLabel () {
        return this.label
    }

    hasFiles () {
        return this.files.length !== 0
    }

    getFiles () {
        return this.files
    }

    getOutputMessages () {
        return this.ouputMessages
    }

    isInitialised () {
        return this.initialised
    }

    init () {
        this.initialised = true
        this.label = 'Cancel upload'
    }

    reset () {
        this.files = []
        this.initialised = false
        this.progress = false
        this.label = 'Upload'
    }
}
