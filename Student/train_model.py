import pandas as pd
import numpy as np
import os
import json
import datetime
import joblib
import matplotlib
matplotlib.use('Agg')
import matplotlib.pyplot as plt

from sklearn.model_selection import train_test_split, cross_val_score, StratifiedKFold
from sklearn.ensemble import RandomForestClassifier
from sklearn.svm import SVC
from sklearn.linear_model import LogisticRegression
from sklearn.preprocessing import LabelEncoder, StandardScaler
from sklearn.metrics import classification_report, top_k_accuracy_score

# -----------------------------
# File paths
# -----------------------------
EXCEL_FILE = "training_dataset.xlsx"
MODEL_FILE = "best_model.pkl"
FEATURE_ENCODERS_FILE = "feature_encoders.pkl"
TARGET_ENCODER_FILE = "target_encoder.pkl"
METADATA_FILE = "model_metadata.json"

# -----------------------------
# Helper functions
# -----------------------------
def validate_file(path):
    if not os.path.exists(path):
        raise FileNotFoundError(f"❌ File not found: {path}")

def encode_features(X, expected_questions):
    feature_encoders = {}
    for col in expected_questions:
        if col in X.columns:
            le = LabelEncoder()
            X[col] = le.fit_transform(X[col].astype(str))
            feature_encoders[col] = le
    return X, feature_encoders

def plot_feature_importance(model, features, filename="feature_importance.png"):
    importances = model.feature_importances_
    indices = np.argsort(importances)[::-1]

    plt.figure(figsize=(10, 6))
    plt.title("Feature Importance")
    plt.bar(range(len(importances)), importances[indices], align="center")
    plt.xticks(range(len(importances)), [features[i] for i in indices], rotation=90)
    plt.tight_layout()
    plt.savefig(filename)

# -----------------------------
# Main training pipeline
# -----------------------------
def main(model_choice="RandomForest"):
    # Validate dataset
    validate_file(EXCEL_FILE)

    # Load and clean data
    df = pd.read_excel(EXCEL_FILE)
    df.columns = df.columns.str.strip()

    expected_questions = [f"q{i}" for i in range(1, 43)]
    missing = [q for q in expected_questions if q not in df.columns]
    if missing:
        print(f"⚠️ Missing expected survey columns: {missing}")

    print("📊 Course distribution:")
    print(df['courses'].value_counts())

    # Split features and target
    X = df.loc[:, expected_questions]
    y = df['courses']

    # Encode features
    X, feature_encoders = encode_features(X, expected_questions)

    # Ensure numeric
    X = X.apply(pd.to_numeric, errors='coerce').replace([np.inf, -np.inf], np.nan).fillna(0)

    # Encode target
    target_encoder = LabelEncoder()
    y = target_encoder.fit_transform(y.astype(str))

    # Save encoders
    joblib.dump(feature_encoders, FEATURE_ENCODERS_FILE)
    joblib.dump(target_encoder, TARGET_ENCODER_FILE)

    # Train-test split
    X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)

    # Choose model
    if model_choice == "RandomForest":
        model = RandomForestClassifier(random_state=42)
        model.fit(X_train, y_train)
        test_score = model.score(X_test, y_test)
    elif model_choice == "SVM":
        scaler = StandardScaler()
        X_train_scaled = scaler.fit_transform(X_train)
        X_test_scaled = scaler.transform(X_test)
        model = SVC(probability=True, random_state=42)
        model.fit(X_train_scaled, y_train)
        test_score = model.score(X_test_scaled, y_test)
        joblib.dump(scaler, "feature_scaler.pkl")
    elif model_choice == "LogisticRegression":
        scaler = StandardScaler()
        X_train_scaled = scaler.fit_transform(X_train)
        X_test_scaled = scaler.transform(X_test)
        model = LogisticRegression(max_iter=1000, random_state=42)
        model.fit(X_train_scaled, y_train)
        test_score = model.score(X_test_scaled, y_test)
        joblib.dump(scaler, "feature_scaler.pkl")
    else:
        raise ValueError("Invalid model choice. Use 'RandomForest', 'SVM', or 'LogisticRegression'.")

    # Evaluation
    report = classification_report(y_test, model.predict(X_test), target_names=target_encoder.classes_, zero_division=0)
    with open("evaluation_report.txt", "w") as f:
        f.write(report)

    top3_acc = top_k_accuracy_score(y_test, model.predict_proba(X_test), k=3)
    top5_acc = top_k_accuracy_score(y_test, model.predict_proba(X_test), k=5)

    print(f"🎯 Top-3 Accuracy: {top3_acc:.4f}")
    print(f"🎯 Top-5 Accuracy: {top5_acc:.4f}")
    print(f"📊 Test Accuracy: {test_score:.4f}")

    # Save model
    joblib.dump(model, MODEL_FILE)
    print(f"✅ Model saved as: {MODEL_FILE}")

    # Cross-validation
    cv = StratifiedKFold(n_splits=3, shuffle=True, random_state=42)
    cv_score = np.mean(cross_val_score(model, X_train, y_train, cv=cv))

    # Metadata
    metadata = {
        "model_name": model_choice,
        "cv_score": round(cv_score, 4),
        "test_score": round(test_score, 4),
        "trained_on": datetime.datetime.now().isoformat(),
        "class_distribution": df['courses'].value_counts().to_dict(),
        "model_version": f"v{datetime.datetime.now().strftime('%Y%m%d%H%M')}",
        "top_3_accuracy": round(top3_acc, 4),
        "top_5_accuracy": round(top5_acc, 4)
    }
    with open(METADATA_FILE, "w") as f:
        json.dump(metadata, f, indent=2)

    # Feature importance (only for RandomForest)
    if model_choice == "RandomForest":
        plot_feature_importance(model, X.columns)

# -----------------------------
# Run script
# -----------------------------
if __name__ == "__main__":
    main(model_choice="RandomForest")  # Change to "SVM" or "LogisticRegression" if needed