# OAuth_proxy

proxy handlers:

- LoginHandler::class
- LogoutHandler::class
- AccessHandler::class

# Example

```php
<?php

$converter = new JWTConverter();

$httpClient = new GuzzleHttpClient();

$configStore = new DotEnvConfigStorage(__DIR__ . '/../');
$configStore->load();
```

.env example

```env
OAUTH_BASE_URL="http://172.17.0.1:8080"

OAUTH_TYPE="Bearer"

OAUTH_URL="oauth/auth"
OAUTH_CHECK_URL="oauth/user/check"
OAUTH_LOGOUT_URL="oauth/user/logout"

OAUTH_GRANT_TYPE="password_domain"
OAUTH_REFRESH_GRANT_TYPE="refresh_domain"
OAUTH_DOMAIN="test.com"

OAUTH_CLIENT_ID="app"
OAUTH_CLIENT_SECRET=""
OAUTH_ACCESS_TYPE="offline"
```
