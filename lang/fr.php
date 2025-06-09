<?php
// lang/fr.php — clés en français
return [
    '__lang_code' => 'fr', // ou 'en'

    'welcome_title' => 'Bienvenue dans Lightspeed to Odoo',
    'welcome_message' => 'Veuillez importer votre fichier CSV pour commencer.',

    // INSTALLATION
    'install_title' => 'Installation de Lightspeed vers Odoo',
    'install_mysql_title' => '🔧 Base de données MySQL',
    'install_mysql_host' => 'Hôte MySQL',
    'install_mysql_name' => 'Nom de la base',
    'install_mysql_user' => 'Utilisateur',
    'install_mysql_pass' => 'Mot de passe',
    'install_odoo_title' => '🔗 Connexion Odoo',
    'install_odoo_url' => 'URL du serveur',
    'install_odoo_db' => 'Nom de la base Odoo',
    'install_odoo_login' => 'Login Odoo',
    'install_odoo_pass' => 'Mot de passe Odoo',
    'install_odoo_api' => 'Clé API (optionnelle)',
    'install_appearance_title' => '🎨 Apparence du site',
    'install_site_name' => 'Nom du site',
    'install_site_logo' => 'Logo du site',
    'install_theme_night' => 'Emerald Night',
    'install_theme_day' => 'Emerald Day',
    'install_admin_title' => '👑 Compte administrateur',
    'install_admin_email' => 'Email administrateur',
    'install_admin_pass' => 'Mot de passe',
    'install_test_button' => '🔍 Tester connexions',
    'install_submit_button' => '🚀 Installer',

    // INSTALLATION — MESSAGES JS
    'install_testing' => '⏳ Vérification des connexions en cours...',
    'install_mysql_error' => 'Connexion MySQL échouée.',
    'install_odoo_error' => 'Connexion Odoo échouée.',
    'install_network_error' => 'Une erreur réseau est survenue.',
    'install_success' => '✅ Connexions MySQL et Odoo réussies ! Vous pouvez installer.',

    // AUTHENTIFICATION
    'login_title' => 'Connexion',
    'login_email' => 'Adresse e-mail',
    'login_password' => 'Mot de passe',
    'login_submit' => 'Se connecter',
    'login_missing_fields' => 'Veuillez remplir tous les champs.',
    'login_invalid_credentials' => 'Identifiants invalides.',
    'login_error' => 'Erreur lors de la connexion',

    // UTILISATEURS
    'users_title' => 'Gestion des utilisateurs',
    'users_email' => 'Adresse e-mail',
    'users_password' => 'Mot de passe',
    'users_role' => 'Rôle',
    'users_role_user' => 'Utilisateur',
    'users_role_admin' => 'Administrateur',
    'users_add_button' => 'Ajouter l\'utilisateur',
    'users_add_success' => 'Utilisateur ajouté avec succès.',
    'users_add_exists' => 'Cet utilisateur existe déjà.',
    'users_add_error' => 'Champs invalides ou incomplets.',
    'users_actions' => 'Actions',
    'users_delete_button' => 'Supprimer',
    'users_deleted' => 'Utilisateur supprimé.',
    'users_confirm_delete' => 'Supprimer cet utilisateur ?',
    'users_self' => 'Vous-même',

    // THEMES
    'theme_title' => 'Choix du thème',
    'theme_submit' => 'Enregistrer le thème',
    'theme_changed' => 'Le thème a bien été changé.',
    'theme_invalid' => 'Thème sélectionné invalide.',

    // IMPORT ADMIN
    'import_title' => 'Import CSV - Administration',
    'import_upload_label' => 'Fichier CSV à importer',
    'import_upload_button' => 'Analyser le fichier',
    'import_success' => 'Fichier importé avec succès.',
    'import_failed' => 'Échec de l\'upload du fichier.',
    'import_columns_title' => 'Colonnes détectées dans le fichier',
    'mapping_saved' => 'Modèle de mapping enregistré avec succès.',
    'mapping_invalid' => 'Modèle de mapping invalide ou incomplet.',
    'mapping_save_button' => 'Enregistrer le mapping',
    'mapping_name_label' => 'Nom du modèle de mapping',
    'import_real_title' => 'Importer un fichier vers Odoo',
    'import_real_mapping_label' => 'Modèle de mapping à utiliser',
    'choose_mapping' => '— Sélectionner un mapping —',
    'import_real_button' => 'Lancer l\'import vers Odoo',
    'import_results_title' => 'Résultats de l\'import',
    'import_row' => 'Ligne',
    'import_mapping_not_found' => 'Mapping introuvable ou invalide.',

    // TRADUCTION DES CHAMPS ODOO
    'odoo_field_name' => 'Nom du produit',
    'odoo_field_default_code' => 'Référence interne',
    'odoo_field_barcode' => 'Code-barres',
    'odoo_field_list_price' => 'Prix de vente',
    'odoo_field_standard_price' => 'Coût',
    'odoo_field_type' => 'Type de produit',
    'odoo_field_categ_id' => 'Catégorie',
    'odoo_field_pos_categ_id' => 'Catégorie POS',
    'odoo_field_available_in_pos' => 'Disponible au POS',
    'odoo_field_to_weight' => 'À peser',
    'odoo_field_taxes_id' => 'Taxes client',
    'odoo_field_supplier_taxes_id' => 'Taxes fournisseur',
    'odoo_field_uom_id' => 'Unité de mesure',
    'odoo_field_uom_po_id' => 'Unité d’achat',
    'odoo_field_description' => 'Description interne',
    'odoo_field_description_sale' => 'Description vente',
    'odoo_field_description_purchase' => 'Description achat',
    'odoo_field_image_1920' => 'Image principale',
    'odoo_field_tracking' => 'Suivi par lot',
    'odoo_field_detailed_type' => 'Type simplifié',

    // ODOO
    'odoo_config_missing' => 'Fichier de configuration Odoo manquant.',
    'odoo_config_incomplete' => 'Paramètres de connexion Odoo incomplets.',
    'odoo_auth_failed' => 'Échec de l\'authentification auprès d\'Odoo.',
    'odoo_create_success' => 'Produit créé avec succès',
    'odoo_create_unknown_error' => 'Erreur inconnue lors de la création du produit.',

    // IMPORT / MAPPING / CSV - UTILISATEUR
    'import_user_title' => 'Import CSV - Utilisateur',
    'no_mapping_available' => 'Aucun modèle de mapping n\'est disponible pour le moment.',

    // HISTORIQUE DES IMPORTS
    'logs_title' => 'Historique des imports',
    'logs_none' => 'Aucun import enregistré pour le moment.',
    'logs_date' => 'Date',
    'logs_user' => 'Utilisateur',
    'logs_file' => 'Fichier',
    'logs_mapping' => 'Mapping',
    'logs_status' => 'Statut',
    'logs_message' => 'Message',
    'logs_import_message_success' => 'Import terminé avec succès.',
    'logs_import_message_error' => 'Import terminé avec des erreurs.',
    'pagination_prev' => '« Précédent',
    'pagination_next' => 'Suivant »',
    'pagination_page' => 'Page',

    // MAPPINGS
    'mappings_title' => 'Modèles de mapping',
    'mapping_none' => 'Aucun modèle de mapping trouvé.',
    'mapping_name' => 'Nom',
    'mapping_date' => 'Créé le',
    'mapping_actions' => 'Actions',
    'mapping_delete' => 'Supprimer',
    'mapping_deleted' => 'Modèle supprimé avec succès.',
    'mapping_confirm_delete' => 'Confirmer la suppression de ce mapping ?',
    'mapping_saved_success' => 'Modèle de mapping enregistré avec succès.',

    // MAPPING - ÉDITION
    'mapping_edit_title' => 'Modifier le modèle',
    'mapping_no_columns' => 'Aucune colonne CSV enregistrée pour ce mapping.',
    'mapping_ignore' => 'Ignorer',
    'mapping_not_found' => 'Modèle introuvable.',
    'mapping_invalid_id' => 'ID de mapping invalide.',
    'back' => 'Retour',
    'mapping_edit' => 'Modifier',

];
