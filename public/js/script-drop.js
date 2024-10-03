const dropZone = document.getElementById('drop-zone');
        const fileElem = document.getElementById('fileElem');

        dropZone.addEventListener('click', () => {
            fileElem.click();
        });

        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.classList.add('hover');
        });

        dropZone.addEventListener('dragleave', () => {
            dropZone.classList.remove('hover');
        });

        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('hover');
            const files = e.dataTransfer.files;
            handleFiles(files);
        });

        fileElem.addEventListener('change', (e) => {
            const files = e.target.files;
            handleFiles(files);
        });

        function handleFiles(files) {
            if (files.length > 0) {
                
                dropZone.textContent = files[0].name; 
            } else {
                dropZone.textContent = 'Déposez vos fichiers ici ou cliquez pour sélectionner';
            }
        }

        submitBtn.addEventListener('click', () => {
            alert('Fichiers envoyés !'); 
        });