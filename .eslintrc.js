module.exports = {
    parser: 'vue-eslint-parser',
    extends: [
        'prettier',
        'standard',
        'plugin:vue/essential',
        'plugin:jest/recommended'
    ],
    plugins: ['prettier', 'import', 'node', 'promise', 'standard', 'jest'],
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
        indent: ['error', 4, { SwitchCase: 1 }]
    }
}
