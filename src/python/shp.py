from flask import Flask, request, render_template, send_from_directory
from flask_cors import CORS
import geopandas as gpd
import os
import shutil
import zipfile

app = Flask(__name__)
CORS(app)

# Chemins
output_folder = r"C:\wamp64\www\Outil_JLL\src\python\output"
shp_file_path = os.path.join(output_folder, "Data_convert.shp")

@app.route('/')
def index():
    return render_template('index.html')

@app.route('/upload', methods=['POST'])
def upload_file():
    if 'file' not in request.files:
        return 'No file part'
    
    file = request.files['file']
    
    if file and file.filename.endswith('.json'):
        # Enregistrer le fichier uploadé
        json_file_path = os.path.join(output_folder, file.filename)
        try:
            file.save(json_file_path)
            print(f"Fichier enregistré: {json_file_path}")
        except Exception as e:
            return f"Erreur lors de l'enregistrement du fichier: {e}"

        # Traiter le fichier
        return process_file(json_file_path)
    
    return 'Invalid file format. Please upload a .json file.'

def process_file(json_file_path):
    os.makedirs(output_folder, exist_ok=True)

    try:
        gdf = gpd.read_file(json_file_path)
        print("GeoDataFrame chargé avec succès.")
    except Exception as e:
        print(f"Erreur lors de la lecture du fichier GeoJSON: {e}")
        return f"Erreur lors de la lecture du fichier GeoJSON: {e}"

    if gdf is not None:
        try:
            # Sauvegarder le Shapefile
            gdf.to_file(shp_file_path, driver='ESRI Shapefile')
            print("Conversion en Shapefile réussie !")
            
            # Copier le fichier JSON dans le même dossier seulement si nécessaire
            dest_json_file_path = os.path.join(output_folder, os.path.basename(json_file_path))
            if json_file_path != dest_json_file_path:
                shutil.copy(json_file_path, dest_json_file_path)
                print("Fichier JSON copié dans le dossier de sortie.")
            else:
                print("Le fichier source et le fichier de destination sont identiques, aucune copie n'a été effectuée.")

            # Zip le dossier output en incluant seulement le dernier data.json
            zip_file_path = zip_output_folder(output_folder, dest_json_file_path)
            return f"Conversion réussie. "
        except Exception as e:
            print(f"Erreur lors de la conversion en Shapefile: {e}")
            return f"Erreur lors de la conversion en Shapefile: {e}"
    else:
        return "Erreur : fichier GeoJSON non valide."

def zip_output_folder(folder_path, json_file_path):
    zip_file_path = f"{folder_path}.zip"
    with zipfile.ZipFile(zip_file_path, 'w', zipfile.ZIP_DEFLATED) as zipf:
        # Ajouter seulement le dernier data.json
        zipf.write(json_file_path, arcname=os.path.basename(json_file_path))
        # Ajouter également le Shapefile et ses fichiers associés
        for file in os.listdir(folder_path):
            if file.endswith('.shp') or file.endswith('.shx') or file.endswith('.dbf'):
                zipf.write(os.path.join(folder_path, file), arcname=file)
    return zip_file_path

# Route pour télécharger le fichier zip
@app.route('/download')
def download_file():
    try:
        zip_file_path = f"{output_folder}.zip"  # Chemin du fichier zip
        return send_from_directory(os.path.dirname(zip_file_path), 
                                   os.path.basename(zip_file_path), 
                                   as_attachment=True)
    except Exception as e:
        return f"Erreur lors du téléchargement: {e}"

if __name__ == '__main__':
    app.run(debug=True)
