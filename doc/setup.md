# SETUP

## login api
Il faut générer une clé ssh pour faire fonctionner le [bundle](https://github.com/lexik/LexikJWTAuthenticationBundle/) qui gère le login en API
```
$ openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096
$ openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout
```