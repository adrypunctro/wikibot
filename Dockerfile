FROM python:3-onbuild
COPY runbot.py .
COPY docker-compose.yml .
RUN pip install wikipedia
CMD [ "python", "./runbot.py" ]
