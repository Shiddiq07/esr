<?php
/**
 * LIST OF ENVIRONMENTAL VARIABLES
 */
define("APP_NAME", 'ESR Directorate');
define("APP_FULLNAME", 'Executive Summary Report');
define("APP_YEAR", 2024);
define("APP_COPYRIGHT", 'ICT Pusat');
define("APP_COMPANY", 'LP3I');
define("COMPANY_PAGE", 'https://lp3i.ac.id');
define("APP_DESC", 'Get instant insights with our Executive Summary Report App! Easily generate concise, data-driven reports that help you make informed decisions and drive business growth.');
define("APP_KEYWORDS", 'Executive Summary Report, Report Generation, Ilham D. Sofyan, ICT LP3I, Data Analysis Tool');

define("DB_CONNECTION", 'mysql');
define("DB_HOST", 'localhost');
define("DB_DATABASE", 'name');
define("DB_USERNAME", 'root');
define("DB_PASSWORD", '');

define("DB_CONNECTION_COLLEGE", 'mysql');
define("DB_HOST_COLLEGE", 'localhost');
define("DB_DATABASE_COLLEGE", 'name');
define("DB_USERNAME_COLLEGE", 'root');
define("DB_PASSWORD_COLLEGE", '');

define("DB_CONNECTION_PLJ", 'mysql');
define("DB_HOST_PLJ", 'localhost');
define("DB_DATABASE_PLJ", 'name');
define("DB_USERNAME_PLJ", 'root');
define("DB_PASSWORD_PLJ", '');

define("DB_CONNECTION_LMS", 'mysql');
define("DB_HOST_LMS", 'localhost');
define("DB_DATABASE_LMS", 'name');
define("DB_USERNAME_LMS", 'root');
define("DB_PASSWORD_LMS", '');

define("LOCATIONIQ_API_KEY", '');

define("GOOGLE_ID", '');
define("GOOGLE_SECRET", '');
define("RECAPTCHA_ID", '6Lf8ZO0pAAAAAPAiSAByd2pp1_R090ZDQ6lUklm5');
define("RECAPTCHA_SECRET", '6Lf8ZO0pAAAAAF8Lf--o6yxEAT5Fsl1XLuNJi5sa');

define("MAIL_OFFICIAL", '');
define("MAIL_HOST", '');
define("MAIL_USER", '');
define("MAIL_PASS", '');
define("MAIL_PORT", '');

define("JWT_SERVER_NAME", 'https://lp3i.ac.id');
define("JWT_ACCESS_TOKEN", 'access_token');
define("JWT_REFRESH_TOKEN", 'refresh_token');

define("MAINTENANCE", false);
define("MAINTENANCE_ALLOWED_IP", "127.0.0.1");
define("MAINTENANCE_UNTIL", "2021/07/27 04:00:00");

define("CSRF_TOKEN", true);
define("CSRF_EXPIRES_IN", 7100);

define("HRIS_URL", 'http://localhost/hris-new/');
define("API_URL", 'http://localhost/hris-new/api');
define("SSO_URL", '');
define("SSO_CLIENT_ID", '');
define("SSO_CLIENT_SECRET", '');

define("ALGOLIA_CLIENT", '');
define("ALGOLIA_WRITE_SECRET", '');
define("ALGOLIA_READ_SECRET", '');

define("TELEGRAM_TOKEN", 'BOT-TOKEN');
define("TELEGRAM_CHANNEL_ID", 'CHANNEL-ID');
define("TELEGRAM_URL", 'https://api.telegram.org/bot'. TELEGRAM_TOKEN .'/sendMessage');
