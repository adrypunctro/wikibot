FROM python:3-onbuild
ADD . /todo
WORKDIR /todo
COPY runbot.py .
COPY requirements.txt .
RUN pip install -r requirements.txt
