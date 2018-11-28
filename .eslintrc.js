module.exports = {
    parser: 'vue-eslint-parser',
    extends: ['standard', 'plugin:vue/essential'],
    plugins: ['import', 'node', 'promise', 'standard'],
    parserOptions: {
        ecmaVersion: 2018,
        sourceType: 'module',
        parser: 'babel-eslint'
    },
    env: {
        browser: true,
        jquery: true
    },
    rules: {
        indent: ['error', 4]
    }
}
