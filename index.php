<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.65">
    <title>Créer votre SVG / Create your SVG</title>
<link href="styles.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <div class="container">
        <h1 id="title">Créez votre SVG personnalisé</h1>
        <div class="image-container">
            <img src="https://i.top4top.io/p_31226h15s0.jpg" alt="Image" />
        </div>
        <form id="svgForm" action="generate_svg.php" method="post" target="svgPreview" onsubmit="submitForm(event)">
            <label for="name" id="label-name">Votre nom :</label>
            <input type="text" id="name" name="name" required><br>

            <label for="job" id="label-job">Votre métier/compétences :</label>
            <input type="text" id="job" name="job" required><br>

            <label for="image_url" id="label-image-url">URL de l'image (facultatif) :</label>
            <input type="text" id="image_url" name="image_url"><br>

            <label for="anonymous" id="label-anonymous">Remplacer "AnOnYmOuS" par :</label>
            <input type="text" id="anonymous" name="anonymous" placeholder="Mot pour remplacer AnOnYmOuS"><br>

            <input type="submit" id="submit-btn" value="Créer SVG">
        </form>

        <div class="preview">
            <iframe name="svgPreview"></iframe>
        </div>

        <div class="message" id="message">
            <p>Après avoir soumis le formulaire, le SVG sera affiché ci-dessous et téléchargé automatiquement.</p>
        </div>
    </div>

    <script>
        function submitForm(event) {
            event.preventDefault(); // Empêche le formulaire d'être soumis normalement

            // Soumet le formulaire en utilisant fetch
            let form = document.getElementById('svgForm');
            let formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.blob())
            .then(blob => {
                // Créer un URL d'objet pour le fichier SVG
                let url = window.URL.createObjectURL(blob);

                // Afficher le SVG dans l'iframe
                document.querySelector('iframe[name="svgPreview"]').src = url;

                // Créer un lien de téléchargement temporaire
                let a = document.createElement('a');
                a.href = url;
                a.download = 'personalized_logo.svg';
                document.body.appendChild(a);
                a.click();
                a.remove();

                // Nettoyer l'URL d'objet après le téléchargement
                window.URL.revokeObjectURL(url);
            })
            .catch(error => console.error('Erreur:', error));
        }

        // Détecter la langue préférée du navigateur et ajuster le contenu de la page en conséquence
        document.addEventListener('DOMContentLoaded', () => {
            const userLang = navigator.language || navigator.userLanguage;
            if (userLang.startsWith('en')) {
                document.getElementById('title').textContent = 'Create your personalized SVG';
                document.getElementById('label-name').textContent = 'Your name:';
                document.getElementById('label-job').textContent = 'Your job/skills:';
                document.getElementById('label-image-url').textContent = 'Image URL (optional):';
                document.getElementById('label-anonymous').textContent = 'Replace "AnOnYmOuS" with:';
                document.getElementById('submit-btn').value = 'Create SVG';
                document.getElementById('message').innerHTML = '<p>After submitting the form, the SVG will be displayed below and downloaded automatically.</p>';
            }
        });
    </script>
</body>
</html>