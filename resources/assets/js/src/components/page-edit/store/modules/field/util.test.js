import {
    processFields,
    assignNewIdsToComboValueObj,
    getField
} from './util'

test('processFields normalises initial data, by adding ids to value arrays and creates empty values objs', () => {
    const fields = [{
            "id": 2,
            "options": {
                "typeKey": "text",
                "name": "multi text",
                "settings": {
                    "required": false,
                    "multiline": false,
                    "multiple": true,
                    "minlength": 0,
                    "maxlength": 0,
                    "url": false,
                    "integer": false,
                    "float": false,
                    "email": false,
                    "phone": false
                }
            },
            "helpText": "",
            "message": "",
            "messageAfter": "",
            "values": [
                "text",
                "text 2"
            ],
            "errors": []
        },
        {
            "id": 15,
            "options": {
                "typeKey": "button",
                "name": "button",
                "settings": {
                    "required": false,
                    "multiple": false
                }
            },
            "helpText": "",
            "message": "",
            "messageAfter": "",
            "values": [],
            "errors": []
        }
    ]

    const outputFields = processFields(fields)
    expect(outputFields[0].values).toStrictEqual([{
        id: 0,
        value: 'text'
    }, {
        id: 1,
        value: 'text 2'
    }])

    expect(outputFields[1].emptyValue).toStrictEqual({
        value: {
            label: '',
            url: '',
            class: '',
            id: '',
            target: ''
        }
    })
})

test('assignNewIdsToComboValueObj creates a unique id per field inside a combo, for empty value', () => {
    const fields = [{
        "id": 20,
        "options": {
            "typeKey": "combo",
            "name": "Multi Combo",
            "settings": {
                "multiple": true
            }
        },
        "helpText": "",
        "message": "",
        "messageAfter": "",
        "fields": [{
                "id": 22,
                "options": {
                    "typeKey": "text",
                    "name": "single text",
                    "settings": {
                        "required": false,
                        "multiline": false,
                        "multiple": false,
                        "minlength": 0,
                        "maxlength": 0,
                        "url": false,
                        "integer": false,
                        "float": false,
                        "email": false,
                        "phone": false
                    }
                },
                "helpText": "",
                "message": "",
                "messageAfter": ""
            },
            {
                "id": 1,
                "options": {
                    "typeKey": "boolean",
                    "name": "boolean",
                    "settings": {
                        "initial_value": "0"
                    }
                },
                "helpText": "",
                "message": "",
                "messageAfter": ""
            },
            {
                "id": 15,
                "options": {
                    "typeKey": "button",
                    "name": "button",
                    "settings": {
                        "required": false,
                        "multiple": false
                    }
                },
                "helpText": "",
                "message": "",
                "messageAfter": ""
            }
        ],
        "values": [],
        "errors": []
    }]

    const [combo] = processFields(fields)
    const emptyValue = JSON.parse(JSON.stringify(combo.emptyValue))
    const newIdsForValueObj = assignNewIdsToComboValueObj(combo.emptyValue)

    expect(newIdsForValueObj['1'][0].id !== emptyValue['1'][0].id).toBeTruthy()
})

test('assignNewIdsToComboValueObj creates a unique id per field inside a combo, for existing valueObj', () => {
    const comboValueObj = {
        1: [{
            value: 'test',
            id: 0
        }, {
            value: 'test 2',
            id: 1
        }],
        2: [{
            value: {
                lat: '0.123',
                lng: '12.312'
            },
            id: 0
        }]
    }

    const emptyValue = JSON.parse(JSON.stringify(comboValueObj))
    const newIdsForValueObj = assignNewIdsToComboValueObj(comboValueObj)

    expect(newIdsForValueObj['1'][0].id !== emptyValue['1'][0].id).toBeTruthy()
})

test('getField with an invalid id, should return undefined', () => {
    const state = {
        fields: [{
            "id": 2,
            "options": {
                "typeKey": "text",
                "name": "multi text",
                "settings": {
                    "required": false,
                    "multiline": false,
                    "multiple": true,
                    "minlength": 0,
                    "maxlength": 0,
                    "url": false,
                    "integer": false,
                    "float": false,
                    "email": false,
                    "phone": false
                }
            },
            "helpText": "",
            "message": "",
            "messageAfter": "",
            "values": [
                "text",
                "text 2"
            ],
            "errors": []
        }]
    }

    const field = getField(state, null)
    expect(field).toBeUndefined()
})

test('getField with valid id, should return field obj', () => {
    const state = {
        fields: [{
            "id": 2,
            "options": {
                "typeKey": "text",
                "name": "multi text",
                "settings": {
                    "required": false,
                    "multiline": false,
                    "multiple": true,
                    "minlength": 0,
                    "maxlength": 0,
                    "url": false,
                    "integer": false,
                    "float": false,
                    "email": false,
                    "phone": false
                }
            },
            "helpText": "",
            "message": "",
            "messageAfter": "",
            "values": [
                "text",
                "text 2"
            ],
            "errors": []
        }]
    }

    const field = getField(state, 2)
    expect(field.id).toBe(2)
})
