FROM python:3-onbuild
COPY runbot.py
CMD [ "python", "./runbot.py" ]
