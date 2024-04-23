
## Infraestructura

- [ ] Pedir dominios
- [ ] VPS para desplegar la API
- [ ] Buscar donde desplegar el Frontend
- [x] Configuración de Sail
- [x] Configurar Pusher
- [x] Configurar Cloudflare
- [x] Configurar Resend

## Arquitectura

- [x] Bus de eventos con Pusher
- [x] Bus de comandos en memoria
- [x] Bus de queries en memoria
- [x] Caso de uso de subir imagenes a Cloudflare R2
- [x] Caso de uso de eliminar imagenes de Cloudflare R2
- [x] Establecer excepciones
- [x] Respuestas globales

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
- [ ] Definir que casos faltan para enviar emails

## Notificaciones

- [ ] Definir que eventos generan notificaciones
- [ ] Modelado de la base de datos
- [ ] Modelado del dominio
- [ ] Listener Caso de uso de enviar notificacion
- [ ] Listener Caso de uso de guardar notificacion
- [ ] Endpoint Caso de uso de marcar como leida

## Social

- [ ] Modelado de la base de datos
- [ ] Modelado del repositorio
- [ ] Modelado del dominio
- [ ] Endpoint Caso de uso de enviar peticion de amistad
- [ ] Endpoint Caso de uso de aceptar peticion de amistad
- [ ] Endpoint Caso de uso de rechazar peticion de amistad
- [ ] Endpoint Caso de uso de eliminar amigo
- [ ] Endpoint Caso de uso de obtener lista de amigos
- [ ] Endpoint Caso de uso de guardar mensaje

## Financial

- [x] Modelado de la base de datos
- [x] Modelado del repositorio
- [ ] Modelado del dominio
- [ ] Listener UserCreatedEvent Caso de uso de crear Wallet
- [ ] Listener UserDeletedEvent Caso de uso de eliminar Wallet
- [ ] Endpoint Caso de uso de hacer transaccion

## Auction

- [ ] Modelado de la base de datos
- [ ] Modelado del repositorio
- [ ] Modelado del dominio
- [ ] Endpoint Caso de uso de crear subasta
- [ ] Endpoint Caso de uso de editar subasta
- [ ] Endpoint Caso de uso de eliminar subasta
- [ ] Endpoint Caso de uso de pujar en subasta
- [ ] Endpoint Caso de uso de finalizar subasta

## Dudas

Necesito crear una lista de transacciones, como es mejor hacerlo en el dominio: Collection, crear una entidad que internamente sea una collection...
