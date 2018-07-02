from app import app
from flask import request
from bigchaindb_driver import BigchainDB
from bigchaindb_driver.crypto import generate_keypair
import json
import pprint
from pymongo import MongoClient

bdb_root_url = 'http://172.17.5.188:9984'
bdb = BigchainDB(bdb_root_url)
client = MongoClient('localhost', 32768)
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
      "0000",
      "01",
      "051f5207-a93f-4a81-aa6c-924af7a67663",
      "0775f8d2-829e-d0b7-2107-06bbd58b92ea",
      "09f444a5-29ec-4d33-a4a5-2e77f5cceed8",
      "12345678",
      "1297a978-d892-4ad4-bb3d-786d2a811147",
      "13a4f230-bb4c-446f-8338-9302db1c5bc9",
      "1ac93808-b7fd-0df3-7677-7ddd7c49fe4c",
      "1cb0fa5c-7baa-0f2b-9d53-4ac0ec8fae5d",
      "1f8fbf21-c11e-4db2-6f8e-3c8805db2c48",
      "210425b0-5e0a-546e-0c1d-031f68e7274e",
      "239eb9bd-4bbb-f270-383c-e97091bd4c68",
      "26735fae-42c3-0897-545c-221b62e7a975",
      "298b8ab1-f420-5272-4ed0-7d542a41b87b",
      "2a428eae-4edf-c5d0-08be-22d13ea092fd",
      "2aee98a4-1dc7-48c7-b17e-72a1ab7c0c82",
      "2e044326-9e88-6374-6809-64f829494e4d",
      "313850df-cced-aa8d-ddf0-22700a3ee299",
      "37968a32-de3b-9fc4-7eeb-ca76ba14b44b",
      "3aa27a6a-956d-417a-8703-175ec602c576",
      "3f3eb5f5-c122-e8d9-9d0f-5c71d9286274",
      "467a2703-6cc3-b720-05dc-88fcaf430877",
      "47abcdfe-15ae-0993-a997-4084f293c8f4",
      "48d1b805-88fb-914c-9ae6-f0ced9fcc571",
      "50750768-3574-f2b3-0ebe-dd04861a1dda",
      "5c7fdb2d-7922-4678-885a-479d0ccaa6a9",
      "66bc0a8f-cdba-6869-3fb1-fbc0b9d07e9e",
      "6ad2a344-a0fd-d20b-e26d-29bc757c5412",
      "6bc01f9d-cfd2-5cb2-4d7b-5c883aa28ec7",
      "6ca07629-1fcd-5f39-8cf0-cd0d300f3b79",
      "6ea95f9d-6249-4db3-9dbc-a1a2cf3738fc",
      "7955abff-a6e7-4b74-2960-48d80a611fa2",
      "878a400f-db7f-4d61-a694-cceee606f2fd",
      "96b69f1f-0188-48cc-abdc-d10674144c68",
      "9f123f5d-0da4-3b3d-ad71-8bc4b5f3efdd",
      "a250a263-3146-169b-b3aa-5a13fc978260",
      "a2521c5d-8528-0556-c5df-b269f1822542",
      "a25e10ed-be4f-652b-ec5a-795318975eb4",
      "a427da03-f90f-42ae-b9ef-070bb690440a",
      "a88fb560-8d61-052d-c904-ad45a1be1f21",
      "a88fb560-8d61-052d-c904-ad45a1be1f22",
      "a88fb560-8d61-052d-c904-ad45a1be1f25",
      "a88fb560-8d61-052d-c904-ad45a1be1f28",
      "a88fb560-8d61-052d-c904-ad45a1be1f29",
      "aa9d96c9-9cb7-09ce-5f16-61a29cf40619",
      "ad4a7c4c-7090-d358-a176-4e80215dbebb",
      "altrotest",
      "android_0001",
      "android_0002",
      "android001",
      "android_02",
      "android_longo",
      "android_test_01",
      "android_test_02",
      "android_test_03",
      "android_test_04",
      "android_test_05",
      "android_test_06",
      "android_test_07",
      "android_test_08",
      "android_test_09",
      "android_test_10",
      "android_test_11",
      "android_test_12",
      "android_test_13",
      "android_test_14",
      "android_test_15",
      "android_test_16",
      "android_test_17",
      "android_test_18",
      "android_test_19",
      "android_test_20",
      "android_test_21",
      "android_test_23",
      "android_test_24",
      "android_test_25",
      "android_test_26",
      "android_test_27",
      "android_test_28",
      "android_test_50",
      "android_test_51",
      "android_test_52",
      "b0f90f3c-47e2-6923-81d3-57c2e2757db1",
      "b8eb3610-8e93-b1ac-afc8-248447f10911",
      "b9c102a2-cc2e-93e9-64ce-ad5df0b3d405",
      "bari1",
      "bari10",
      "bari2",
      "bari3",
      "bari4",
      "bari5",
      "bari6",
      "bari7",
      "c1c3278c-ad26-eee1-6150-ed04e47c61e3",
      "c3ceabab-7e7f-cb70-b5f0-128907a87aad",
      "c61f70b1-4f51-a1d9-8527-693301e9adb9",
      "c8a00f4f-9987-d59e-93a7-88043dafb342",
      "c9bb987a-d875-9cb4-620c-9e808ef6893d",
      "cf155fdd-133d-786a-7d42-64cea0f1019f",
      "cf9e5050-ef47-09f9-2268-cfa6402b4aa1",
      "ciam-esaving-100249",
      "ciam-esaving-100266",
      "ciam-esaving-100267",
      "como1",
      "como10",
      "como2",
      "como3",
      "como4",
      "como5",
      "como6",
      "como7",
      "como8",
      "como9",
      "comune",
      "d26d8185-c459-842c-534e-83af39ae2b8c",
      "da8f852c-f32e-db0b-d33c-851e0111f9ab",
      "datasetprova",
      "dati-del-trasporto-pubblico-urbano-atm-in-formato-gtfs",
      "dati-popolazione-ii-circoscrizione",
      "dati-popolazione-residente-iii-circoscrizione",
      "dati-popolazione-residente-iv-circoscrizione",
      "dati-popolazione-residente-v-circoscrizione",
      "dati-popolazione-residente-vi-circoscrizione",
      "e19d3266-2ac1-438d-9494-bac2a8e11d05",
      "e4bebb6d-17c8-50b8-5ed2-02c8c34888c5",
      "e6c90942-3852-05bb-de1c-c09195d38563",
      "e9bee8d9-7270-5323-d3e9-9875ba9c5753",
      "ebec5fe9-cfed-5c78-ccb3-33978a6a064d",
      "f384a118-b058-cae3-c076-773170bd0741",
      "f847c027-6eab-3963-a368-24140ca26176",
      "fe3e3b54-b401-416f-9a11-b4554c43f9aa",
      "ff4c9f0b-dded-465e-b11a-d0b0e209edde",
      "lucca14",
      "lucca35",
      "lucca36",
      "lucca57",
      "malta11",
      "malta16",
      "malta22",
      "malta26",
      "malta59",
      "malta67",
      "malta75",
      "malta91",
      "merlinomobile3",
      "mi_landslides",
      "mi_seismographs",
      "pisa10",
      "pisa2",
      "pisa3",
      "pisa4",
      "pisa5",
      "pisa6",
      "pisa7",
      "pisa8",
      "pola102",
      "pola73",
      "pola87",
      "popolazione-residente-i-circoscrizione",
      "roma1",
      "roma10",
      "roma2",
      "roma3",
      "roma4",
      "roma5",
      "roma6",
      "roma7",
      "roma8",
      "s4t-android-lr",
      "smart_lighting",
      "smartpark",
      "test4",
      "testing",
      "test-statistica",
      "test_taxi",
      "tonylongomobility",
      "tripadvisor-attractions-reviews",
      "unimetest",
      "urbanistica",
      "urbanistica2011",
      "urbanistica2012",
      "urbanistica2013",
      "urbanistica2014",
      "urbanistica2015",
      "zara41",
      "zara44",
      "zara46",
      "zara68",
      "zara79"
   ]})
    