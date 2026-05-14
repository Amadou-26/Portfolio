<?php
require 'fonctions.php';

$contact_erreurs = [];
$contact_succes  = false;
$contact_nom     = '';
$contact_email   = '';
$contact_sujet   = '';
$contact_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['form_contact'])) {
    
    $contact_nom     = nettoyer($_POST['nom']     ?? '');
    $contact_email   = nettoyer($_POST['email']   ?? '');
    $contact_sujet   = nettoyer($_POST['sujet']   ?? '');
    $contact_message = nettoyer($_POST['message'] ?? '');

    
    if (!champ_requis($contact_nom))
        $contact_erreurs['nom']     = 'Le nom est obligatoire.';
    if (!champ_requis($contact_email))
        $contact_erreurs['email']   = 'L\'adresse e-mail est obligatoire.';
    elseif (!email_valide($contact_email))
        $contact_erreurs['email']   = 'L\'adresse e-mail est invalide.';
    if (!champ_requis($contact_message))
        $contact_erreurs['message'] = 'Le message ne peut pas être vide.';

    
    if (empty($contact_erreurs)) {
        $contact_succes = true;
       
        $contact_nom = $contact_email = $contact_sujet = $contact_message = '';
    }
}


$projet_erreurs = [];
$projet_succes  = false;
$demande        = ['nom' => '', 'email' => '', 'type' => '', 'description' => '', 'budget' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['form_projet'])) {
   
    $demande['nom']         = nettoyer($_POST['p_nom']         ?? '');
    $demande['email']       = nettoyer($_POST['p_email']       ?? '');
    $demande['type']        = nettoyer($_POST['p_type']        ?? '');
    $demande['description'] = nettoyer($_POST['p_description'] ?? '');
    $demande['budget']      = nettoyer($_POST['p_budget']      ?? '');

    
    if (!champ_requis($demande['nom']))
        $projet_erreurs['nom']         = 'Le nom est obligatoire.';
    if (!champ_requis($demande['email']))
        $projet_erreurs['email']       = 'L\'adresse e-mail est obligatoire.';
    elseif (!email_valide($demande['email']))
        $projet_erreurs['email']       = 'L\'adresse e-mail est invalide.';
    if (!champ_requis($demande['type']))
        $projet_erreurs['type']        = 'Veuillez sélectionner un type de projet.';
    if (!champ_requis($demande['description']))
        $projet_erreurs['description'] = 'La description est obligatoire.';

    
    if (empty($projet_erreurs)) {
        $projet_succes = true;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Contact — Papa Amadou Thomas</title>
  <link rel="icon" type="image/x-icon" href="favicon.ico" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="css/global.css" />
  <link rel="stylesheet" href="css/contact.css" />
</head>
<body>

<?php require 'composants/navigation.php'; ?>

<main>

  
  <section class="contact-hero section">
    <div class="container">
      <p class="section-label">Échangeons</p>
      <h1 class="title-xl">Me contacter</h1>
      <p class="contact-hero__desc">
        Une question, une proposition ou simplement envie d'échanger ?
        Remplis l'un des formulaires ci-dessous et je te répondrai rapidement.
      </p>
    </div>
  </section>


  <section class="section contact-main">
    <div class="container contact-grid">

      
      <aside class="contact-info">
        <h2 class="contact-info__title">Informations</h2>
        <div class="contact-info__item">
          <span>📧</span>
          <div>
            <strong>E-mail</strong>
            <span>papaamadouthomas2617@email.com</span>
          </div>
        </div>
        <div class="contact-info__item">
          <span>📍</span>
          <div>
            <strong>Localisation</strong>
            <span>Dakar, Sénégal</span>
          </div>
        </div>
        <div class="contact-info__item">
          <span>🐙</span>
          <div>
            <strong>GitHub</strong>
            <a href="https://github.com/" target="_blank" rel="noopener">github.com/pat</a>
          </div>
        </div>
        <div class="contact-info__availability">
          <span class="availability-dot"></span>
          Disponible pour un stage ou une opportunité
        </div>
      </aside>

      
      <div class="form-wrapper">
        <h2 class="form-title">Envoyer un message</h2>

        <?php if ($contact_succes) : ?>
          <div class="alert alert-success">
            ✅ Merci <strong><?= htmlspecialchars($_POST['nom'] ?? '') ?></strong> !
            Ton message a bien été reçu. Je te répondrai dès que possible.
          </div>
        <?php endif; ?>

        <?php if (!empty($contact_erreurs)) : ?>
          <div class="alert alert-error">
            ⚠️ Veuillez corriger les erreurs ci-dessous avant d'envoyer.
          </div>
        <?php endif; ?>

        <form class="cform" method="POST" action="contact.php#contact">
          
          <input type="hidden" name="form_contact" value="1" />

          <div class="cform__row">
            <div class="cform__group">
              <label class="cform__label" for="nom">Nom complet *</label>
              <input class="cform__input <?= isset($contact_erreurs['nom']) ? 'invalid' : '' ?>"
                     type="text" id="nom" name="nom"
                     placeholder="Votre nom"
                     value="<?= htmlspecialchars($contact_nom) ?>"
                     required />
              <?php if (isset($contact_erreurs['nom'])) : ?>
                <span class="field-error"><?= $contact_erreurs['nom'] ?></span>
              <?php endif; ?>
            </div>
            <div class="cform__group">
              <label class="cform__label" for="email">Adresse e-mail *</label>
              <input class="cform__input <?= isset($contact_erreurs['email']) ? 'invalid' : '' ?>"
                     type="email" id="email" name="email"
                     placeholder="vous@exemple.com"
                     value="<?= htmlspecialchars($contact_email) ?>"
                     required />
              <?php if (isset($contact_erreurs['email'])) : ?>
                <span class="field-error"><?= $contact_erreurs['email'] ?></span>
              <?php endif; ?>
            </div>
          </div>

          <div class="cform__group">
            <label class="cform__label" for="sujet">Sujet</label>
            <input class="cform__input" type="text" id="sujet" name="sujet"
                   placeholder="Sujet de votre message"
                   value="<?= htmlspecialchars($contact_sujet) ?>" />
          </div>

          <div class="cform__group">
            <label class="cform__label" for="message">Message *</label>
            <textarea class="cform__textarea <?= isset($contact_erreurs['message']) ? 'invalid' : '' ?>"
                      id="message" name="message"
                      placeholder="Votre message ici…"
                      required><?= htmlspecialchars($contact_message) ?></textarea>
            <?php if (isset($contact_erreurs['message'])) : ?>
              <span class="field-error"><?= $contact_erreurs['message'] ?></span>
            <?php endif; ?>
          </div>

          <button type="submit" class="btn btn-primary">Envoyer →</button>
        </form>
      </div>

    </div>
  </section>

  
  <section class="section project-request-section" id="projet">
    <div class="container">
      <p class="section-label">Collaboration</p>
      <h2 class="title-lg" style="margin-bottom: var(--sp-sm);">Soumettre un projet</h2>
      <p class="form-subtitle">Tu as un projet en tête et cherches un développeur ? Décris-le ici.</p>

      <?php if ($projet_succes) : ?>
        <div class="alert alert-success">
          ✅ Demande reçue ! Voici le récapitulatif :
          <ul style="margin-top: 0.5rem; padding-left: 1.2rem;">
            <li><strong>Nom :</strong> <?= htmlspecialchars($demande['nom']) ?></li>
            <li><strong>E-mail :</strong> <?= htmlspecialchars($demande['email']) ?></li>
            <li><strong>Type :</strong> <?= htmlspecialchars($demande['type']) ?></li>
            <li><strong>Budget :</strong> <?= htmlspecialchars($demande['budget']) ?: 'Non précisé' ?></li>
            <li><strong>Description :</strong> <?= htmlspecialchars($demande['description']) ?></li>
          </ul>
        </div>
      <?php endif; ?>

      <?php if (!empty($projet_erreurs)) : ?>
        <div class="alert alert-error">⚠️ Veuillez corriger les erreurs ci-dessous.</div>
      <?php endif; ?>

      <form class="cform" method="POST" action="contact.php#projet">
        <input type="hidden" name="form_projet" value="1" />

        <div class="cform__row">
          <div class="cform__group">
            <label class="cform__label" for="p_nom">Votre nom *</label>
            <input class="cform__input <?= isset($projet_erreurs['nom']) ? 'invalid' : '' ?>"
                   type="text" id="p_nom" name="p_nom"
                   placeholder="Votre nom"
                   value="<?= htmlspecialchars($demande['nom']) ?>"
                   required />
            <?php if (isset($projet_erreurs['nom'])) : ?>
              <span class="field-error"><?= $projet_erreurs['nom'] ?></span>
            <?php endif; ?>
          </div>
          <div class="cform__group">
            <label class="cform__label" for="p_email">E-mail *</label>
            <input class="cform__input <?= isset($projet_erreurs['email']) ? 'invalid' : '' ?>"
                   type="email" id="p_email" name="p_email"
                   placeholder="vous@exemple.com"
                   value="<?= htmlspecialchars($demande['email']) ?>"
                   required />
            <?php if (isset($projet_erreurs['email'])) : ?>
              <span class="field-error"><?= $projet_erreurs['email'] ?></span>
            <?php endif; ?>
          </div>
        </div>

        <div class="cform__row">
          <div class="cform__group">
            <label class="cform__label" for="p_type">Type de projet *</label>
            <select class="cform__select <?= isset($projet_erreurs['type']) ? 'invalid' : '' ?>"
                    id="p_type" name="p_type" required>
              <option value="" disabled <?= $demande['type'] === '' ? 'selected' : '' ?>>Sélectionner…</option>
              <option value="Site vitrine"     <?= $demande['type'] === 'Site vitrine'     ? 'selected' : '' ?>>Site vitrine</option>
              <option value="Application web"  <?= $demande['type'] === 'Application web'  ? 'selected' : '' ?>>Application web</option>
              <option value="Système embarqué" <?= $demande['type'] === 'Système embarqué' ? 'selected' : '' ?>>Système embarqué / IoT</option>
              <option value="Infrastructure"   <?= $demande['type'] === 'Infrastructure'   ? 'selected' : '' ?>>Infrastructure réseau</option>
              <option value="Autre"            <?= $demande['type'] === 'Autre'            ? 'selected' : '' ?>>Autre</option>
            </select>
            <?php if (isset($projet_erreurs['type'])) : ?>
              <span class="field-error"><?= $projet_erreurs['type'] ?></span>
            <?php endif; ?>
          </div>
          <div class="cform__group">
            <label class="cform__label" for="p_budget">Budget estimé</label>
            <input class="cform__input" type="text" id="p_budget" name="p_budget"
                   placeholder="Ex : 100 000 – 300 000 FCFA"
                   value="<?= htmlspecialchars($demande['budget']) ?>" />
          </div>
        </div>

        <div class="cform__group">
          <label class="cform__label" for="p_description">Description du projet *</label>
          <textarea class="cform__textarea <?= isset($projet_erreurs['description']) ? 'invalid' : '' ?>"
                    id="p_description" name="p_description"
                    placeholder="Décris ton projet : objectifs, fonctionnalités, délais…"
                    required><?= htmlspecialchars($demande['description']) ?></textarea>
          <?php if (isset($projet_erreurs['description'])) : ?>
            <span class="field-error"><?= $projet_erreurs['description'] ?></span>
          <?php endif; ?>
        </div>

        <button type="submit" class="btn btn-primary">Soumettre le projet →</button>
      </form>

    </div>
  </section>

</main>

<?php require 'composants/pied-de-page.php'; ?>

</body>
</html>
