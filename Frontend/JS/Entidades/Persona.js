"use strict";
var Facultad;
(function (Facultad) {
    var Persona = /** @class */ (function () {
        function Persona(id, nombre, apellido) {
            this.id = id;
            this.nombre = nombre;
            this.apellido = apellido;
        }
        Persona.prototype.getID = function () {
            return this.id;
        };
        Persona.prototype.setID = function (id) {
            this.id = id;
        };
        Persona.prototype.getNombre = function () {
            return this.nombre;
        };
        Persona.prototype.setNombre = function (nombre) {
            this.nombre = nombre;
        };
        Persona.prototype.getApellido = function () {
            return this.apellido;
        };
        Persona.prototype.setApellido = function (apellido) {
            this.apellido = apellido;
        };
        return Persona;
    }());
    Facultad.Persona = Persona;
})(Facultad || (Facultad = {}));
