from flask import Flask, request, jsonify
from predict_survey import run_prediction   # import your function

app = Flask(__name__)

@app.route("/predict", methods=["POST"])
def predict():
    try:
        # Get JSON data from PHP
        data = request.json
        if not data:
            return jsonify({"error": "No input data provided"}), 400

        # Run prediction using your ML + semantic AI logic
        result = run_prediction(data)

        # Return JSON back to PHP
        return jsonify(result)
    except Exception as e:
        return jsonify({"error": str(e)}), 500

if __name__ == "__main__":
    app.run(host="0.0.0.0", port=5000)