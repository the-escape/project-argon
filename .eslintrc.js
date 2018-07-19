module.exports = {
    parser: 'babel-eslint',
    extends: 'standard',
    plugins: ['import', 'node', 'promise', 'standard'],
    parserOptions: {
        ecmaVersion: 6,
        sourceType: 'module'
    },
    env: {
        browser: true,
        jquery: true
    },
    rules: {
        indent: ['error', 4]
    }
}
