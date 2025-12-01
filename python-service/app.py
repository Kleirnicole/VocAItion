print("Starting Flask app...")

from flask import Flask, request, jsonify
from predict_survey import init, prepare_input, get_course_info, survey_to_text, predict

# Create the Flask app
app = Flask(__name__)

# Initialize models and encoders
init()

@app.route("/")
def home():
    return "AI Prediction Service Running"

@app.route("/predict", methods=["POST"])
def predict_route():
    try:
        data = request.get_json()
        result = predict(data)
        return jsonify(result)
    except Exception as e:
        return jsonify({"error": str(e)}), 500

if __name__ == "__main__":
    import os

if __name__ == "__main__":
    port = int(os.environ.get("PORT", 8080))  # Railway expects 8080
    app.run(host="0.0.0.0", port=port)