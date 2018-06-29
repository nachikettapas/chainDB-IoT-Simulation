from app import app
from flask import request
from bigchaindb_driver import BigchainDB
from bigchaindb_driver.crypto import generate_keypair
import json
import pprint
from pymongo import MongoClient

bdb_root_url = 'http://172.17.5.188:9984'
bdb = BigchainDB(bdb_root_url)
client = MongoClient('localhost', 32771)
print(client.database_names())
@app.route('/')
@app.route('/index')
def index():
    return "Hello, World!"

@app.route('/sensor', methods= ['POST'])
def sensor():
    print(json.loads(request.get_data()))
    #curl -d "{'temp':'30'}" -H "Content-Type: application/json" -X POST  http://localhost:500
    # alice, bob = generate_keypair(), generate_keypair()
    # bicycle_asset = {
    #     'data': json.loads(request.data)[0]
    # }
    # prepared_creation_tx = bdb.transactions.prepare(
    # operation='CREATE',
    # signers=alice.public_key,
    # asset=bicycle_asset)
    # fulfilled_creation_tx = bdb.transactions.fulfill(
    # prepared_creation_tx,
    # private_keys=alice.private_key)
    # sent_creation_tx = bdb.transactions.send_commit(fulfilled_creation_tx)

    return request.data

@app.route('/retrieve/<resource_id>', methods=['GET'])
def retrieve(resource_id):
    db = client['bigchain']
    readings = db.assets
    for reading in readings.find({"data.reading.type":"temperature"}):
        pprint.pprint(reading)
    return 'Data will come.{}'.format(resource_id)