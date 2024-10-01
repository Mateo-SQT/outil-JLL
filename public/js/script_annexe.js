

  $(function () {
    $('#datepicker').datepicker();
  });
  // Initialisation de la carte interactive
  function initMap() {
    var map = L.map("map").setView([44.841636, -0.570668], 13);

    // Ajout de la couche de tuiles OpenStreetMap
    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
      attribution:
        'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
      maxZoom: 18,
    }).addTo(map);

    var marker;

    // Activation de l'événement de clique sur la carte
    map.on("click", function (event) {
      if (marker) {
        marker.remove(); // Supprimer le marqueur précédent
      }

      var latLng = event.latlng;
      console.log("Latitude: " + latLng.lat + ", Longitude: " + latLng.lng);
      // Utilisez les valeurs latLng.lat et latLng.lng comme nécessaire
      document.getElementById("latitude").value = latLng.lat;
      document.getElementById("longitude").value = latLng.lng;

      // Ajouter un marqueur à la position sélectionnée
      marker = L.marker(latLng).addTo(map);
    });
  }
  function toggleDiv() {
    var div = document.getElementById("map");
    if (div.style.display === "none") {
      div.style.display = "block";
    } else {
      div.style.display = "none";
    }
  }
  function address() {
    var div = document.getElementById("address");
    if (div.style.display === "none") {
      div.style.display = "block";
    } else {
      div.style.display = "none";
    }
  }
  function initializeAddressSuggestion() {
    const addressInput = document.getElementById("addressInput");
    const suggestions = document.getElementById("suggestions");

    addressInput.addEventListener("input", debounce(getAddressSuggestions, 300));

    async function getAddressSuggestions() {
      const query = addressInput.value;

      if (query.length < 3) {
        suggestions.innerHTML = "";
        return;
      }

      const url = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(
        query
      )}`;

      try {
        const response = await fetch(url);
        const data = await response.json();

        suggestions.innerHTML = "";

        data.forEach((result) => {
          const li = document.createElement("li");
          li.textContent = result.display_name;
          li.classList.add("address-suggestion");
          li.addEventListener("click", () => {
            addressInput.value = result.display_name;
            suggestions.innerHTML = "";
            const { latitude, longitude } = extractCoordinates(result);
            document.getElementById("latitude").value = latitude;
            document.getElementById("longitude").value = longitude;
          });
          suggestions.appendChild(li);
        });
      } catch (error) {
        console.error("Error fetching address suggestions:", error);
      }
    }

    function extractCoordinates(result) {
      const latitude = parseFloat(result.lat);
      const longitude = parseFloat(result.lon);

      console.log("Latitude:", latitude);
      console.log("Longitude:", longitude);

      return {
        latitude,
        longitude
      };
    }

    function debounce(func, delay) {
      let timeoutId;
      return function () {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => {
          func.apply(this, arguments);
        }, delay);
      };
    }
  }
  let downloadUrl = '';

  function triggerPythonScript() {
      let fileInput = document.getElementById('fileElem');
      let file = fileInput.files[0];
  
      let formData = new FormData();
      formData.append('file', file);
  
      fetch('http://127.0.0.1:5000/upload', {
          method: 'POST',
          body: formData
      })
      .then(response => response.text())
      .then(data => {
          document.getElementById('outputMessage').innerHTML = data;  // Affiche le message
          // Affiche le bouton de téléchargement
          downloadUrl = 'http://127.0.0.1:5000/download';  // URL pour le téléchargement
          document.getElementById('downloadBtnContainer').style.display = 'block';
      })
      .catch(error => {
          console.error('Erreur lors de l\'exécution du script Python:', error);
          alert('Erreur lors de l\'exécution du script Python.');
      });
  }
  
  function downloadFile() {
      window.location.href = downloadUrl;  // Redirige vers l'URL de téléchargement
  }



  initializeAddressSuggestion();