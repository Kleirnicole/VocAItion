FROM python:3.11-slim as builder

WORKDIR /app
COPY python-service/requirements.txt .
RUN pip install --user --no-cache-dir -r requirements.txt

FROM python:3.11-slim

WORKDIR /app

# Copy only runtime dependencies from builder
COPY --from=builder /root/.local /root/.local
ENV PATH=/root/.local/bin:$PATH

# Copy application files
COPY python-service/ .

EXPOSE 8080

CMD ["python", "app.py"]
