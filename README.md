# WikiPyBot

WikiPyBot is a python script that fetches and stores the information from Wikipedia. 

To run properly this package you need:
> **Docker engine** and **Docker compose** (https://www.docker.com)

Before you build this program, you should know that this program is configurable. In **web/runbot.py**
```sh
#### CONFIG ##############################

# Define whitch categories we want to get
categories = ["Events","Births","Deaths","Holidays and observances"]

# Init date interval
start_date = "01/01/15"
end_date   = "31/12/15"

# Refresh interval (seconds)
refresh = 60*60*2 # 2h

# debug level (boolean)
debug = 0

#
db_host = os.environ.get('DB_PORT_27017_TCP_ADDR', '127.0.0.1')
db_port = 27017

##########################################
```

WikiPyBot is very easy to install and deploy in Docker by follow these steps:
1. From docker machine terminal, clone this repository
```sh
$ git clone https://github.com/adrypunctro/wikipybot.git
```
2. Enter in project folder
```sh
$ cd wikipybot
```
3. Type the command
```sh
$ docker-compose build
```
4. After it was finished, type the command
```sh
$ docker-compose up -d
```

It's done!

To access the web server get **you docker machine ip address** followed by the **port 5000**.
```sh
Like:
http://127.0.0.1:5000/
```
And you can filter the result used the parametrs:
```sh
Like:
http://127.0.0.1:5000/?year=2015&day=April_2&category=births&keywords=office
```

It return a json object (or *null* if not found)
```sh
Like:
{
  "results": [
    {
      "category": "births",
      "day": "January_1",
      "title": "870 \u2013 Zwentibold, Frankish son of Arnulf of Carinthia (d. 900)",
      "year": 2015
    },
    {
      "category": "births",
      "day": "January_1",
      "title": "1431 \u2013 Pope Alexander VI (d. 1503)",
      "year": 2015
    }
}
```


License
----

MIT


**Free Software!**
