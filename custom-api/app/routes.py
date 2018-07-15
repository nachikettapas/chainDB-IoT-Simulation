from app import app
from flask import request
from bigchaindb_driver import BigchainDB
from bigchaindb_driver.crypto import generate_keypair
import json
import pprint
import rapidjson
from pymongo import MongoClient
from cryptoconditions import Fulfillment
from flask import render_template
from sha3 import sha3_256

bdb_root_url = 'http://localhost:9984'
bdb = BigchainDB(bdb_root_url)
client = MongoClient('localhost', 32768)
print(client.database_names())
db = client['bigchain']
collection = db.assets
transactions = db.transactions
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

@app.route('/hello', methods= ['GET'])
def helloWorld():
    alice, bob = generate_keypair(), generate_keypair()    
    bicycle_asset = {
        'data': {
            'message' : 'hello'
            }
    }
    prepared_creation_tx = bdb.transactions.prepare(
    operation='CREATE',
    signers=alice.public_key,
    asset=bicycle_asset)
    fulfilled_creation_tx = bdb.transactions.fulfill(
    prepared_creation_tx,
    private_keys=alice.private_key)
    sent_creation_tx = bdb.transactions.send_commit(fulfilled_creation_tx)

    return 'hello {}'.format(sent_creation_tx)

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
    board = collection.find_one({'data.entity':'board', 'data.id' : board_id})
    response = app.response_class(
        response=json.dumps({"result" : board['data']}),
        status=200,
        mimetype='application/json;charset=utf-8'
    )
    return response
    print('hello')
    # return json.dumps({"help": "http://smartme-data.unime.it/api/3/action/help_show?name=package_show", "success": true, "result": {"license_title": "Creative Commons Attribution", "maintainer": "", "relationships_as_object": [], "private": false, "maintainer_email": "", "num_tags": 1, "id": "94663111-7227-4b9e-95e2-1c39f41867a0", "metadata_created": "2016-03-22T10:57:34.726232", "metadata_modified": "2017-09-13T08:17:08.371045", "author": "", "author_email": "", "state": "active", "version": "", "creator_user_id": "2e34f767-995f-4144-8234-bbd5687b69c8", "type": "dataset", "resources": [{"cache_last_updated": null, "package_id": "94663111-7227-4b9e-95e2-1c39f41867a0", "webstore_last_updated": null, "datastore_active": true, "id": "c1352d7d-3016-42d6-adcc-55d182ca94a7", "size": null, "state": "active", "hash": "", "description": "", "format": "", "tracking_summary": {"total": 0, "recent": 0}, "last_modified": null, "url_type": "datastore", "mimetype": null, "cache_url": null, "name": "sensors", "created": "2016-03-22T11:57:37.088450", "url": "/datastore/dump/c1352d7d-3016-42d6-adcc-55d182ca94a7", "webstore_url": null, "mimetype_inner": null, "position": 0, "revision_id": "d3244059-7b16-4093-ba14-1f379290ee93", "resource_type": null}, {"cache_last_updated": null, "package_id": "94663111-7227-4b9e-95e2-1c39f41867a0", "webstore_last_updated": null, "datastore_active": true, "id": "23594d30-0b38-4967-97ef-c961fd9fdbdb", "size": null, "state": "active", "hash": "", "description": "", "format": "", "tracking_summary": {"total": 0, "recent": 0}, "last_modified": null, "url_type": "datastore", "mimetype": null, "cache_url": null, "name": "temperature", "created": "2016-03-22T11:57:39.643489", "url": "/datastore/dump/23594d30-0b38-4967-97ef-c961fd9fdbdb", "webstore_url": null, "mimetype_inner": null, "position": 1, "revision_id": "da6c9856-252d-43b6-87d2-c912609d367f", "resource_type": null}, {"cache_last_updated": null, "package_id": "94663111-7227-4b9e-95e2-1c39f41867a0", "webstore_last_updated": null, "datastore_active": true, "id": "93c39ba9-74cf-4461-b60a-9a206c7fc416", "size": null, "state": "active", "hash": "", "description": "", "format": "", "tracking_summary": {"total": 0, "recent": 0}, "last_modified": null, "url_type": "datastore", "mimetype": null, "cache_url": null, "name": "brightness", "created": "2016-03-22T11:57:41.209500", "url": "/datastore/dump/93c39ba9-74cf-4461-b60a-9a206c7fc416", "webstore_url": null, "mimetype_inner": null, "position": 2, "revision_id": "777d448f-81d1-4f60-956f-6e794956b41b", "resource_type": null}, {"cache_last_updated": null, "package_id": "94663111-7227-4b9e-95e2-1c39f41867a0", "webstore_last_updated": null, "datastore_active": true, "id": "39644c35-dc8e-4f72-89d3-06ce225d0d42", "size": null, "state": "active", "hash": "", "description": "", "format": "", "tracking_summary": {"total": 0, "recent": 0}, "last_modified": null, "url_type": "datastore", "mimetype": null, "cache_url": null, "name": "humidity", "created": "2016-03-22T11:57:42.510221", "url": "/datastore/dump/39644c35-dc8e-4f72-89d3-06ce225d0d42", "webstore_url": null, "mimetype_inner": null, "position": 3, "revision_id": "02c6bbd0-5ad8-4838-9cde-fead61de858a", "resource_type": null}, {"cache_last_updated": null, "package_id": "94663111-7227-4b9e-95e2-1c39f41867a0", "webstore_last_updated": null, "datastore_active": true, "id": "ad22222f-932b-411b-8e36-2df43b6f402b", "size": null, "state": "active", "hash": "", "description": "", "format": "", "tracking_summary": {"total": 0, "recent": 0}, "last_modified": null, "url_type": "datastore", "mimetype": null, "cache_url": null, "name": "pressure", "created": "2016-03-22T11:57:45.599297", "url": "/datastore/dump/ad22222f-932b-411b-8e36-2df43b6f402b", "webstore_url": null, "mimetype_inner": null, "position": 4, "revision_id": "b4e0bc0d-2a3c-4df2-a9f5-279c7757b1df", "resource_type": null}, {"cache_last_updated": null, "package_id": "94663111-7227-4b9e-95e2-1c39f41867a0", "webstore_last_updated": null, "datastore_active": true, "id": "348d4312-a888-4a74-82cf-b123f45b1c23", "size": null, "state": "active", "hash": "", "description": "", "format": "", "tracking_summary": {"total": 0, "recent": 0}, "last_modified": null, "url_type": "datastore", "mimetype": null, "cache_url": null, "name": "gas", "created": "2016-03-22T11:57:47.841044", "url": "/datastore/dump/348d4312-a888-4a74-82cf-b123f45b1c23", "webstore_url": null, "mimetype_inner": null, "position": 5, "revision_id": "b95f1ca0-2c1b-4eb0-a708-f44443c73c16", "resource_type": null}, {"cache_last_updated": null, "package_id": "94663111-7227-4b9e-95e2-1c39f41867a0", "webstore_last_updated": null, "datastore_active": true, "id": "9d2d9107-615c-4f33-a000-37aade0b977d", "size": null, "state": "active", "hash": "", "description": "", "format": "", "tracking_summary": {"total": 0, "recent": 0}, "last_modified": null, "url_type": "datastore", "mimetype": null, "cache_url": null, "name": "noise", "created": "2016-03-22T11:57:49.038313", "url": "/datastore/dump/9d2d9107-615c-4f33-a000-37aade0b977d", "webstore_url": null, "mimetype_inner": null, "position": 6, "revision_id": "b80b2316-1d94-4e41-825c-6b53c8ca7d86", "resource_type": null}], "num_resources": 7, "tags": [{"vocabulary_id": null, "state": "active", "display_name": "testbed", "id": "79839c0f-578f-4aa8-8976-5aa6dc2be07b", "name": "testbed"}], "tracking_summary": {"total": 0, "recent": 0}, "groups": [], "license_id": "cc-by", "relationships_as_subject": [], "organization": {"description": "", "created": "2015-06-19T15:47:53.874302", "title": "SmartMe", "name": "smartme", "is_organization": true, "state": "active", "image_url": "http://smartme.unime.it/img/logo_smartme.png", "revision_id": "00ae96e7-e02f-4691-b324-5822feefad8b", "type": "organization", "id": "48ed6f9e-22b9-4286-a3dc-11fd16f28b98", "approval_status": "approved"}, "name": "2a428eae-4edf-c5d0-08be-22d13ea092fd", "isopen": true, "url": "", "notes": "sme-00-0030 - Facolt\u00e0 Ingegneria", "owner_org": "48ed6f9e-22b9-4286-a3dc-11fd16f28b98", "extras": [{"key": "Altitude", "value": "19"}, {"key": "Label", "value": "Facolt\u00e0 Ingegneria"}, {"key": "Latitude", "value": "38.25947"}, {"key": "Longitude", "value": "15.59541"}, {"key": "Manufacturer", "value": "Arduino"}, {"key": "Model", "value": "Yun"}], "license_url": "http://www.opendefinition.org/licenses/cc-by", "title": "2a428eae-4edf-c5d0-08be-22d13ea092fd", "revision_id": "e3db1068-d7c0-48a7-b585-8ac0e76ffcad"}})

@app.route('/sensors/<sensor_id>', methods = ['GET', 'POST'])
def sensor_by_id(sensor_id):
    if request.method == 'POST':
        print(json.loads(request.get_data()))
        # curl -d "{'temp':'30'}" -H "Content-Type: application/json" -X POST  http://localhost:500
        alice, bob = generate_keypair(), generate_keypair()
        print(alice,bob)
        for singleReading in json.loads(request.get_data()):
            bicycle_asset = {
                'data': singleReading
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

    else:
        limit = int(request.args.get('limit'))
        print("limit is {}".format(limit))
        readings = []
        for index, reading in enumerate(collection.find({"data.entity": "reading","data.resource_id":sensor_id})):
            if index == limit:
                break
            readings.append(reading['data'])
        # try:
        print (readings)
        return json.dumps(
            {
                "result" : 
                {
                    "records" : readings
                }
            }
        )
@app.route('/sensors/<sensor_id>/graph', methods=['GET'])
def drawGraph(sensor_id):
    points = []
    for point in collection.find({"data.entity": "reading","data.resource_id":sensor_id}):
        graphPoint={}
        try:
            readingType = point['data']['type']            
            graphPoint['y']=point['data'][readingType]
            graphPoint['x']=point['data']['Date']
            graphPoint['unique'] = point['id']
            points.append(graphPoint)
        except:
            continue
    # try:
    print (points)
    # return json.dumps(
    #     {
    #         "result" : 
    #         {
    #             "records" : readings
    #         }
    #     }
    # )
    return json.dumps({"result": {"records": points}})

@app.route('/verify/<reading_id>', methods = ['GET'])
def verify(reading_id):
    transaction = transactions.find_one({"id":reading_id})
    reading = collection.find_one({"id":reading_id})
    formatted_reading = format_reading(reading)
    public_key = transaction['outputs'][0]['condition']['details']['public_key']
    uri = transaction['outputs'][0]['condition']['uri']
    fulfillment = Fulfillment.from_uri(transaction['inputs'][0]['fulfillment']).to_dict()
    print(fulfillment)
    signature = fulfillment['signature']
    message=generate_message(reading['data'], public_key, uri)
    return json.dumps({"reading":formatted_reading,"message":str(message),"public_key":str(public_key),"signature":str(signature)})

def generate_message(content, public_key, uri):
    content = rapidjson.dumps(content, skipkeys=False, ensure_ascii=False, sort_keys=True)
    message = '{{"asset":{{"data":{}}},"id":null,"inputs":[{{"fulfillment":null,"fulfills":null,"owners_before":["{}"]}}],"metadata":null,"operation":"CREATE","outputs":[{{"amount":"1","condition":{{"details":{{"public_key":"{}","type":"ed25519-sha-256"}},"uri":"{}"}},"public_keys":["{}"]}}],"version":"2.0"}}'.format(content, public_key, public_key, uri, public_key)
    msg_list = []
    return message

def format_reading(reading):
    reading = reading['data']
    print(reading)
    formatted_reading = {}
    formatted_reading[reading['type']]=reading[reading['type']]
    formatted_reading['Altitude'] = reading['Altitude']
    formatted_reading['Longitude'] = reading['Longitude']
    formatted_reading['Latitude'] = reading['Latitude']
    formatted_reading['Date'] = reading['Date']
    return json.dumps(formatted_reading)

@app.route('/verify', methods = ['GET'])
def verification_form():
    # return render_template('verify-old.html')
    return render_template('index.html')
    

@app.route('/hash', methods=['POST'])
def generate_hash():
    if request.method == 'POST':
        message_string = request.get_data()
        # print (bytes.fromhex(sha3_256(message_string).hexdigest()))
        return sha3_256(message_string).hexdigest()

@app.route('/verify/signature', methods=['POST'])
def verify_signature():
    if request.method == 'POST':
        request_json = json.loads(request.get_data())
        # print(request_json['message'])
        request_json['type']='ed25519-sha-256'
        fulfillment_object = Fulfillment.from_dict(request_json)
        encoded_message = sha3_256(request_json['message'].encode()).digest()
        # print(request_json['hash'])
        decoded_message = bytes.fromhex(request_json['hash'])
        # response = {"result": fulfillment_object.validate(message=encoded_message)}
        response = {"result": fulfillment_object.validate(message=decoded_message)}        
        return json.dumps(response)
# def reorder_content(content, public_key, uri):
