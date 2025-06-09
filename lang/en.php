<?php
// lang/en.php — English keys
return [
    '__lang_code' => 'en', // ou 'fr'

    'welcome_title' => 'Welcome to Lightspeed to Odoo',
    'welcome_message' => 'Please upload your CSV file to get started.',

    // INSTALLATION
    'install_title' => 'Lightspeed to Odoo Installation',
    'install_mysql_title' => '🔧 MySQL Database',
    'install_mysql_host' => 'MySQL Host',
    'install_mysql_name' => 'Database Name',
    'install_mysql_user' => 'User',
    'install_mysql_pass' => 'Password',
    'install_odoo_title' => '🔗 Odoo Connection',
    'install_odoo_url' => 'Server URL',
    'install_odoo_db' => 'Odoo Database Name',
    'install_odoo_login' => 'Odoo Login',
    'install_odoo_pass' => 'Odoo Password',
    'install_odoo_api' => 'API Key (optional)',
    'install_appearance_title' => '🎨 Site Appearance',
    'install_site_name' => 'Site Name',
    'install_site_logo' => 'Site Logo',
    'install_theme_night' => 'Emerald Night',
    'install_theme_day' => 'Emerald Day',
    'install_admin_title' => '👑 Administrator Account',
    'install_admin_email' => 'Admin Email',
    'install_admin_pass' => 'Password',
    'install_test_button' => '🔍 Test Connections',
    'install_submit_button' => '🚀 Install',

    // INSTALLATION — JS MESSAGES
    'install_testing' => '⏳ Checking connections...',
    'install_mysql_error' => 'MySQL connection failed.',
    'install_odoo_error' => 'Odoo connection failed.',
    'install_network_error' => 'A network error occurred.',
    'install_success' => '✅ Connections successful! You may now install.',

    // AUTHENTICATION
    'login_title' => 'Login',
    'login_email' => 'Email address',
    'login_password' => 'Password',
    'login_submit' => 'Sign in',
    'login_missing_fields' => 'Please fill in all fields.',
    'login_invalid_credentials' => 'Invalid credentials.',
    'login_error' => 'Login error',

    // USERS
    'users_title' => 'User management',
    'users_email' => 'Email address',
    'users_password' => 'Password',
    'users_role' => 'Role',
    'users_role_user' => 'User',
    'users_role_admin' => 'Administrator',
    'users_add_button' => 'Add user',
    'users_add_success' => 'User successfully added.',
    'users_add_exists' => 'This user already exists.',
    'users_add_error' => 'Invalid or incomplete fields.',
    'users_actions' => 'Actions',
    'users_delete_button' => 'Delete',
    'users_deleted' => 'User deleted.',
    'users_confirm_delete' => 'Delete this user?',
    'users_self' => 'Your account',

    // THEMES
    'theme_title' => 'Theme selection',
    'theme_submit' => 'Save theme',
    'theme_changed' => 'Theme successfully changed.',
    'theme_invalid' => 'Invalid theme selected.',

    // IMPORT ADMIN
    'import_title' => 'CSV Import - Administration',
    'import_upload_label' => 'CSV file to import',
    'import_upload_button' => 'Analyze file',
    'import_success' => 'File successfully uploaded.',
    'import_failed' => 'Failed to upload the file.',
    'import_columns_title' => 'Columns detected in the file',
    'mapping_saved' => 'Mapping model saved successfully.',
    'mapping_invalid' => 'Invalid or incomplete mapping model.',
    'mapping_save_button' => 'Save mapping',
    'mapping_name_label' => 'Mapping model name',
    'import_real_title' => 'Import file into Odoo',
    'import_real_mapping_label' => 'Mapping model to use',
    'choose_mapping' => '— Select a mapping —',
    'import_real_button' => 'Import into Odoo',
    'import_results_title' => 'Import results',
    'import_row' => 'Row',
    'import_mapping_not_found' => 'Mapping not found or invalid.',

    // ODOO FIELD TRANSLATIONS
    'odoo_field_name' => 'Product Name',
    'odoo_field_default_code' => 'Internal Reference',
    'odoo_field_barcode' => 'Barcode',
    'odoo_field_list_price' => 'Sales Price',
    'odoo_field_standard_price' => 'Cost',
    'odoo_field_type' => 'Product Type',
    'odoo_field_categ_id' => 'Category',
    'odoo_field_pos_categ_id' => 'POS Category',
    'odoo_field_available_in_pos' => 'Available in POS',
    'odoo_field_to_weight' => 'Weighable',
    'odoo_field_taxes_id' => 'Customer Taxes',
    'odoo_field_supplier_taxes_id' => 'Vendor Taxes',
    'odoo_field_uom_id' => 'Unit of Measure',
    'odoo_field_uom_po_id' => 'Purchase Unit',
    'odoo_field_description' => 'Internal Description',
    'odoo_field_description_sale' => 'Sale Description',
    'odoo_field_description_purchase' => 'Purchase Description',
    'odoo_field_image_1920' => 'Main Image',
    'odoo_field_tracking' => 'Lot Tracking',
    'odoo_field_detailed_type' => 'Simplified Type',

    // ODOO
    'odoo_config_missing' => 'Missing Odoo configuration file.',
    'odoo_config_incomplete' => 'Incomplete Odoo connection settings.',
    'odoo_auth_failed' => 'Failed to authenticate with Odoo.',
    'odoo_create_success' => 'Product created successfully',
    'odoo_create_unknown_error' => 'Unknown error occurred during product creation.',

    // IMPORT / MAPPING / CSV - USER
    'import_user_title' => 'CSV Import - User',
    'no_mapping_available' => 'No mapping model is currently available.',

    // IMPORT LOGS HISTORY
    'logs_title' => 'Import History',
    'logs_none' => 'No import has been logged yet.',
    'logs_date' => 'Date',
    'logs_user' => 'User',
    'logs_file' => 'File',
    'logs_mapping' => 'Mapping',
    'logs_status' => 'Status',
    'logs_message' => 'Message',
    'logs_import_message_success' => 'Import completed successfully.',
    'logs_import_message_error' => 'Import completed with errors.',

];
