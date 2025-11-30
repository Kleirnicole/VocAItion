from flask import Flask, request, jsonify
from predict_survey import load_model_and_encoders, prepare_input, get_course_info, survey_to_text

# Create the Flask app
app = Flask(__name__)

# Load models and encoders (lazy-load if needed)
model, feature_encoders, target_encoder, riasec_encoder = load_model_and_encoders()

@app.route("/")
def home():
    return "AI Prediction Service Running"

@app.route("/predict", methods=["POST"])
def predict():
    try:
        data = request.get_json()
        # Convert survey answers into text or features
        text = survey_to_text(data)
        X = prepare_input(data, feature_encoders, riasec_encoder)

        probs = model.predict_proba(X)[0]
        top_indices = probs.argsort()[::-1][:2]
        top_courses = target_encoder.inverse_transform(top_indices)

        result = {
            "recommended_course": top_courses[0],
            "recommended_score": round(probs[top_indices[0]] * 100, 2),
            "suggested_course": top_courses[1],
            "suggested_score": round(probs[top_indices[1]] * 100, 2)
        }
        return jsonify(result)
    except Exception as e:
        return jsonify({"error": str(e)}), 500

if __name__ == "__main__":
    import os
    port = int(os.environ.get("PORT", 5000))  # Railway sets PORT=8080
    app.run(host="0.0.0.0", port=port)