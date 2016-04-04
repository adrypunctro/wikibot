# create_db.py
from pymongo import MongoClient
c = MongoClient()
db = c.wiki_app
collection = db.articles
