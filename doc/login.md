```
curl -X POST -H "Content-Type: application/json" http://127.0.0.1:8000/api/login_check -d '{"username":"EMAIL","password":"MOTDEPASSE"}'
```

Avec le bundle qui gère le connection les params sont bien `username` et `password` mais il faut bien faire attention a envoyer l'email dans le param `username`
