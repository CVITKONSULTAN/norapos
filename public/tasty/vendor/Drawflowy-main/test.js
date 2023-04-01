const fetch = require('node-fetch');

const data_json = {
    "scrdata_id": 1164,
    "sp_name": "OK",
    "lab_test": 1,
    "session_id": "WAfd8b19b7-144d-42ac-beee-bad44b1d7b23",
    "session_exp": "2021-02-12T02:57:45.453422",
    "status": "OK",
    "item_id": 0,
    "max_row_per_page": 50,
    "search_term": "",
    "search_term_header": "",
    "pagination": 1,
    "custom_sname": ""
};

const originalUrl = 'https://tastypoints.io/akm/restapi.php';

const
    corsApiUrl = 'https://valerii.educationhost.cloud/index.php?csurl='
// corsApiUrl = 'https://thingproxy.freeboard.io/fetch/'
// corsApiUrl = 'http://www.whateverorigin.org/get?url='

const url = corsApiUrl + originalUrl;

fetch(url, {
    method: 'post',
    body: JSON.stringify({
        input: data_json
    }),
    headers: {
        'Content-Type': 'application/json',
        'accept': 'application/json'
    }
}).then(async r => console.log(await r.json()))