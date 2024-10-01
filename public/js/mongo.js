const express = require('express');
const { MongoClient } = require('mongodb');
const path = require('path');

const app = express();
const port = 3000;

const url = 'mongodb://localhost:27017'; // URL de connexion
const dbName = 'maBaseDeDonnees'; // Nom de votre base de données

// Route pour servir le fichier HTML
app.get('/', (req, res) => {
    res.sendFile(path.join(__dirname, 'Administrateur.php'));
});

// Route pour récupérer les données des fichiers
app.get('/api/fichiers', async (req, res) => {
    const client = new MongoClient(url);
    
    try {
        await client.connect(); // Connexion au serveur
        console.log('Connecté avec succès au serveur MongoDB');
        
        const db = client.db(dbName); // Accès à la base de données
        const shapefiles = await db.collection('fichiers_shapefile').find().toArray();
        const jsonFiles = await db.collection('fichiers_json').find().toArray();

        // Log des données récupérées
        console.log({ shapefiles, jsonFiles });

        // Envoi des données au format JSON
        res.json({ shapefiles, jsonFiles });

    } catch (err) {
        console.error(err);
        res.status(500).send('Erreur lors de la récupération des données.');
    } finally {
        await client.close(); // Fermeture de la connexion
    }
});

// Démarrage du serveur
app.listen(port, () => {
    console.log(`Serveur démarré à http://localhost:${port}`);
});
