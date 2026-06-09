# prueba-tecnica-susuerte

# Prueba Técnica – Desarrollador de Software

## Página web transaccional · susuerte.com

**Tiempo estimado:** 4 horas

---

# Contexto del problema

Susuerte es un operador de juegos de suerte y azar. En su plataforma web transaccional, cada vez que un cliente realiza una apuesta se genera un tiquete: el comprobante digital de esa jugada. El tiquete registra quién apostó, cuánto dinero apostó, en qué momento y, posteriormente, cuál fue su resultado.

Para esta prueba trabajarás con una versión simplificada de ese sistema, basada en dos entidades:

### Usuario

El cliente que juega. Tiene un saldo (dinero disponible en su cuenta) con el que paga sus apuestas.

### Tiquete

El registro de una apuesta. Tiene un monto (el valor apostado) y un estado que indica en qué punto del ciclo se encuentra.

El estado de un tiquete puede ser:

* `pendiente`: la apuesta fue registrada pero aún no se conoce el resultado (el sorteo no ha ocurrido).
* `ganador`: la jugada resultó premiada.
* `perdedor`: la jugada no resultó premiada.

## Flujo básico que modelarás

Cuando un usuario crea un tiquete, el sistema verifica que tenga saldo suficiente, descuenta el monto apostado de su saldo y registra el tiquete asociado a ese usuario.

Como en este descuento intervienen dos operaciones que deben ocurrir juntas (restar saldo y crear el tiquete), es importante que se ejecuten de forma consistente: si una falla, ninguna debe quedar aplicada.

---

# Instrucciones de entrega

* Entrega un repositorio Git (GitHub o GitLab) con el historial de commits.
* Incluye un archivo README con instrucciones de instalación, ejecución y pruebas.
* Puedes usar Laravel (opcional). El uso de un framework no es obligatorio; valora lo que mejor te permita demostrar tus habilidades.
* Se valora código limpio, validación de entradas, consultas preparadas (evitar SQL injection) y manejo de errores.

---

# Parte 1 – PHP y Recursividad (20 pts)

## 1.1

Implementa una función recursiva:

```php
calcularPremioAcumulado(array $niveles): float
```

que recorra un árbol de premios anidados (cada nodo tiene `monto` e `hijos[]`) y retorne la suma total.

**No uses bucles para recorrer la jerarquía.**

### Entrada

```php
$niveles = [
    [
        'monto' => 1000,
        'hijos' => [
            [
                'monto' => 500,
                'hijos' => []
            ],
            [
                'monto' => 250,
                'hijos' => [
                    [
                        'monto' => 100,
                        'hijos' => []
                    ]
                ]
            ]
        ]
    ]
];
```

### Resultado esperado

```text
1850
```

## 1.2

En el README explica:

* El caso base de tu recursión.
* Qué ocurriría con una estructura muy profunda (límite de stack).

---

# Parte 2 – Bases de Datos Relacionales (20 pts)

## Esquema base

```sql
usuarios(
    id,
    nombre,
    saldo,
    creado_en
)

tiquetes(
    id,
    usuario_id,
    monto,
    estado,
    creado_en
)

-- estado: 'ganador' | 'perdedor' | 'pendiente'
```

## 2.1

Escribe el SQL para crear ambas tablas con:

* Claves foráneas.
* Índices apropiados.

## 2.2

Consulta que retorne los **3 usuarios con mayor monto total apostado en tiquetes ganadores**.

Debe mostrar:

* nombre
* total

## 2.3

Consulta que liste los usuarios sin ningún tiquete registrado.

## 2.4

Explica por qué usarías una transacción al registrar un tiquete que descuenta saldo del usuario.

---

# Parte 3 – API y Estados HTTP (25 pts)

Crea un endpoint REST en PHP:

```http
POST /api/tiquetes
```

que reciba un JSON con el formato:

```json
{
  "usuario_id": int,
  "monto": float
}
```

## 3.1

El endpoint debe responder con los siguientes códigos:

| Situación                        | Código HTTP |
| -------------------------------- | ----------- |
| Tiquete creado correctamente     | 201         |
| JSON inválido o campos faltantes | 400         |
| Usuario no existe                | 404         |
| Saldo insuficiente               | 422         |
| Error inesperado del servidor    | 500         |

## 3.2

Al crear el tiquete debe descontar el monto del saldo del usuario dentro de una transacción.

## 3.3

Crea un endpoint:

```http
GET /api/usuarios/{id}/tiquetes
```

que devuelva la lista en formato JSON con el código de estado adecuado (incluye el caso de usuario inexistente).

---

# Parte 4 – JavaScript (15 pts)

Crea una página:

```text
index.html
```

que:

## 4.1

Tenga un formulario para enviar un tiquete (`usuario_id + monto`) usando `fetch` hacia el endpoint de la Parte 3.

## 4.2

Muestre mensajes diferenciados al usuario según el código HTTP recibido:

* éxito
* saldo insuficiente
* usuario no encontrado
* error

## 4.3

Sin recargar la página, agregue el nuevo tiquete a una lista visible en el DOM.

---

# Parte 5 – Control de Versiones (10 pts)

## 5.1

El repositorio debe mostrar commits incrementales y descriptivos (no un único commit final).

## 5.2

Trabaja la Parte 3 en una rama:

```text
feature/api-tiquetes
```

y deja evidencia de su merge a `main`.

## 5.3

Incluye un `.gitignore` adecuado (dependencias, credenciales, etc.).

---

# Parte 6 – Reto de Creatividad (10 pts)

Esta sección es deliberadamente abierta.

Propón e implementa (o documenta como propuesta razonada) una mejora libre al módulo.

## Algunas ideas (no limitantes)

* Idempotencia ante envíos duplicados o reintentos de red.
* Sistema de notificaciones.
* Dashboard de métricas.
* Validación antifraude.
* Gamificación.
* Paginación.
* Filtros en el listado.

Se evalúa:

* Originalidad.
* Justificación del valor para el negocio.
* Viabilidad.

No se evalúa la complejidad.

Explica por qué elegiste esa mejora.

---

# Parte 7 – Documentación (10 pts)

## 7.1

README claro:

* Cómo instalar.
* Cómo ejecutar.
* Cómo probar el proyecto.
* Decisiones técnicas.
* Supuestos.

## 7.2

Incluye una sección breve:

```text
Si tuviera más tiempo...
```

describiendo:

* Qué mejorarías.
* Qué dejaste pendiente.
* Por qué.

---

# Criterios de evaluación

| Competencia                            | Dónde se evalúa  |
| -------------------------------------- | ---------------- |
| Dominio del lenguaje PHP               | Partes 1 y 3     |
| Recursividad y resolución de problemas | Partes 1 y 6     |
| Manejo de bases de datos relacionales  | Parte 2 y 3.2    |
| Gestión de APIs                        | Parte 3          |
| Gestión de estados de respuesta HTTP   | Partes 3.1 y 4.2 |
| Control de versiones                   | Parte 5          |
| Manejo de JavaScript                   | Parte 4          |
| Creatividad                            | Parte 6          |
| Comunicación escrita                   | Parte 7 (README) |

### Escala sugerida

* 0 = sin evidencia
* 1 = básico
* 2 = competente
* 3 = sobresaliente

---

**¡Mucho éxito! Si algo no es claro, documenta tus supuestos y continúa.**
