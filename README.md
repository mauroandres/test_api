Las urls son: 
get /users
get /users/{id}
post /users
put /users/{id}
delete /users/{id}

Ejemplo de post con curl:
curl -X POST -H "Content-Type: application/x-www-form-urlencoded" -H "Cache-Control: no-cache" -d 'name=lisandro&email=lisandro@racing.com' --data-urlencode "image=$(base64 ~/path/to/image.jpg)" "http://127.0.0.1:8000/users"

Ejemplo de post put curl:
curl -X PUT -H "Content-Type: application/x-www-form-urlencoded" -H "Cache-Control: no-cache" -d 'name=lisandro&email=lisandro@racing.com' --data-urlencode "image=$(base64 ~/path/to/image.jpg)" "http://127.0.0.1:8000/users/1"

TODO:
1 - Hacer la validacion correspondiente para el parametro image de users.
2 - Usar Middleware para autenticacion de request.
3 - Mover las validaciones de los parametros a otra clase.
4 - Hacer los tests.
