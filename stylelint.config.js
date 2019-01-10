module.exports = {
    extends: [
        'stylelint-config-standard',
        './node_modules/prettier-stylelint/config.js'
    ],
    plugins: ['stylelint-scss'],
    rules: {
        indentation: 4,
        'selector-pseudo-element-colon-notation': 'single',
        'no-descending-specificity': null,
        'at-rule-no-unknown': [
            true,
            {
                ignoreAtRules: [
                    'extend',
                    'at-root',
                    'debug',
                    'warn',
                    'error',
                    'if',
                    'else',
                    'elseif',
                    'for',
                    'each',
                    'while',
                    'mixin',
                    'include',
                    'content',
                    'return',
                    'function'
                ]
            }
        ],
        'at-rule-empty-line-before': [
            'always',
            {
                except: ['blockless-after-same-name-blockless', 'first-nested'],
                ignore: ['after-comment'],
                ignoreAtRules: ['else']
            }
        ],
        'color-named': 'never',
        'declaration-property-value-blacklist': {
            '/^border/': ['none']
        },
        'block-opening-brace-space-before': 'always',
        'function-url-quotes': 'always',
        'shorthand-property-no-redundant-values': true,
        'scss/at-import-partial-extension-blacklist': ['scss'],
        'scss/dollar-variable-colon-space-before': 'never',
        'scss/selector-no-redundant-nesting-selector': true,
        'scss/dollar-variable-no-missing-interpolation': true
    }
}
