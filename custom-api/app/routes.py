from app import app
from flask import request
from bigchaindb_driver import BigchainDB
from bigchaindb_driver.crypto import generate_keypair
import json
import pprint
from pymongo import MongoClient

bdb_root_url = 'http://localhost:9984'
bdb = BigchainDB(bdb_root_url)
client = MongoClient('localhost', 32768)
print(client.database_names())
db = client['bigchain']
collection = db.assets
@app.route('/')
@app.route('/index')
def index():
    return "Hello, World!"

@app.route('/sensor', methods= ['POST'])
def sensor():
    print(request)
    print(json.loads(request.get_data()))
    # curl -d "{'temp':'30'}" -H "Content-Type: application/json" -X POST  http://localhost:500
    alice, bob = generate_keypair(), generate_keypair()
    bicycle_asset = {
        'data': json.loads(request.get_data())
    }
    prepared_creation_tx = bdb.transactions.prepare(
    operation='CREATE',
    signers=alice.public_key,
    asset=bicycle_asset)
    fulfilled_creation_tx = bdb.transactions.fulfill(
    prepared_creation_tx,
    private_keys=alice.private_key)
    sent_creation_tx = bdb.transactions.send_commit(fulfilled_creation_tx)

    return request.get_data()

@app.route('/retrieve/<resource_id>/<sensor_type>', methods=['GET'])
def retrieve(resource_id, sensor_type):
    db = client['bigchain']
    readings = db.assets
    for reading in readings.find({"data.reading.type": sensor_type }):
        pprint.pprint(reading)
    return 'Data will come.{} - {}'.format(resource_id, sensor_type)

@app.route('/retrieve/sensors', methods=['GET'])
def retreiveList():
    return json.dumps({"result": [  
      "2a428eae-4edf-c5d0-08be-22d13ea092fd",
   ]})
@app.route('/boards', methods=['GET'])
def sensors():
    boards = []
    for board in collection.find({"data.entity": "board"}):
        boards.append(board['data'])
    # print (boards[0]['data'])
    jsonData = json.dumps({
        "result" : boards
        })

#     jsonData= json.dumps(
#         {  
#    "result":[  
    #   {  
    #      "entity" : "board",
    #      "id":"94663111-7227-4b9e-95e2-1c39f41867a0",
    #      "state":"active",
    #      "resources":[  
    #         {  
    #            "cache_last_updated":'null',
    #            "package_id":"94663111-7227-4b9e-95e2-1c39f41867a0",
    #            "webstore_last_updated":'null',
    #            "id":"c1352d7d-3016-42d6-adcc-55d182ca94a7",
    #            "size":'null',
    #            "state":"active",
    #            "hash":"",
    #            "description":"",
    #            "format":"",
    #            "tracking_summary":{  
    #               "total":0,
    #               "recent":0
    #            },
    #            "last_modified":'null',
    #            "url_type":"datastore",
    #            "mimetype":'null',
    #            "cache_url":'null',
    #            "name":"sensors",
    #            "created":"2016-03-22T11:57:37.088450",
    #            "url":"/datastore/dump/c1352d7d-3016-42d6-adcc-55d182ca94a7",
    #            "webstore_url":'null',
    #            "mimetype_inner":'null',
    #            "position":0,
    #            "revision_id":"d3244059-7b16-4093-ba14-1f379290ee93",
    #            "resource_type":'null'
    #         },
    #         {  
    #            "cache_last_updated":'null',
    #            "package_id":"94663111-7227-4b9e-95e2-1c39f41867a0",
    #            "webstore_last_updated":'null',
    #            "id":"23594d30-0b38-4967-97ef-c961fd9fdbdb",
    #            "size":'null',
    #            "state":"active",
    #            "hash":"",
    #            "description":"",
    #            "format":"",
    #            "tracking_summary":{  
    #               "total":0,
    #               "recent":0
    #            },
    #            "last_modified":'null',
    #            "url_type":"datastore",
    #            "mimetype":'null',
    #            "cache_url":'null',
    #            "name":"temperature",
    #            "created":"2016-03-22T11:57:39.643489",
    #            "url":"/datastore/dump/23594d30-0b38-4967-97ef-c961fd9fdbdb",
    #            "webstore_url":'null',
    #            "mimetype_inner":'null',
    #            "position":1,
    #            "revision_id":"da6c9856-252d-43b6-87d2-c912609d367f",
    #            "resource_type":'null'
    #         },
    #         {  
    #            "cache_last_updated":'null',
    #            "package_id":"94663111-7227-4b9e-95e2-1c39f41867a0",
    #            "webstore_last_updated":'null',
    #            "id":"93c39ba9-74cf-4461-b60a-9a206c7fc416",
    #            "size":'null',
    #            "state":"active",
    #            "hash":"",
    #            "description":"",
    #            "format":"",
    #            "tracking_summary":{  
    #               "total":0,
    #               "recent":0
    #            },
    #            "last_modified":'null',
    #            "url_type":"datastore",
    #            "mimetype":'null',
    #            "cache_url":'null',
    #            "name":"brightness",
    #            "created":"2016-03-22T11:57:41.209500",
    #            "url":"/datastore/dump/93c39ba9-74cf-4461-b60a-9a206c7fc416",
    #            "webstore_url":'null',
    #            "mimetype_inner":'null',
    #            "position":2,
    #            "revision_id":"777d448f-81d1-4f60-956f-6e794956b41b",
    #            "resource_type":'null'
    #         },
    #         {  
    #            "cache_last_updated":'null',
    #            "package_id":"94663111-7227-4b9e-95e2-1c39f41867a0",
    #            "webstore_last_updated":'null',
    #            "id":"39644c35-dc8e-4f72-89d3-06ce225d0d42",
    #            "size":'null',
    #            "state":"active",
    #            "hash":"",
    #            "description":"",
    #            "format":"",
    #            "tracking_summary":{  
    #               "total":0,
    #               "recent":0
    #            },
    #            "last_modified":'null',
    #            "url_type":"datastore",
    #            "mimetype":'null',
    #            "cache_url":'null',
    #            "name":"humidity",
    #            "created":"2016-03-22T11:57:42.510221",
    #            "url":"/datastore/dump/39644c35-dc8e-4f72-89d3-06ce225d0d42",
    #            "webstore_url":'null',
    #            "mimetype_inner":'null',
    #            "position":3,
    #            "revision_id":"02c6bbd0-5ad8-4838-9cde-fead61de858a",
    #            "resource_type":'null'
    #         },
    #         {  
    #            "cache_last_updated":'null',
    #            "package_id":"94663111-7227-4b9e-95e2-1c39f41867a0",
    #            "webstore_last_updated":'null',
    #            "id":"ad22222f-932b-411b-8e36-2df43b6f402b",
    #            "size":'null',
    #            "state":"active",
    #            "hash":"",
    #            "description":"",
    #            "format":"",
    #            "tracking_summary":{  
    #               "total":0,
    #               "recent":0
    #            },
    #            "last_modified":'null',
    #            "url_type":"datastore",
    #            "mimetype":'null',
    #            "cache_url":'null',
    #            "name":"pressure",
    #            "created":"2016-03-22T11:57:45.599297",
    #            "url":"/datastore/dump/ad22222f-932b-411b-8e36-2df43b6f402b",
    #            "webstore_url":'null',
    #            "mimetype_inner":'null',
    #            "position":4,
    #            "revision_id":"b4e0bc0d-2a3c-4df2-a9f5-279c7757b1df",
    #            "resource_type":'null'
    #         },
    #         {  
    #            "cache_last_updated":'null',
    #            "package_id":"94663111-7227-4b9e-95e2-1c39f41867a0",
    #            "webstore_last_updated":'null',
    #            "id":"348d4312-a888-4a74-82cf-b123f45b1c23",
    #            "size":'null',
    #            "state":"active",
    #            "hash":"",
    #            "description":"",
    #            "format":"",
    #            "tracking_summary":{  
    #               "total":0,
    #               "recent":0
    #            },
    #            "last_modified":'null',
    #            "url_type":"datastore",
    #            "mimetype":'null',
    #            "cache_url":'null',
    #            "name":"gas",
    #            "created":"2016-03-22T11:57:47.841044",
    #            "url":"/datastore/dump/348d4312-a888-4a74-82cf-b123f45b1c23",
    #            "webstore_url":'null',
    #            "mimetype_inner":'null',
    #            "position":5,
    #            "revision_id":"b95f1ca0-2c1b-4eb0-a708-f44443c73c16",
    #            "resource_type":'null'
    #         },
    #         {  
    #            "cache_last_updated":'null',
    #            "package_id":"94663111-7227-4b9e-95e2-1c39f41867a0",
    #            "webstore_last_updated":'null',
    #            "id":"9d2d9107-615c-4f33-a000-37aade0b977d",
    #            "size":'null',
    #            "state":"active",
    #            "hash":"",
    #            "description":"",
    #            "format":"",
    #            "tracking_summary":{  
    #               "total":0,
    #               "recent":0
    #            },
    #            "last_modified":'null',
    #            "url_type":"datastore",
    #            "mimetype":'null',
    #            "cache_url":'null',
    #            "name":"noise",
    #            "created":"2016-03-22T11:57:49.038313",
    #            "url":"/datastore/dump/9d2d9107-615c-4f33-a000-37aade0b977d",
    #            "webstore_url":'null',
    #            "mimetype_inner":'null',
    #            "position":6,
    #            "revision_id":"b80b2316-1d94-4e41-825c-6b53c8ca7d86",
    #            "resource_type":'null'
    #         }
    #      ],
    #      "name":"2a428eae-4edf-c5d0-08be-22d13ea092fd",
    #      "extras":[  
    #         {  
    #            "key":"Altitude",
    #            "value":"19"
    #         },
    #         {  
    #            "key":"Label",
    #            "value":"Facolt\u00e0 Ingegneria"
    #         },
    #         {  
    #            "key":"Latitude",
    #            "value":"38.25947"
    #         },
    #         {  
    #            "key":"Longitude",
    #            "value":"15.59541"
    #         },
    #         {  
    #            "key":"Manufacturer",
    #            "value":"Arduino"
    #         },
    #         {  
    #            "key":"Model",
    #            "value":"Yun"
    #         }
    #      ]
    #   }
#    ]
# }

#     )  
    return 'GetCKAN({})'.format(jsonData)

@app.route('/boards/<board_id>', methods = ['GET'])
def board_by_id(board_id):
    board = collection.find_one({'data.result.entity':'board', 'data.result.id' : board_id})
    return json.dumps(board['data'])

@app.route('/sensors/<sensor_id>')
def sensor_by_id(sensor_id):
    limit = request.args.get('limit')
    readings = []
    for reading in collection.find({"data.result.entity": "board"}):
        boards.append(board)
    print (boards[0]['data'])
    return 'Sensor {} with it\'s readings and limit as {}'.format(sensor_id, limit)