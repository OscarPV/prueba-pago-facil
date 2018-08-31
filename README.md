Prueba Pago Fácil

Para la prueba se utilizó el micro-framework Lumen debido a que está especialmente diseñado para desarrollar webservices y api's. Debido a que está basado en Laravel, la integración con el mismo se puede realizar sin problema en caso de necesitarse en un futuro.

Las rutas quedaron definidas de la siguiente forma:
GET - http://localhost/webservice/public/api/v1/alumnos/:idAlumno/calificaciones
Obtiene la lista de calificaciones del alumno.

POST - http://localhost/webservice/public/api/v1/alumnos/:idAlumno/calificaciones
Crea una nueva calificación para el alumno.

PUT - http://localhost/webservice/public/api/v1/alumnos/:idAlumno/materias/:idMateria/calificaciones
Actualiza una calificación tomando en cuenta el alumno y la materia.

DELETE - http://localhost/webservice/public/api/v1/alumnos/:idAlumno/materias/:idMateria/calificaciones
Elimina una calificación tomando en cuenta el alumno y la materia.

Nota: Se eligieron las anteriores rutas tratando de que fueran descriptivas y se adhirieran lo más posible al estilo de arquitectura REST.

Se agregó un método sencillo de autenticación para las peticiones POST, PUT y DELETE, consiste en incluir en el cuerpo de la petición una clave "api_token" con el string "hola123.". Debido a que es sólo una prueba y a las limitaciones de tiempo se decidió crear sólo un token estático.
