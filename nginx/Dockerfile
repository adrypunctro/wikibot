FROM python:3-onbuild
ADD . /todo
WORKDIR /todo
COPY runbot.py ./todo/runbot.py
COPY requirements.txt ./todo/requirements.txt
RUN pip install -r requirements.txt
