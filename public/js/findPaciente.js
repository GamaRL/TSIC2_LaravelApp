/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/findPaciente.js":
/*!**************************************!*\
  !*** ./resources/js/findPaciente.js ***!
  \**************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _createForOfIteratorHelper(o, allowArrayLike) { var it; if (typeof Symbol === "undefined" || o[Symbol.iterator] == null) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = o[Symbol.iterator](); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it["return"] != null) it["return"](); } finally { if (didErr) throw err; } } }; }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

var mensajes;

function createDataTable() {
  return $('#information').DataTable({
    responsive: true,
    columns: [{
      sClass: "text-center align-middle",
      data: 'id',
      render: function render(data) {
        return "<td><b>".concat(data, "</b></td>");
      }
    }, {
      sClass: "text-center align-middle",
      data: 'nombre',
      render: function render(data) {
        return "<td>".concat(data, "</td>");
      }
    }, {
      sClass: "text-center align-middle",
      data: 'apPat',
      render: function render(data) {
        return "<td>".concat(data, "</td>");
      }
    }, {
      sClass: "text-center align-middle",
      data: 'apMat',
      render: function render(data) {
        return "<td>".concat(data, "</td>");
      }
    }, {
      orderable: false,
      data: 'id',
      sClass: "text-center align-middle",
      render: function render(data) {
        return "\n                        <td>\n                            <div class=\"btn-group\" role=\"group\">\n                                <a class=\"btn btn-secondary\" type=\"button\"\n                                   href=\"/pacientes/".concat(data, "/consulta\">Consulta</a>\n\n\n                                <div class=\"btn-group\" role=\"group\">\n                                    <button class=\"btn btn-primary dropdown-toggle\" type=\"button\"\n                                            id=\"options-").concat(data, "\"\n                                            data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">\n                                        M\xE1s\n                                    </button>\n                                    <div class=\"dropdown-menu\" aria-labelledby=\"options-").concat(data, "\">\n                                        <a class=\"dropdown-item\" href=\"/pacientes/").concat(data, "\">Ver\n                                            Paciente</a>\n                                        <a class=\"dropdown-item\" href=\"#\">Otras...</a>\n                                    </div>\n                                </div>\n                            </div>\n                        </td>\n                        ");
      }
    }],
    language: {
      sProcessing: "Procesando...",
      sLengthMenu: "Mostrar _MENU_ registros",
      sZeroRecords: "No se encontraron resultados",
      sEmptyTable: "Ningún dato disponible en esta tabla",
      sInfo: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
      sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
      sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
      sInfoPostFix: "",
      sSearch: "Buscar:",
      sUrl: "",
      sInfoThousands: ",",
      sLoadingRecords: "Cargando...",
      oPaginate: {
        sFirst: "Primero",
        sLast: "Último",
        sNext: "Siguiente",
        sPrevious: "Anterior"
      },
      oAria: {
        sSortAscending: ": Activar para ordenar la columna de manera ascendente",
        sSortDescending: ": Activar para ordenar la columna de manera descendente"
      },
      buttons: {
        copy: "Copiar",
        colvis: "Visibilidad"
      }
    },
    processing: true,
    serverSide: true,
    ajax: {
      url: '/pacientes/dataTable',
      type: 'post',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      error: function error() {
        console.log("Error");
      }
    }
  });
}

function handleErrors(errors) {
  for (var errorsKey in errors) {
    if (errors.hasOwnProperty(errorsKey)) {
      document.querySelector("#".concat(errorsKey, " + .invalid-feedback")).innerText = errors[errorsKey];
      document.querySelector("#".concat(errorsKey)).classList.toggle('is-invalid');
    }
  }
}

function handleSubmit(e) {
  e.preventDefault();
  var form = document.getElementById('mensajes-form');
  document.querySelector('#send-message + button').classList.toggle('d-none');
  document.querySelector('#send-message').classList.toggle('d-none');
  fetch(form.action, {
    method: 'post',
    headers: {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    },
    body: new FormData(form)
  }).then(function (response) {
    return response.json();
  }).then(function (data) {
    document.querySelector('#send-message + button').classList.toggle('d-none');
    document.querySelector('#send-message').classList.toggle('d-none');

    if (data.errors) {
      handleErrors(data.errors);
    } else {
      document.querySelector('#mensajes-form + div.alert').classList.toggle('d-none');
      form.reset();
      location.reload();
    }
  });
}

function handleSelectChange() {
  var sesion = document.getElementById('sesion').value;
  var categorias = document.getElementById('categoria');
  categorias.innerHTML = "";

  var _iterator = _createForOfIteratorHelper(mensajes[sesion]),
      _step;

  try {
    for (_iterator.s(); !(_step = _iterator.n()).done;) {
      var categoria = _step.value;
      var mensaje_option = document.createElement('option');
      mensaje_option.value = categoria;
      mensaje_option.innerText = categoria;
      categorias.append(mensaje_option);
    }
  } catch (err) {
    _iterator.e(err);
  } finally {
    _iterator.f();
  }
}

function fillFormMensajes() {
  for (var fecha in mensajes) {
    if (mensajes.hasOwnProperty(fecha)) {
      var fecha_option = document.createElement('option');
      var fecha_ = new Date(fecha);
      fecha_option.value = fecha;
      fecha_option.innerText = "".concat(fecha_.getUTCDate(), "/").concat(fecha_.getUTCMonth(), "/").concat(fecha_.getUTCFullYear());
      document.getElementById('sesion').append(fecha_option);
    }
  }

  handleSelectChange();
}

function getMensajesData() {
  fetch('/pacientes/mensajes_data_all').then(function (response) {
    return response.json();
  }).then(function (data) {
    mensajes = data;
    fillFormMensajes(data);
    document.getElementById('sesion').addEventListener('change', handleSelectChange);
    document.getElementById('mensajes-form').addEventListener('submit', handleSubmit);
  });
}

if (document.readyState === 'loading') $(document).ready(function () {
  createDataTable();
});else createDataTable();
getMensajesData();

/***/ }),

/***/ 1:
/*!********************************************!*\
  !*** multi ./resources/js/findPaciente.js ***!
  \********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/html/Trabajos/sistemacaptura/resources/js/findPaciente.js */"./resources/js/findPaciente.js");


/***/ })

/******/ });