
  // Fonction pour mettre à jour l'heure actuelle
  const heureInput = document.getElementById('appt');
  const maintenant = new Date();
  const heures = maintenant.getHours();
  const minutes = maintenant.getMinutes();
  const heureActuelle = `${heures.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}`;
  heureInput.value = heureActuelle;

  /* Fonction récupérer les valeurs de l'utilisateur */
  function getValue() {
    const latitude = document.getElementById("latitude").value;
    const longitude = document.getElementById("longitude").value;
    const temps1 = document.getElementById("temps1").value;
    const temps_en_secondes_1 = temps1 * 60;
    const temps2 = document.getElementById("temps2").value;
    const temps_en_secondes_2 = temps2 * 60;
    const temps3 = document.getElementById("temps3").value;
    const temps_en_secondes_3 = temps3 * 60;
    const date_depart = document.getElementById("dateInput").value;
    const heure_depart = document.getElementById("appt").value;
    const region = document.getElementById("inputGroupSelect").value;

    console.log("Latitude:", latitude);
    console.log("Longitude:", longitude);
    console.log("Temps 1:", temps1);
    console.log("Temps 2:", temps2);
    console.log("Temps 3:", temps3);
    console.log("Région:", region);
    console.log("Date de départ:", date_depart);
    console.log("Heure de départ:", heure_depart);



    // Conversion date et heure en format ISO
    const mois = date_depart.substring(5, 7);
    const jour = date_depart.substring(8, 10);
    const annee = date_depart.substring(0, 4);
    const heure = heure_depart.substring(0, 2);
    const minute = heure_depart.substring(3, 5);
    const DateHeure = `${annee}${mois}${jour}T${heure}${minute}`;
    const position = `${longitude}%3B${latitude}`;

    // Construction de l'URL
    const baseUrl = `https://api.navitia.io/v1/coverage/${region}/isochrones?from=${position}&datetime=${DateHeure}`;
    const url1 = `${baseUrl}&boundary_duration%5B%5D=${temps_en_secondes_1}&boundary_duration%5B%5D=${temps_en_secondes_2}&boundary_duration%5B%5D=${temps_en_secondes_3}`;
    const url2 = `${baseUrl}&boundary_duration%5B%5D=${temps_en_secondes_1}&boundary_duration%5B%5D=${temps_en_secondes_2}`;
    const url3 = `${baseUrl}&boundary_duration%5B%5D=${temps_en_secondes_1}`;

    let selectedUrl = url1;

    // Vérifier quels champs de temps sont vides
    if (!temps2.trim()) {
      selectedUrl = url3; // Si temps2 et temps3 sont vides
    } else if (!temps3.trim()) {
      selectedUrl = url2; // Si temps3 est vide
    }

    console.log("URL sélectionnée:", selectedUrl);

    //document.getElementById('DonneesCompilees').style.display = "block";
    updateProgress(1); // Initialiser à l'étape 1


    //document.getElementById('URLcompilee').style.display = "block";
    // Appel d'exemple

    updateProgress(2); // Mettre à jour à l'étape 2



    // Récupérer les données via fetch
    const myHeaders = new Headers();
    myHeaders.append("Authorization", "26819ca5-abfa-43e4-b388-7b3d31266b9f");
    const requestOptions = {
      method: 'GET',
      headers: myHeaders,
      redirect: 'follow'
    };

    fetch(selectedUrl, requestOptions)
      .then(response => response.json())
      .then(result => {
        const jsonData = result.isochrones[0];

       // document.getElementById("API").style.display = "block";
       updateProgress(2); // Mettre à jour à l'étape 4


        // Extraction des données
        const coordinates = jsonData.geojson.coordinates;
        const max_duration = jsonData.max_duration;
        const min_duration = jsonData.min_duration;
        const from = jsonData.from;
        const requested_date_time = jsonData.requested_date_time;
        const min_date_time = jsonData.min_date_time;
        const max_date_time = jsonData.max_date_time;

        console.log(coordinates, max_duration, min_duration, from, requested_date_time, min_date_time, max_date_time);

        // Créer l'objet JSON pour le téléchargement
        const isochrones = {
          "type": "FeatureCollection",
          "features": [
            {
              "type": "Feature",
              "geometry": {
                "type": "MultiPolygon",
                "coordinates": coordinates
              },
              "properties": {
                "name": "Example Polygon",
                "other_property": "value"
              }
            }
          ],
          "max_duration": max_duration,
          "min_duration": min_duration,
          "from": from,
          "requested_date_time": requested_date_time,
          "min_date_time": min_date_time,
          "max_date_time": max_date_time
        };


        // Afficher les sections requises
        //document.getElementById('GeoJson').style.display = "block";
        updateProgress(3); // Mettre à jour à l'étape 3


        // Gestion du téléchargement du fichier JSON
        document.getElementById('download').addEventListener('click', function() {
          const jsonString = JSON.stringify(isochrones, null, 2);
          const blob = new Blob([jsonString], { type: 'application/json' });
          const url = URL.createObjectURL(blob);
          const a = document.createElement('a');
          a.href = url;
          a.download = 'data.json';
          document.body.appendChild(a);
          a.click();
          document.body.removeChild(a);
          URL.revokeObjectURL(url);
        });
        // document.getElementById('download').disabled = false;
       updateProgress(4); // Mettre à jour à l'étape 4

      })
      .catch(error => console.error('Erreur:', error));
  }; 


