FROM python:3-onbuild
COPY runbot.py .
RUN pip install pymongo -U
RUN pip install wikipedia
CMD [ "python", "./runbot.py" ]
