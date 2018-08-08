let hashes = []

export function createUniqueHash () {
    let newHash = createHash()
    while (~hashes.indexOf(newHash)) {
        newHash = createHash()
    }

    hashes.push(newHash)
    return newHash
}

function createHash () {
    return Math.random()
        .toString(36)
        .substr(2, 9)
}