from flask import Flask
from flask import request
from flask import jsonify
from pymongo import MongoClient
import os

#### CONFIG ##############################

#
db_host = os.environ.get('DB_PORT_27017_TCP_ADDR', '127.0.0.1')
db_port = 27017

##########################################

app = Flask(__name__)

# MongoDb connect
client = MongoClient(db_host, db_port)
db = client.wiki_app

@app.route('/', methods=['GET', 'POST'])
def index():
    if request.method == 'GET':
        day = request.args.get('day')
        year = request.args.get('year')
        category = request.args.get('category')
        keywords = request.args.get('keywords')

        condition = {}
        if day is not None:
            condition['day'] = day
        if year is not None:
            condition['year'] = year
        if category is not None:
            condition['category'] = category
        if keywords is not None:
            condition['$text'] = {'$search': keywords}
        
        cursor = db.articles.find(condition)
        results = []
        for document in cursor:
            results.append( {'year':document['year'],
                             'day':document['day'],
                             'category':document['category'],
                             'title':document['title']} );
        
        return jsonify({ 'results': results })
    else:
        return "Not valid!"
    


if __name__ == "__main__":
    app.run(host='0.0.0.0')
