"use strict";
var Facultad;
(function (Facultad) {
    var Funciones = /** @class */ (function () {
        function Funciones() {
        }
        Funciones.CargarFormulario = function (id) {
            for (var i = 0; i < this.listaClientes.length; i++) {
                var cliente = this.listaClientes[i];
                if (cliente.getID() === id) {
                    $("#id").val(cliente.getID());
                    $("#nombre").val(cliente.getNombre());
                    $("#apellido").val(cliente.getApellido());
                    $("#edad").val(cliente.getEdad());
                    $("#sexo").val(cliente.getSexo());
                    break;
                }
            }
        };
        Funciones.Borrar = function () {
            var id = Number($("#id").val());
            var flagBorro = false;
            for (var i = 0; i < this.listaClientes.length; i++) {
                var cliente = this.listaClientes[i];
                if (cliente.getID() === id) {
                    this.listaClientes.splice(i, 1);
                    flagBorro = true;
                    break;
                }
            }
            if (!flagBorro) {
                alert("No se encontró coincidencia con el ID.");
            }
            localStorage.setItem("clientes", this.listaClientesToJson());
            this.llenarGrilla(this.listaClientes);
            this.LimpiarFormulario();
            this.default();
        };
        //Busca el ID más alto de la lista.
        Funciones.BuscarIDMasAlto = function () {
            var IDMasAlto = this.listaClientes.reduce(function (IDMasAlto, cliente, i, array) {
                if (cliente.getID() > IDMasAlto) {
                    IDMasAlto = cliente.getID();
                }
                return IDMasAlto;
            }, 0);
            return IDMasAlto;
        };
        //Carga un nuevo cliente a la lista. 
        Funciones.Alta = function () {
            var nombre = String($("#nombre").val());
            var apellido = String($("#apellido").val());
            var edad = Number($("#edad").val());
            var sexo = String($("#sexo").val());
            var cliente = new Facultad.Cliente(this.BuscarIDMasAlto() + 1, nombre, apellido, edad, sexo);
            this.listaClientes.push(cliente);
            localStorage.setItem("clientes", this.listaClientesToJson());
            this.llenarGrilla(this.listaClientes);
            this.LimpiarFormulario();
            this.default();
        };
        //Pasa la lista de clientes a formato JSON (string)
        Funciones.listaClientesToJson = function () {
            if (this.listaClientes.length > 0) {
                var listaJson_1 = "[";
                this.listaClientes.forEach(function (cliente) {
                    listaJson_1 += cliente.toJSON();
                    listaJson_1 += ",";
                });
                listaJson_1 = listaJson_1.slice(0, -1);
                listaJson_1 += "]";
                return listaJson_1;
            }
            return "";
        };
        //Pasa el JSON almacenado en el LocalStorage y genera a lista de clientes.
        Funciones.LocalStorageTolistaClientes = function () {
            var LSString = String(localStorage.getItem("clientes"));
            if (LSString != null && LSString != "") {
                var listaJson = JSON.parse(LSString);
                {
                    if (listaJson != null) {
                        for (var i = 0; i < listaJson.length; i++) {
                            var id = listaJson[i].id;
                            var nombre = listaJson[i].nombre;
                            var apellido = listaJson[i].apellido;
                            var edad = listaJson[i].edad;
                            var sexo = listaJson[i].sexo;
                            var cliente = new Facultad.Cliente(id, nombre, apellido, edad, sexo);
                            this.listaClientes.push(cliente);
                        }
                    }
                }
            }
        };
        //Limpia el formulario
        Funciones.LimpiarFormulario = function () {
            $("#nombre").val("");
            $("#apellido").val("");
            $("#edad").val("");
            $("#sexo").val("Masculino");
            $("#nombreGroup").removeClass("has-error has-feedback");
            $("#helpNombre").hide();
            $("#apellidoGroup").removeClass("has-error has-feedback");
            $("#helpApellido").hide();
            $("#edadGroup").removeClass("has-error has-feedback");
            $("#helpEdad").hide();
            this.nombreValido = false;
            this.apellidoValido = false;
            this.edadValido = false;
        };
        //Se llama cuando cambia el estado de los checkbox y llama a llenar grilla.
        Funciones.Checkbox_OnChange = function () {
            this.llenarGrilla(this.listaClientes);
        };
        //Dibuja la grilla y la llena de los datos correspondientes. 
        Funciones.llenarGrilla = function (arrayClientes) {
            var mostrarID = Boolean($("#mostrarID").is(":checked"));
            var mostrarNombre = Boolean($("#mostrarNombre").is(":checked"));
            var mostrarApellido = Boolean($("#mostrarApellido").is(":checked"));
            var mostrarEdad = Boolean($("#mostrarEdad").is(":checked"));
            var mostrarSexo = Boolean($("#mostrarSexo").is(":checked"));
            var html = "<thead>" +
                "<tr>";
            if (mostrarID) {
                html += "<th>ID</th>";
            }
            if (mostrarNombre) {
                html += "<th>Nombre</th>";
            }
            if (mostrarApellido) {
                html += "<th>Apellido</th>";
            }
            if (mostrarEdad) {
                html += "<th>Edad</th>";
            }
            if (mostrarSexo) {
                html += "<th>Sexo</th>";
            }
            html += "</tr>" +
                "</thead>" +
                "<tbody>";
            arrayClientes.forEach(function (cliente) {
                html += "<tr class='trSeleccionable' onclick='Facultad.Funciones.CargarFormulario(" + cliente.getID() + ")'>";
                if (mostrarID) {
                    html += "<td>" + cliente.getID() + "</td>";
                }
                if (mostrarNombre) {
                    html += "<td>" + cliente.getNombre() + "</td>";
                }
                if (mostrarApellido) {
                    html += "<td>" + cliente.getApellido() + "</td>";
                }
                if (mostrarEdad) {
                    html += "<td>" + cliente.getEdad() + "</td>";
                }
                if (mostrarSexo) {
                    html += "<td>" + cliente.getSexo() + "</td>";
                }
                html += "</tr>";
            });
            html += "</tbody>";
            $("#tabla").html(html);
        };
        //Filtra por nombre la grilla.
        Funciones.FiltrarNombre = function () {
            var filtro = String($("#txtFiltroNombre").val());
            var arrayFiltrado = this.listaClientes.filter(function (Cliente, i, array) {
                if (Cliente.getNombre().match("^" + filtro + "[a-zA-Z\s]*")) {
                    return true;
                }
                return false;
            });
            this.llenarGrilla(arrayFiltrado);
        };
        Funciones.OnLoad = function () {
            this.default();
            this.LocalStorageTolistaClientes();
            this.llenarGrilla(this.listaClientes);
        };
        Funciones.default = function () {
            $("#helpNombre").hide();
            $("#helpApellido").hide();
            $("#helpEdad").hide();
        };
        //Valida que se haya ingresado un apellido correcto.
        Funciones.ValidarNombre = function () {
            var nombre = String($("#nombre").val());
            if (nombre === "" || !nombre.match("^[a-zA-Z]*$")) {
                $("#nombreGroup").addClass("has-error has-feedback");
                $("#helpNombre").show();
                this.nombreValido = false;
            }
            else {
                $("#nombreGroup").removeClass("has-error has-feedback");
                $("#helpNombre").hide();
                this.nombreValido = true;
            }
        };
        //Valida que se haya ingresado un apellido correcto.
        Funciones.ValidarApellido = function () {
            var apellido = String($("#apellido").val());
            if (apellido === "" || !apellido.match("^[a-zA-Z]*$")) {
                $("#apellidoGroup").addClass("has-error has-feedback");
                $("#helpApellido").show();
                this.apellidoValido = false;
            }
            else {
                $("#apellidoGroup").removeClass("has-error has-feedback");
                $("#helpApellido").hide();
                this.apellidoValido = true;
            }
        };
        //Valida que se haya ingresado una edad correcta.
        Funciones.ValidarEdad = function () {
            var edad = Number($("#edad").val());
            if (edad < 1 || edad > 99) {
                $("#edadGroup").addClass("has-error has-feedback");
                this.edadValido = false;
                $("#helpEdad").show();
            }
            else {
                $("#edadGroup").removeClass("has-error has-feedback");
                this.edadValido = true;
                $("#helpEdad").hide();
            }
        };
        //No deja dar de alta si no están todos los datos válidos
        Funciones.ValidarBotonAlta = function () {
            this.ValidarEdad();
            this.ValidarNombre();
            this.ValidarApellido();
            if (this.nombreValido && this.apellidoValido && this.edadValido) {
                this.Alta();
            }
        };
        //Calcula el promedio de edades y lo muestra.
        Funciones.GenerarEstadisticas = function () {
            var sumaNotas = this.listaClientes.reduce(function (total, cliente, i, array) {
                return total += cliente.getEdad();
            }, 0);
            var promedio = sumaNotas / this.listaClientes.length;
            $("#txtPromedio").val(String(promedio));
        };
        //Limpia el localstorage. ATENCION: Si se vuelve a cargar un cliente se volverá a llenar el LS con toda la lista.
        Funciones.LimpiarLocalStorage = function () {
            localStorage.setItem("clientes", "");
        };
        Funciones.listaClientes = new Array();
        Funciones.nombreValido = false;
        Funciones.apellidoValido = false;
        Funciones.edadValido = false;
        return Funciones;
    }());
    Facultad.Funciones = Funciones;
})(Facultad || (Facultad = {}));
