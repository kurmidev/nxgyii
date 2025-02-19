<?php

return [
    'strict' => true,
    'debug' => true,
    'sp' => [
        'entityId' => 'http://localhost:8080/?r=saml/metadata',
        'assertionConsumerService' => [
            'url' => 'http://localhost:8080/index.php?r=saml/acs',
        ],
        'singleLogoutService' => [
            'url' => 'http://localhost:8080/?r=saml/logout',
        ],
        'NameIDFormat' => 'urn:oasis:names:tc:SAML:1.1:nameid-format:emailAddress',
        'x509cert' => '', // SP Certificate (if needed)
        'privateKey' => '', // SP Private Key (if needed)
    ],
    'idp' => [
        'entityId' => 'https://sts.windows.net/29301760-1a2d-4a15-9d08-159168ad5387/',
        'singleSignOnService' => [
            'url' => 'https://login.microsoftonline.com/29301760-1a2d-4a15-9d08-159168ad5387/saml2',
        ],
        'singleLogoutService' => [
            'url' => 'https://login.microsoftonline.com/29301760-1a2d-4a15-9d08-159168ad5387/saml2',
        ],
        'x509cert' => file_get_contents(__DIR__ . '/NXGSSOApp.pem'),
        //'x509cert' => '-----BEGIN CERTIFICATE----- YOUR_AZURE_CERT -----END CERTIFICATE-----',
    ],
    'security' => [
        'authnRequestsSigned' => false,
        'logoutRequestSigned' => false,
        'signMetadata' => false,
    ],

];
