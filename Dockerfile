FROM python:3.11-slim

WORKDIR /app

COPY python-service/requirements.txt .
RUN pip install --no-cache-dir -r requirements.txt

COPY python-service/ .

EXPOSE 8080

CMD ["python", "app.py"]
