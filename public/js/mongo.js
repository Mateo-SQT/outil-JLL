const express = require('express');
const mongoose = require('mongoose');
const app = express();
const port = 3000;

app.use(express.static('public'));

// Connecter à MongoDB 
mongoose.connect('mongodb://localhost:27017/Nombre_Downloads');

// Définir un modèle pour la collection
const Fichier = mongoose.model('Downloads_1', new mongoose.Schema({
    nom: String,
    nombre: Number
}));

// Route API pour récupérer les fichiers
app.get('/api/files', async (req, res) => {
    try {
        const fichiers = await Fichier.find(); // Récupérer tous les fichiers de la base de données
        res.json(fichiers); // Renvoyer les fichiers sous forme JSON
    } catch (error) {
        res.status(500).send('Erreur lors de la récupération des fichiers.');
    }
});

// Démarrer le serveur
app.listen(port, () => {
    console.log(`Serveur en cours d'exécution sur http://localhost:${port}`);
});
