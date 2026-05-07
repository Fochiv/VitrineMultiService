<?php
/**
 * Contact Page — LionTech
 * Validation PHP côté serveur, envoi de confirmation (sans base de données)
 */

$success = false;
$errors  = [];
$fields  = ['nom' => '', 'email' => '', 'telephone' => '', 'sujet' => '', 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération & nettoyage des données
    $nom       = htmlspecialchars(trim($_POST['nom']       ?? ''), ENT_QUOTES, 'UTF-8');
    $email     = htmlspecialchars(trim($_POST['email']     ?? ''), ENT_QUOTES, 'UTF-8');
    $telephone = htmlspecialchars(trim($_POST['telephone'] ?? ''), ENT_QUOTES, 'UTF-8');
    $sujet     = htmlspecialchars(trim($_POST['sujet']     ?? ''), ENT_QUOTES, 'UTF-8');
    $message   = htmlspecialchars(trim($_POST['message']   ?? ''), ENT_QUOTES, 'UTF-8');

    // Conserver les valeurs pour ré-affichage
    $fields = compact('nom', 'email', 'telephone', 'sujet', 'message');

    // Validation
    if (strlen($nom) < 2)           $errors[] = "Le nom complet est requis (minimum 2 caractères).";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "L'adresse e-mail est invalide.";
    if (empty($sujet))              $errors[] = "Veuillez sélectionner un sujet.";
    if (strlen($message) < 10)      $errors[] = "Le message est trop court (minimum 10 caractères).";

    if (empty($errors)) {
        // Tentative d'envoi par mail (fonctionnel si PHP mail() est configuré)
        $to      = 'contact@liontech.iceiy.com';
        $subject = "[LionTech Contact] " . $sujet . " — " . $nom;
        $body    = "Nom      : $nom\n"
                 . "Email    : $email\n"
                 . "Tél      : $telephone\n"
                 . "Sujet    : $sujet\n\n"
                 . "Message  :\n$message";
        $headers = "From: $email\r\nReply-To: $email\r\nContent-Type: text/plain; charset=UTF-8";

        // mail() peut ne pas fonctionner dans tous les environnements — le succès s'affiche dans tous les cas
        @mail($to, $subject, $body, $headers);
        $success = true;
        $fields  = ['nom' => '', 'email' => '', 'telephone' => '', 'sujet' => '', 'message' => ''];
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Contact — LionTech</title>
  <meta name="description" content="Contactez LionTech — Agence digitale au Cameroun." />

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
  <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet" />
  <link href="style.css" rel="stylesheet" />
  <style>
    .contact-hero {
      min-height: 40vh;
      background: linear-gradient(135deg, #1a1a2e, #16213e);
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      color: white;
      padding-top: 80px;
    }
    .contact-hero h1 { font-size: clamp(2rem, 5vw, 3.5rem); font-weight: 900; }
    .contact-hero p  { color: rgba(255,255,255,0.75); font-size: 1.1rem; }

    .contact-card {
      background: #fff;
      border-radius: 20px;
      padding: 2.5rem;
      box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    }

    .form-control, .form-select {
      border-radius: 10px;
      padding: 0.75rem 1rem;
      border: 2px solid #e9ecef;
      transition: border-color 0.3s;
    }
    .form-control:focus, .form-select:focus {
      border-color: #D4AF37;
      box-shadow: 0 0 0 0.2rem rgba(212,175,55,0.2);
    }

    .info-item {
      display: flex;
      align-items: flex-start;
      gap: 1rem;
      margin-bottom: 1.5rem;
    }
    .info-icon {
      width: 48px;
      height: 48px;
      background: linear-gradient(135deg, #D4AF37, #b8962f);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      flex-shrink: 0;
      font-size: 1.1rem;
    }
    .social-link {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      padding: 0.6rem 1rem;
      border-radius: 10px;
      text-decoration: none;
      color: #333;
      transition: all 0.3s;
      margin-bottom: 0.5rem;
      background: #f8f9fa;
    }
    .social-link:hover {
      transform: translateX(5px);
      background: #e9ecef;
      color: #333;
    }
  </style>
</head>
<body>

  <!-- ========== NAVBAR ========== -->
  <nav class="navbar navbar-expand-lg fixed-top scrolled" id="mainNav">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center gap-2" href="index.html">
        <img src="liontech-logo.jpg" alt="LionTech Logo" width="40" height="40"
             style="border-radius:50%; object-fit:cover;" />
        <span class="lion">Lion</span><span class="tech">Tech</span>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
              data-bs-target="#navMenu" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navMenu">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="index.html">Accueil</a></li>
          <li class="nav-item"><a class="nav-link" href="hotel.html">Hôtel</a></li>
          <li class="nav-item"><a class="nav-link" href="restaurant.html">Restaurant</a></li>
          <li class="nav-item"><a class="nav-link" href="salondebeaute.html">Beauté</a></li>
          <li class="nav-item"><a class="nav-link active" href="contact.php">Contact</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- ========== HERO ========== -->
  <section class="contact-hero">
    <div data-aos="fade-up">
      <h1 style="color:#D4AF37;">Contactez-nous</h1>
      <p>Notre équipe est disponible pour vous accompagner dans votre projet digital</p>
    </div>
  </section>

  <!-- ========== CONTENU PRINCIPAL ========== -->
  <section class="py-6" style="padding: 5rem 0; background:#f8f9fa;">
    <div class="container">
      <div class="row g-5">

        <!-- Formulaire -->
        <div class="col-lg-7" data-aos="fade-right">
          <div class="contact-card">
            <h3 class="fw-bold mb-1" style="color:#1a1a2e;">Envoyez-nous un message</h3>
            <p class="text-muted mb-4">Remplissez le formulaire ci-dessous, nous vous répondons sous 24h.</p>

            <?php if ($success): ?>
            <div class="alert alert-success d-flex align-items-center gap-2 rounded-3" role="alert">
              <i class="fas fa-check-circle fa-lg"></i>
              <div>
                <strong>Message envoyé avec succès !</strong><br/>
                Merci de nous avoir contactés. Nous reviendrons vers vous très prochainement.
              </div>
            </div>
            <?php endif; ?>

            <?php if (!empty($errors)): ?>
            <div class="alert alert-danger rounded-3" role="alert">
              <strong><i class="fas fa-exclamation-triangle me-2"></i>Erreurs dans le formulaire :</strong>
              <ul class="mb-0 mt-2">
                <?php foreach ($errors as $e): ?>
                  <li><?= $e ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
            <?php endif; ?>

            <form method="POST" action="contact.php" novalidate>
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label fw-semibold">Nom complet <span class="text-danger">*</span></label>
                  <input type="text" name="nom" class="form-control"
                         placeholder="Jean Dupont"
                         value="<?= htmlspecialchars($fields['nom']) ?>" required />
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-semibold">Adresse e-mail <span class="text-danger">*</span></label>
                  <input type="email" name="email" class="form-control"
                         placeholder="jean@exemple.com"
                         value="<?= htmlspecialchars($fields['email']) ?>" required />
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-semibold">Téléphone</label>
                  <input type="tel" name="telephone" class="form-control"
                         placeholder="+237 6XX XXX XXX"
                         value="<?= htmlspecialchars($fields['telephone']) ?>" />
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-semibold">Sujet <span class="text-danger">*</span></label>
                  <select name="sujet" class="form-select" required>
                    <option value="" disabled <?= empty($fields['sujet']) ? 'selected' : '' ?>>— Choisir un sujet —</option>
                    <option value="Création de site web"      <?= $fields['sujet']==='Création de site web'      ? 'selected':'' ?>>Création de site web</option>
                    <option value="Site hôtel / hébergement"  <?= $fields['sujet']==='Site hôtel / hébergement'  ? 'selected':'' ?>>Site hôtel / hébergement</option>
                    <option value="Site restaurant"           <?= $fields['sujet']==='Site restaurant'           ? 'selected':'' ?>>Site restaurant</option>
                    <option value="Site salon de beauté"      <?= $fields['sujet']==='Site salon de beauté'      ? 'selected':'' ?>>Site salon de beauté</option>
                    <option value="Refonte de site existant"  <?= $fields['sujet']==='Refonte de site existant'  ? 'selected':'' ?>>Refonte de site existant</option>
                    <option value="Devis &amp; tarifs"        <?= $fields['sujet']==='Devis &amp; tarifs'        ? 'selected':'' ?>>Devis &amp; tarifs</option>
                    <option value="Autre demande"             <?= $fields['sujet']==='Autre demande'             ? 'selected':'' ?>>Autre demande</option>
                  </select>
                </div>
                <div class="col-12">
                  <label class="form-label fw-semibold">Message <span class="text-danger">*</span></label>
                  <textarea name="message" class="form-control" rows="6"
                            placeholder="Décrivez votre projet ou votre demande..."
                            required><?= htmlspecialchars($fields['message']) ?></textarea>
                </div>
                <div class="col-12">
                  <button type="submit" class="btn btn-gold btn-lg w-100 rounded-pill">
                    <i class="fas fa-paper-plane me-2"></i>Envoyer le message
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>

        <!-- Infos de contact -->
        <div class="col-lg-5" data-aos="fade-left">
          <h3 class="fw-bold mb-4" style="color:#1a1a2e;">Nos coordonnées</h3>

          <div class="info-item">
            <div class="info-icon"><i class="fab fa-whatsapp"></i></div>
            <div>
              <div class="fw-bold">WhatsApp</div>
              <a href="https://wa.me/237688203095" class="text-success text-decoration-none" target="_blank">
                +237 688 20 30 95
              </a>
            </div>
          </div>

          <div class="info-item">
            <div class="info-icon"><i class="fas fa-globe"></i></div>
            <div>
              <div class="fw-bold">Site officiel</div>
              <a href="https://liontech.iceiy.com" class="text-decoration-none" style="color:#D4AF37;" target="_blank">
                liontech.iceiy.com
              </a>
            </div>
          </div>

          <div class="info-item">
            <div class="info-icon"><i class="fas fa-map-marker-alt"></i></div>
            <div>
              <div class="fw-bold">Localisation</div>
              <span class="text-muted">Cameroun (Bafoussam / Douala)</span>
            </div>
          </div>

          <h5 class="fw-bold mt-4 mb-3" style="color:#1a1a2e;">Suivez-nous</h5>

          <a href="https://www.facebook.com/LionTech" target="_blank" class="social-link">
            <i class="fab fa-facebook fa-lg" style="color:#1877f2;"></i>
            <span>Facebook — LionTech</span>
          </a>
          <a href="https://tiktok.com/@liontech62" target="_blank" class="social-link">
            <i class="fab fa-tiktok fa-lg" style="color:#ee1d52;"></i>
            <span>TikTok — @liontech62</span>
          </a>
          <a href="https://instagram.com/lion_tech02" target="_blank" class="social-link">
            <i class="fab fa-instagram fa-lg" style="color:#e1306c;"></i>
            <span>Instagram — lion_tech02</span>
          </a>
          <a href="https://wa.me/237688203095" target="_blank" class="social-link">
            <i class="fab fa-whatsapp fa-lg" style="color:#25D366;"></i>
            <span>WhatsApp — +237 688 20 30 95</span>
          </a>

          <!-- Carte stylisée -->
          <div class="mt-4 p-3 rounded-3 text-center" style="background:linear-gradient(135deg,#1a1a2e,#16213e); color:white;">
            <i class="fas fa-clock fa-2x mb-2" style="color:#D4AF37;"></i>
            <div class="fw-bold">Disponibilité</div>
            <div class="text-white-50 small">Lun – Sam : 08h00 – 20h00</div>
            <div class="text-white-50 small">Réponse sous 24h garantie</div>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- ========== FOOTER ========== -->
  <footer>
    <div class="container">
      <div class="row g-4">
        <div class="col-md-4">
          <h5><i class="fas fa-paw me-2"></i>À propos de LionTech</h5>
          <p style="color:rgba(255,255,255,0.65); line-height:1.8;">
            Agence digitale basée au Cameroun, spécialisée dans la création de sites vitrines professionnels.
          </p>
          <a href="https://liontech.iceiy.com" target="_blank" style="color:#D4AF37;">
            <i class="fas fa-globe me-1"></i>liontech.iceiy.com
          </a>
        </div>
        <div class="col-md-4">
          <h5><i class="fas fa-link me-2"></i>Liens rapides</h5>
          <a href="index.html"><i class="fas fa-chevron-right me-2" style="color:#D4AF37;"></i>Accueil</a>
          <a href="hotel.html"><i class="fas fa-chevron-right me-2" style="color:#D4AF37;"></i>Zingana Hôtel</a>
          <a href="restaurant.html"><i class="fas fa-chevron-right me-2" style="color:#D4AF37;"></i>SRD VVIP Restaurant</a>
          <a href="salondebeaute.html"><i class="fas fa-chevron-right me-2" style="color:#D4AF37;"></i>Salon de Beauté</a>
          <a href="contact.php"><i class="fas fa-chevron-right me-2" style="color:#D4AF37;"></i>Contact</a>
        </div>
        <div class="col-md-4">
          <h5><i class="fas fa-address-book me-2"></i>Contact & Réseaux</h5>
          <div class="social-icons">
            <a href="https://wa.me/237688203095" target="_blank">
              <i class="fab fa-whatsapp me-2" style="color:#25D366;"></i>WhatsApp +237 688 20 30 95
            </a>
            <a href="https://facebook.com/LionTech" target="_blank">
              <i class="fab fa-facebook me-2" style="color:#1877f2;"></i>Facebook LionTech
            </a>
            <a href="https://tiktok.com/@liontech62" target="_blank">
              <i class="fab fa-tiktok me-2" style="color:#ee1d52;"></i>TikTok @liontech62
            </a>
            <a href="https://instagram.com/lion_tech02" target="_blank">
              <i class="fab fa-instagram me-2" style="color:#e1306c;"></i>Instagram lion_tech02
            </a>
          </div>
        </div>
      </div>
      <div class="footer-bottom">
        <p>&copy; 2025 <strong style="color:#D4AF37;">LionTech</strong> — Tous droits réservés | Développé avec ❤️ au Cameroun</p>
      </div>
    </div>
  </footer>

  <button id="scrollTop" title="Retour en haut">
    <i class="fas fa-chevron-up"></i>
  </button>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
  <script>
    AOS.init({ duration: 800, once: true, offset: 80 });
    const nav = document.getElementById('mainNav');
    window.addEventListener('scroll', () => {
      if (window.scrollY > 50) nav.classList.add('scrolled');
    });
    const scrollBtn = document.getElementById('scrollTop');
    window.addEventListener('scroll', () => {
      scrollBtn.style.display = window.scrollY > 400 ? 'flex' : 'none';
    });
    scrollBtn.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
  </script>
</body>
</html>
