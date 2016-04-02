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
def addDoc(year, month_day, category_name, title):
        result = db.articles.insert_one(
            {
                "day": month_day,
                "year": year,
                "category": category_name,
                "title": title,
            }
        )
        return result.inserted_id

# Model_ remove document
def deleteDoc(year, month_day):
        result = db.articles.delete_many(
            {"year": year,"day": month_day}
        )
        return result.deleted_count

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

# Create an index if it doesn't already exist
db.articles.ensure_index("title")

# Proceed
next_date = datetime.datetime.strptime(start_date, "%d/%m/%y")
finish_date = datetime.datetime.strptime(end_date, "%d/%m/%y")
while(True):
        month_day = next_date.strftime("%B")+"_"+str(next_date.day)
        year = next_date.year
        if debug == 1:
                print(month_day,end="",flush=True)
        # Get and Update all categories
        curl_page = getPage(month_day)
        # Delete old infos
        deleteDoc(year, month_day)
        # Put new infos
        for category_name in categories:
                # Get category content
                curl_sec = curl_page.section(category_name)
                if curl_sec is not None:
                        # Convert string content to array
                        items = curl_sec.splitlines()
                        for title in items:
                                # Create document
                                addDoc(year, month_day, category_name.lower(), title)
                if debug == 1:
                        print('.',end="",flush=True)
        if debug == 1:
                print(" done")
        # Check if it's end
        if(next_date >= finish_date):
                break
        # Go next day
        next_date = next_date + datetime.timedelta(days=1)

