import sys
import json
import joblib
import pandas as pd
import os
import io
import numpy as np
from sentence_transformers import SentenceTransformer, util

# Fix UTF-8 print
sys.stdout = io.TextIOWrapper(sys.stdout.buffer, encoding="utf-8")

# File paths
COURSE_DESC_FILE = "course_descriptions.xlsx"
MODEL_FILE = "best_model.pkl"
FEATURE_ENCODERS_FILE = "feature_encoders.pkl"
TARGET_ENCODER_FILE = "target_encoder.pkl"
RIASEC_ENCODER_FILE = "riasec_encoder.pkl"

# Lazy-load global embedder
_embedder = None

# Lazy-load embedder
def get_embedder():
    global _embedder
    if _embedder is None:
        print("🔄 Loading sentence transformer...")
        _embedder = SentenceTransformer("all-MiniLM-L6-v2")
    return _embedder

# Load model and encoders
def init():
    global model, feature_encoders, target_encoder, riasec_encoder, course_df
    try:
        print("🔄 Loading model and encoders...")
        model = joblib.load(MODEL_FILE)
        feature_encoders = joblib.load(FEATURE_ENCODERS_FILE)
        target_encoder = joblib.load(TARGET_ENCODER_FILE)
        riasec_encoder = joblib.load(RIASEC_ENCODER_FILE)

        course_df = pd.read_excel(COURSE_DESC_FILE)
        course_df.columns = course_df.columns.str.strip()
        course_df["Course Name"] = course_df["Course Name"].str.strip()
        course_df["Course Name Clean"] = course_df["Course Name"].str.lower()

        print("✅ Model and data loaded.")
    except Exception as e:
        raise RuntimeError(f"Failed to load model/data: {e}")

# Prepare ML input
def prepare_input(data):
    df = pd.DataFrame([{f"q{i}": data.get(f"q{i}", "") for i in range(1, 43)}])

    for col in df.columns:
        if col in feature_encoders:
            df[col] = df[col].apply(
                lambda x: "Yes" if str(x).lower() in ["1", "yes", "y", "true"] else
                          "No" if str(x).lower() in ["0", "no", "n", "false"] else
                          str(x)
            )
            if df[col].iloc[0] not in feature_encoders[col].classes_:
                df[col] = feature_encoders[col].classes_[0]
            df[col] = feature_encoders[col].transform(df[col])

    codes = data.get("code") or data.get("top_3_types") or ""
    codes = codes.split(",") if codes else []
    riasec_features = pd.DataFrame(
        riasec_encoder.transform([codes]),
        columns=riasec_encoder.classes_
    )

    return pd.concat([df, riasec_features], axis=1)

# Convert survey to text
def survey_to_text(data):
    return " ".join([f"{key}: {data[key]}" for key in data if key.startswith("q")])

# Get course description
def get_course_info(course_name_clean):
    match = course_df[course_df["Course Name Clean"] == course_name_clean]
    return match["Description"].values[0] if not match.empty else "No description available"

# Main prediction logic
def predict(data):
    X = prepare_input(data)
    probs = model.predict_proba(X)[0]

    top_indices = probs.argsort()[::-1][:2]
    top_courses = target_encoder.inverse_transform(top_indices)

    ml_course = top_courses[0]
    ml_course_clean = ml_course.lower().strip()
    ml_score = round(probs[top_indices[0]] * 100, 2)

    suggested_course = top_courses[1]
    suggested_score = round(probs[top_indices[1]] * 100, 2)

    # Build only the required JSON result
    return {
        "recommended_course": ml_course,
        "recommended_score": ml_score,
        "recommended_description": get_course_info(ml_course_clean),
        "suggested_course": suggested_course,
        "suggested_score": suggested_score
    }

# CLI entry point
def main():
    if len(sys.argv) < 2:
        print(json.dumps({"error": "No input JSON provided"}))
        sys.exit(1)

    file_path = sys.argv[1]
    if not os.path.exists(file_path):
        print(json.dumps({"error": "JSON file not found"}))
        sys.exit(1)

    try:
        with open(file_path, "r", encoding="utf-8") as f:
            data = json.load(f)
    except Exception as e:
        print(json.dumps({"error": f"JSON read error: {e}"}))
        sys.exit(1)

    try:
        init()
        result = predict(data)
        print(json.dumps(result, ensure_ascii=False))
    except Exception as e:
        print(json.dumps({"error": f"Prediction error: {e}"}))
        sys.exit(1)

# Run program
if __name__ == "__main__":
    main()