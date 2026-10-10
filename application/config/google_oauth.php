<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 | -----------------------------------------------------------------------
 | GOOGLE OAUTH CREDENTIALS
 | -----------------------------------------------------------------------
 | 1. Go to https://console.cloud.google.com
 | 2. Create a project → APIs & Services → Credentials
 | 3. Create OAuth 2.0 Client ID → Web Application
 | 4. Add Authorized Redirect URI:
 |       http://yourdomain.com/auth/google_callback
 | 5. Paste your Client ID and Secret below
 | -----------------------------------------------------------------------
 | Leave both empty to hide the "Continue with Google" button.
 */

$config['google_client_id']     = '';   // ← paste your Client ID here
$config['google_client_secret'] = '';   // ← paste your Client Secret here
