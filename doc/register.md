```http://127.0.0.1:8000/api/public/register```
```
{
    "email": "test@email.com",
    "password": "motdepasse",
    "password_repeat": "motdepasse",
    "firstname": "firstname_test",
    "lastname": "lastname_test"
}
```

en cas de succes, valeur de retour:
```
{
    "id": 4,
    "email": "test@email.com",
    "username": "test@email.com",
    "roles": [
        "ROLE_USER"
    ],
    "password": "$argon2id$v=19$m=65536,t=4,p=1$tERpxV8upidTZKokKtRqbA$edM6UGeM3e49rteeARIiIKaO6qCJdXA+QizimAWbcS4",
    "salt": null,
    "firstname": "firstname_test",
    "lastname": "firstname_test"
}
```
en cas d'echec, un array qui indique les erreurs
```
[
    "email",
    "firstname",
    "lastname",
    "password_repeat"
]
```