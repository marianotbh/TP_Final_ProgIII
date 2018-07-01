"use strict";
var __extends = (this && this.__extends) || (function () {
    var extendStatics = Object.setPrototypeOf ||
        ({ __proto__: [] } instanceof Array && function (d, b) { d.__proto__ = b; }) ||
        function (d, b) { for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p]; };
    return function (d, b) {
        extendStatics(d, b);
        function __() { this.constructor = d; }
        d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
    };
})();
var Facultad;
(function (Facultad) {
    var Cliente = /** @class */ (function (_super) {
        __extends(Cliente, _super);
        function Cliente(id, nombre, apellido, edad, sexo) {
            var _this = _super.call(this, id, nombre, apellido) || this;
            _this.edad = edad;
            _this.sexo = sexo;
            return _this;
        }
        Cliente.prototype.getEdad = function () {
            return this.edad;
        };
        Cliente.prototype.setEdad = function (edad) {
            this.edad = edad;
        };
        Cliente.prototype.getSexo = function () {
            return this.sexo;
        };
        Cliente.prototype.setSexo = function (sexo) {
            this.sexo = sexo;
        };
        Cliente.prototype.toJSON = function () {
            return '{"id":' + this.getID() + ',"nombre":"' + this.getNombre() + '","apellido":"' + this.getApellido() + '","edad":' + this.getEdad() + ',"sexo":"' + this.getSexo() + '"}';
        };
        return Cliente;
    }(Facultad.Persona));
    Facultad.Cliente = Cliente;
})(Facultad || (Facultad = {}));
