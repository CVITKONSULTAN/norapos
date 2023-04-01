const fetch = require('node-fetch');

const data_json = {
    "scrdata_id": 1154,
    "sp_name": "OK",
    "session_id": "WAfd8b19b7-144d-42ac-beee-bad44b1d7b23",
    "session_exp": "2021-03-12T14:33:57.790501",
    "status": "OK",
    "item_id": 0,
    "max_row_per_page": 50,
    "search_term": "",
    "search_term_header": "",
    "pagination": 1,
    "flow_nodes_group": [{
        "id": 0,
        "node_group_order": 1,
        "node_group_name": "New category 3",
        "node_group_description": "New Category"
    }]
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
}).then(r => console.log(r.headers))