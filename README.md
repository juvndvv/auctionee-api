
## Arquitectura

- [x] Bus de eventos con Pusher
- [x] Bus de comandos en memoria
- [x] Bus de queries en memoria
- [x] Caso de uso de subir imagenes a Cloudflare R2
- [x] Caso de uso de eliminar imagenes de Cloudflare R2
- [x] Establecer excepciones globales
- [x] Establecer respuestas globales

## User

- [x] Modelado de la base de datos
- [x] Modelado del repositorio
- [x] Modelado del dominio
- [x] Endpoint Caso de uso de crear usuario
- [x] Endpoint Caso de uso de borrar usuario
- [x] Endpoint Caso de uso de buscar todos los usuarios
- [x] Endpoint Caso de uso de buscar usuario por nombre
- [x] Endpoint Caso de uso de buscar usuario por UUID
- [x] Endpoint Caso de uso de bloquear usuario
- [x] Endpoint Caso de uso de actualizar avatar
- [x] Endpoint Caso de uso de actualizar email
- [x] Endpoint Caso de uso de actualizar nombre
- [x] Endpoint Caso de uso de actualizar contraseña
- [x] Endpoint Caso de uso de actualizar el nombre de usuario

## Email

- [x] Modelado del dominio
- [ ] Reestructurar las carpetas (mover lo de Shared o Retention)
- [ ] Definir que casos faltan para enviar emails

## Notificaciones

- [ ] Definir que eventos generan notificaciones y a quien
- [ ] Modelado de la base de datos
- [ ] Modelado del dominio
- [ ] Listener Caso de uso de enviar notificacion
- [ ] Listener Caso de uso de guardar notificacion
- [ ] Endpoint Caso de uso de marcar como leida

## Social

- [x] Modelado de la base de datos
- [ ] Modelado del dominio
- [ ] Modelado del repositorio
- [ ] Endpoint Caso de uso de enviar peticion de amistad
- [ ] Endpoint Caso de uso de aceptar peticion de amistad
- [ ] Endpoint Caso de uso de rechazar peticion de amistad
- [ ] Endpoint Caso de uso de eliminar amigo
- [ ] Endpoint Caso de uso de obtener lista de amigos
- [ ] Endpoint Caso de uso de guardar mensaje
- [ ] Endpoint Caso de uso de eliminar un mensaje
- [ ] Endpoint Caso de uso de recuperar mensajes de una conversacion

## Financial

- [x] Modelado de la base de datos
- [x] Modelado del repositorio
- [x] Modelado del dominio
- [x] Listener UserCreatedEvent Caso de uso de crear Wallet
- [x] Endpoint Caso de uso de hacer transaccion
- [x] Endpoint Caso de uso de buscar transacciones por uuid de Wallet
- [x] Endpoint Caso de uso de ingresar dinero
- [x] Endpoint Caso de uso de retirar dinero
- [ ] Hacer que los ingresos y retiradas apunten a wallets del sistema y generen transacciones

## Auction

- [ ] Mirar como programar tareas
- [ ] Modelado de la base de datos
- [ ] Modelado del repositorio
- [ ] Modelado del dominio
- [ ] Endpoint Caso de uso de crear subasta
- [ ] Endpoint Caso de uso de editar subasta
- [ ] Endpoint Caso de uso de eliminar subasta
- [ ] Endpoint Caso de uso de pujar en subasta
- [ ] Endpoint Caso de uso de finalizar subasta

## Miscelaneo

- [ ] Paginar respuestas grandes
- [ ] Pedir dominios
- [ ] VPS para desplegar la API
- [ ] Workflow de GitHub para desplegar back y front
- [ ] Buscar donde desplegar el Frontend
- [x] Configuración de Sail
- [x] Configurar Pusher
- [x] Configurar Cloudflare
- [x] Configurar Resend

## Dudas

Necesito crear una lista de transacciones y una galeria de imagenes, como es mejor hacerlo en el dominio: Collection, crear una entidad que internamente sea una collection...

Devolver acciones en las respuestas es habitual? Si es asi, como guardo los endpoints para no tener que hardcodearlos en todos los sitios?
