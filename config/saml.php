<?php
return [
    'strict' => true,
    'debug' => true,
    'sp' => [
        'entityId' => 'http://localhost:8080/saml/metadata',
        'assertionConsumerService' => [
            'url' => 'http://localhost:8080/saml/acs',
        ],
        'singleLogoutService' => [
            'url' => 'http://localhost:8080/saml/logout',
        ],
        'x509cert' => '',
        'privateKey' => '',
    ],
    'idp' => [
        'entityId' => 'https://login.microsoftonline.com/29301760-1a2d-4a15-9d08-159168ad5387/',
        'singleSignOnService' => [
            'url' => 'https://login.microsoftonline.com/29301760-1a2d-4a15-9d08-159168ad5387/saml2',
        ],
        'singleLogoutService' => [
            'url' => 'https://login.microsoftonline.com/29301760-1a2d-4a15-9d08-159168ad5387/logout',
        ],
        'x509cert' => '-----BEGIN CERTIFICATE----- YOUR_AZURE_CERT -----END CERTIFICATE-----',
    ],
];
