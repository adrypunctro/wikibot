import wikipedia
import datetime

#### CONFIG ##############################

# Define whitch categories we want to get
categories = ["Events","Births","Deaths","Holidays and observances"]

# Init date interval
start_date = "01/01/15"
end_date   = "01/01/15"

# debug level
debug = 1

##########################################


# Get content from wiki
def getPage(pageName):
	return wikipedia.page(pageName)

# Model_ insert document
def addDoc(year, month_day):
        result = db.articles.insert_one(
            {
                "day": month_day,
                "year": year,
            }
        )
        return result.inserted_id

# Model_ update document
def updateDoc(doc_id, category_name, vals):
        result = db.articles.update_one(
            {"_id": doc_id},
            {
                "$set": {
                    category_name: vals
                }
            }
        )
        return result.matched_count

# Model_ get document
def getDoc(year, month_day):
        cursor = db.articles.find({"year": year, "day": month_day})
        for document in cursor:
                return document["_id"]
        return None;

# MongoDb connect
from pymongo import MongoClient
client = MongoClient()
db = client.local

# Proceed
next_date = datetime.datetime.strptime(start_date, "%d/%m/%y")
finish_date = datetime.datetime.strptime(end_date, "%d/%m/%y")
while(True):
        month_day = next_date.strftime("%B")+"_"+str(next_date.day)
        doc_id = getDoc(next_date.year, month_day);
        if doc_id is None:
                # Create document
                doc_id = addDoc(next_date.year, month_day)
        if debug == 1:
                print(month_day,end="",flush=True)
        # Get and Update all categories
        curl_page = getPage(month_day)
        for category_name in categories:
                # Get category content
                curl_sec = curl_page.section(category_name)
                if curl_sec is None:
                        # It's null, let it null
                        items = None
                else:
                        # Convert string content to array
                        items = curl_sec.splitlines()
                # Update document with category content
                updateDoc(doc_id, category_name.lower(), items)
                if debug == 1:
                        print('.',end="",flush=True)
        if debug == 1:
                print(" done")
        # Check if it's end
        if(next_date >= finish_date):
                break
        # Go next day
        next_date = next_date + datetime.timedelta(days=1)



