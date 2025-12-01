import os
from flask import Flask, request, jsonify
import predict_survey  # import your module

app = Flask(__name__)

# Healthcheck route
@app.route("/")
def home():
    return "Service is running"

# Prediction route
@app.route("/predict", methods=["POST"])
def predict():
    try:
        data = request.get_json()

        # Initialize model/encoders once
        if not hasattr(predict_survey, "model"):
            predict_survey.init()

        # Run prediction
        result = predict_survey.predict(data)

        return jsonify(result)
    except Exception as e:
        return jsonify({"error": str(e)}), 500

if __name__ == "__main__":
    port = int(os.environ.get("PORT", 8080))  # Railway sets PORT
    app.run(host="0.0.0.0", port=port)