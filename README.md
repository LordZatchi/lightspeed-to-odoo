
# Lightspeed to Odoo POS CSV Importer

---

## 🔒 Projet sécurisé et stabilisé (v1.0 AES)

**Objectif** :  
Permet d'importer des fichiers CSV issus de Lightspeed K (Série K) vers Odoo POS via une interface web sécurisée.

---

## 🧱 Technologies utilisées

- PHP 8.x (procédural et objet léger)
- MySQL (stockage BDD)
- HTML5 / CSS3 (multithème EmeraldNight / EmeraldDay)
- JavaScript léger (pas de framework JS externe)
- AES-256 pour le chiffrement des mots de passe (Odoo & MySQL)
- PDO sécurisé (connexion centralisée)

---

## 🚀 Fonctionnalités principales

- ✅ **Installation web sécurisée**
- ✅ **Connexion MySQL et Odoo vérifiée lors de l'installation**
- ✅ **Chiffrement AES-256 complet**
- ✅ **Gestion des mappings CSV ↔ Odoo réutilisables**
- ✅ **Historique des imports**
- ✅ **Multi-thème EmeraldNight / EmeraldDay**
- ✅ **Multi-langue FR/EN**
- ✅ **Gestion des utilisateurs (admin / user)**
- ✅ **Logs complets des imports**

---

## 📂 Structure des répertoires

```bash
/includes/      → Code métier sécurisé (pdo, odoo, settings, crypto)
/admin/         → Interface administrateur (mappings, settings, logs)
/install/       → Installateur web sécurisé
/lang/          → Fichiers de langue (fr.php, en.php)
/template/      → Templates multithèmes (emeraldnight, emeraldday)
/uploads/       → Logo du site
/config.php     → Paramètres MySQL chiffrés AES
```

---

## 🔐 Sécurité & chiffrement

- Tous les mots de passe sont stockés chiffrés avec AES-256 (fonction `encrypt()` / `decrypt()`).
- La clé de chiffrement est stockée dans :  
  ```bash
  /includes/secret.php
  ```
- **Attention : ce fichier est exclu du Git via `.gitignore` (ne jamais versionner la clé).**

---

## ⚙ Fichier `.gitignore` recommandé

```bash
/includes/secret.php
/uploads/*
config.php
.env
```

---

## 🚩 Installation

1️⃣ Déployer les fichiers sur un serveur PHP/MySQL compatible.  
2️⃣ Accéder à `/install/` pour lancer l'installation web.  
3️⃣ Tester les connexions MySQL et Odoo avant validation.  
4️⃣ Créer le premier administrateur.

---

## 📅 Roadmap V2 (à venir)

- ✅ Edition et suppression des mappings existants
- ✅ Mode debug global activable
- ✅ Gestion centralisée des logs d’erreurs Odoo
- ✅ Fonction d'import CSV automatique depuis fichiers serveur
- ✅ Gestion fine des permissions utilisateurs
- ✅ Prévisualisation des imports avant exécution

---

## 👨‍💻 Auteur & contributions

Projet développé étape par étape avec validation manuelle sur chaque fichier pour garantir propreté, stabilité et évolutivité.

*Hébergement actuel : o2switch*  
*Version stabilisée AES : v1.0*

---

**Nous réanimons votre technologie.** 🛠️
