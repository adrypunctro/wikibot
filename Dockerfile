FROM python:3-onbuild
ADD . /todo
WORKDIR /todo
RUN pip install -r requirements.txt
