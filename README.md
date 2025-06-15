
# Lightspeed K-Series to Odoo POS Importer (Version 2.5.5)

---

## 🔥 Description du projet

Application sécurisée web en PHP permettant d’importer des exports CSV de Lightspeed K-Series vers Odoo POS via JSON-RPC.

- Multi-thème (design EmeraldNight & EmeraldDay)
- Multi-utilisateur (admin / user)
- Gestion sécurisée AES pour les connexions MySQL et Odoo
- Import CSV intelligent avec gestion de mapping dynamique
- Logs d’import enrichis et filtrables
- Architecture entièrement modulaire

---

## 📦 Fonctionnalités livrées (V2.5.5)

- Interface administrateur d'import CSV
- Création et édition des mappings CSV ↔ Odoo POS
- Prévisualisation des colonnes CSV à l'import
- Séparation complète des rôles admin/user
- Gestion sécurisée des identifiants Odoo (cryptage AES)
- Journalisation complète des imports (détails ligne par ligne)
- Logs filtrables par utilisateur, mapping et date
- Gestion sécurisée des erreurs retournées par Odoo (enrichies et affichées)
- Architecture View Fusion pour supporter les multi-thèmes
- Compatibilité MySQL 5.7+ et PHP 8.1+

---

## 🔐 Sécurité technique

- Chiffrement AES de la configuration MySQL & Odoo via `crypto.php`
- Gestion PDO sécurisée (try/catch, erreurs levées)
- Anti injection SQL via requêtes préparées
- Sessions PHP sécurisées avec gestion stricte des droits
- Aucune structure HTML dans les fichiers PHP (strictement dans `/views/`)

---

## 📂 Arborescence des fichiers

/admin/
    import_real.php
    mapping_create.php
    logs.php
    log_details.php

/includes/
    auth.php
    loader.php
    pdo.php
    odoo.php
    crypto.php
    settings.php
    Lang.php
    View.php

/views/
    admin_import_real.php
    admin_mapping_create.php
    admin_logs.php
    admin_log_details.php

/template/
    emeraldnight/
    emeraldday/

/install/
    index.php
    process.php

/test/
    odoo_encrypt_tool.php
    test_odoo_decrypt.php

/login.php
/logout.php
/profil.php
/index.php
/config.php
/README.md

---

## 🛠 Procédure d’installation (rappel rapide)

1️⃣ Déployer les fichiers sur votre serveur PHP (hébergement mutualisé type o2switch)

2️⃣ Lancer `/install/` :

- Configurer MySQL et Odoo
- Générer `config.php` automatiquement via l'interface d'installation

3️⃣ L'accès administrateur démarre via `login.php` après installation complète

4️⃣ Gestion des mappings et imports disponible dans `/admin/`

---

## 📌 Prochaine phase à venir (Phase 6)

- Mapping relationnel intelligent (gestion automatique des Many2One pour Odoo)
- Création automatique des catégories et taxonomies Odoo lors des imports
- Interface utilisateur d'import simplifiée et sécurisée
- Générateur de mapping assisté semi-automatique

---

## 🔧 Stack technique

- PHP 8.1+
- MySQL 5.7+
- Hébergement mutualisé OVH ou o2switch
- Aucun framework externe (100% code natif PHP / HTML / CSS / JS)
