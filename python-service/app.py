from flask import Flask, request, jsonify
import json
import joblib
import pandas as pd
import os
from predict_survey import load_model_and_encoders, prepare_input, get_course_info, survey_to_text
from sentence_transformers import SentenceTransformer, util
import numpy as np

app = Flask(__name__)

# Load everything once at startup
model, feature_encoders, target_encoder, riasec_encoder = load_model_and_encoders()
course_df = pd.read_excel("course_descriptions.xlsx")
course_df.columns = course_df.columns.str.strip()
course_df["Course Name"] = course_df["Course Name"].str.strip()
course_df["Course Name Clean"] = course_df["Course Name"].str.lower()

@app.route("/predict", methods=["POST"])
def predict():
    try:
        data = request.get_json()

        # Prepare input
        X = prepare_input(data, feature_encoders, riasec_encoder)
        probs = model.predict_proba(X)[0]
        top_indices = probs.argsort()[::-1][:2]
        top_courses = target_encoder.inverse_transform(top_indices)

        ml_course = top_courses[0]
        ml_course_clean = ml_course.lower().strip()
        ml_score = round(probs[top_indices[0]] * 100, 2)

        suggested_course = top_courses[1]
        suggested_score = round(probs[top_indices[1]] * 100, 2)

        final_desc = get_course_info(course_df, ml_course_clean)

        result = {
            "recommended_course": ml_course,
            "recommended_score": ml_score,
            "recommended_description": final_desc,
            "suggested_course": suggested_course,
            "suggested_score": suggested_score,
            "ml_top_courses": list(top_courses),
            "ml_top_scores": [round(probs[i] * 100, 2) for i in top_indices]
        }

        return jsonify(result)

    except Exception as e:
        return jsonify({"error": str(e)}), 500
