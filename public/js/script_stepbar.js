let currentStep = 1; // Étape actuelle
const totalSteps = 4; // Nombre total d'étapes

const progressBar = document.getElementById('progress-bar');
const steps = progressBar.getElementsByClassName('step-item');
const line = progressBar.getElementsByClassName('step-line')[0];
const downloadBtn = document.getElementById('download');

function updateProgress(step) {
  if (step < 1 || step > totalSteps) return; // Vérifier que l'étape est valide
  currentStep = step;

  for (let i = 0; i < steps.length; i++) {
    const textElement = steps[i].querySelector('.mt-2');

    if (i < currentStep - 1) {
      steps[i].classList.add('completed');
      textElement.style.display = 'block'; // Afficher le texte
    } else if (i === currentStep - 1) {
      steps[i].classList.add('active');
      textElement.style.display = 'block'; // Afficher le texte
    } else {
      steps[i].classList.remove('active', 'completed');
      textElement.style.display = 'none'; // Masquer le texte
    }
  }

  // Mettre à jour la ligne de progression
  line.style.width = ((currentStep - 1) / (totalSteps - 1)) * 100 + '%';
  line.classList.toggle('active', currentStep > 1);

  downloadBtn.disabled = currentStep < totalSteps;
}
