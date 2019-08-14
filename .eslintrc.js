module.exports = {
    parser: 'vue-eslint-parser',
    extends: ['standard', 'plugin:vue/essential', 'plugin:jest/recommended'],
    plugins: ['import', 'node', 'promise', 'standard', 'jest'],
    parserOptions: {
        ecmaVersion: 2018,
        sourceType: 'module',
        parser: 'babel-eslint'
    },
    env: {
        browser: true,
        jquery: true,
        'jest/globals': true
    },
    rules: {
        indent: ['error', 4]
    }
}
