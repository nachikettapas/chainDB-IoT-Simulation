from app import app
from flask import request

@app.route('/')
@app.route('/index')
def index():
    return "Hello, World!"

@app.route('/sensor', methods= ['POST'])
def sensor():
    # print(request.data)
    #curl -d "{'temp':'30'}" -H "Content-Type: application/json" -X POST  http://localhost:500
    return request.data