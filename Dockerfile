FROM python:3-onbuild
COPY runbot.py .
RUN pip install wikipedia
CMD [ "python", "./runbot.py" ]
