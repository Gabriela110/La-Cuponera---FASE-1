# La-Cuponera---FASE-1
Fase 1 - Lenguajes interpretados al servidor 

Modulo para Administrador: 
- login_admin.php → inicio de sesión del administrador.
- Si el login es correcto, redirige a admin.php.
- Dentro del panel admin.php, hay varias opciones:
       ->  ver_registro.php: permite aprobar o rechazar empresas que se han registrado.
       ->  registro_admin.php: formulario para registrar nuevos administradores dentro del sistema.
       ->  Opciones para cerrar sesión y reportes, seran diseñadas para la siguiente entrega.


Modulo para Usuarios (Clientes y Empresas): 
- index.php → página principal del sitio ( donde se mostraran las ofertas en la fase 2 del proyecto)
- Desde la pantalla de inicio, se puede:
    -> Iniciar sesión (login.php)
    -> Registrarse como empresa (registro_empresas.php)
    -> Registrarse como cliente (registro_clientes.php)
  
        NOTA: 
        ** En el registro de empresas, al completarse correctamente,
           se muestra un mensaje indicando que la cuenta está en espera de aprobación por el administrador

  
  - Desde login.php, el usuario puede:
     -> Volver al inicio (index.php)
     -> Iniciar sesion con su usuario y contraseña (sea empresa o cliente)
    
        NOTA:
        **Para la fase 2 se agregara que las empresas añadan sus ofertas y el usuario pueda comprar maximo 5 cupones de estos. 
