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
/******/ 	return __webpack_require__(__webpack_require__.s = 4);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/pacienteOnly.js":
/*!**************************************!*\
  !*** ./resources/js/pacienteOnly.js ***!
  \**************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _createForOfIteratorHelper(o, allowArrayLike) { var it; if (typeof Symbol === "undefined" || o[Symbol.iterator] == null) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = o[Symbol.iterator](); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it["return"] != null) it["return"](); } finally { if (didErr) throw err; } } }; }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

var alertas, mensajes;

function graphLine(context, data, options) {
  var chart = new Chart(context, {
    type: 'line',
    data: {
      labels: data.map(function (item, i) {
        return "Sesi\xF3n ".concat(i + 1);
      }),
      datasets: options.vars.map(function (item) {
        return {
          label: item.label,
          borderColor: item.color,
          backgroundColor: item.color,
          fill: false,
          data: data.map(function (consulta) {
            return consulta[item.index];
          })
        };
      })
    },
    options: {
      responsive: true,
      hoverMode: 'index',
      aspectRatio: 1,
      title: {
        display: true,
        text: options.title
      }
    }
  });
}

function graphIntervalLine(context, data, config) {
  var gradiente = context.createLinearGradient(0, 0, 0, 300);
  gradiente.addColorStop(0, "rgb(0,200,16)");
  gradiente.addColorStop(0.3, "rgba(0,200,16,0.9)");
  gradiente.addColorStop(1, "rgba(255,255,255,1)");
  var chartGlucosa = new Chart(context, {
    type: 'line',
    data: {
      labels: data.map(function (medida, i) {
        return "Sesi\xF3n ".concat(i + 1);
      }),
      datasets: [{
        label: config.nombre,
        borderColor: config.color,
        backgroundColor: config.color,
        fill: false,
        data: data.map(function (consulta) {
          return consulta.medida;
        })
      }, {
        label: "Max",
        borderWidth: 0.5,
        lineTension: 0,
        borderColor: "rgb(0, 200, 16)",
        backgroundColor: "rgba(0,200,16,0.3)",
        fill: false,
        data: data.map(function (medida) {
          return medida.intervalo[1];
        })
      }, {
        label: "Min",
        borderWidth: 0.5,
        lineTension: 0,
        borderColor: "rgb(0, 200, 16)",
        backgroundColor: "rgba(0,200,16,0.3)",
        fill: '-1',
        data: data.map(function (medida) {
          return medida.intervalo[0];
        })
      }]
    },
    options: {
      responsive: true,
      hoverMode: 'index',
      aspectRatio: 1,
      title: {
        display: true,
        text: config.nombre
      }
    }
  });
}

function drawAllGraphs(_ref) {
  var data = _ref.data;
  graphIntervalLine(document.getElementById('glucosa').getContext("2d"), data.map(function (consulta) {
    return {
      medida: consulta.cant_glucosa,
      intervalo: consulta.intervalo_glucosa
    };
  }), {
    color: "rgb(247, 153, 16)",
    nombre: "Glucosa"
  });
  graphIntervalLine(document.getElementById('ta_sist').getContext("2d"), data.map(function (consulta) {
    return {
      medida: consulta.ta_sist,
      intervalo: consulta.intervalo_ta_sist
    };
  }), {
    color: "rgb(18,119,227)",
    nombre: "Tensión Arterial Sistólica"
  });
  graphIntervalLine(document.getElementById('ta_diast').getContext("2d"), data.map(function (consulta) {
    return {
      medida: consulta.ta_diast,
      intervalo: consulta.intervalo_ta_diast
    };
  }), {
    color: "rgb(247,16,135)",
    nombre: "Tensión Arterial Diastólica"
  });
  graphIntervalLine(document.getElementById('imc').getContext("2d"), data.map(function (consulta) {
    return {
      medida: consulta.imc !== null ? Math.round(consulta.imc * 100) / 100 : undefined,
      intervalo: consulta.intervalo_imc
    };
  }), {
    color: "rgb(103,27,245)",
    nombre: "IMC"
  });
  graphIntervalLine(document.getElementById('icc').getContext("2d"), data.map(function (consulta) {
    return {
      medida: consulta.icc !== null ? Math.round(consulta.icc * 100) / 100 : undefined,
      intervalo: consulta.intervalo_icc
    };
  }), {
    color: "rgb(245,78,27)",
    nombre: "ICC"
  });
  graphLine(document.getElementById('medidas').getContext("2d"), data, {
    title: "Medidas",
    vars: [{
      color: 'rgb(25, 201, 64)',
      label: "Muslo(cm)",
      index: "muslo"
    }, {
      color: 'rgb(29, 200, 187)',
      label: "Cuello(cm)",
      index: "cuello"
    }, {
      color: 'rgb(0, 127, 195)',
      label: "Cintura(cm)",
      index: "cintura"
    }, {
      color: 'rgb(247, 210, 0)',
      label: "Cadera(cm)",
      index: "cadera"
    }]
  });
  graphLine(document.getElementById('pesos').getContext("2d"), data, {
    title: "Peso",
    vars: [{
      color: "rgb(75, 91, 106)",
      label: "Peso(Kg)",
      index: "peso"
    }]
  });
  graphLine(document.getElementById('oximetria').getContext("2d"), data, {
    title: "Oximetría",
    vars: [{
      color: "rgb(17,193,5)",
      label: "SpO2(%)",
      index: "oximetria"
    }]
  });

  function byteCount(s) {
    return encodeURI(s).split(/%..|./).length - 1;
  }

  setTimeout(function () {
    document.querySelector('input[name="peso"]').value = document.getElementById('pesos').toDataURL();
    document.querySelector('input[name="medidas"]').value = document.getElementById('medidas').toDataURL();
    document.querySelector('input[name="glucosa"]').value = document.getElementById('glucosa').toDataURL();
    document.querySelector('input[name="ta_diast"]').value = document.getElementById('ta_diast').toDataURL();
    document.querySelector('input[name="ta_sist"]').value = document.getElementById('ta_sist').toDataURL();
    document.querySelector('input[name="imc"]').value = document.getElementById('imc').toDataURL();
    document.querySelector('input[name="icc"]').value = document.getElementById('icc').toDataURL();
    document.querySelector('input[name="oximetria"]').value = document.getElementById('oximetria').toDataURL();
    document.getElementById('generar_reporte').classList.toggle('disabled');
  }, 1000);
}

function getURL_Stat() {
  return '/pacientes/' + document.getElementById('paciente_id').value + '/getStatistics';
}

function getURL_Mensajes() {
  return '/pacientes/' + document.getElementById('paciente_id').value + '/mensajes_data';
}

function handleOnChangeSesion() {
  var sesion = document.getElementById('sesion').value;
  var mensajes_disponibles = alertas[sesion].filter(function (alerta) {
    return !mensajes[sesion].hasOwnProperty(alerta);
  });
  document.getElementById('categoria').innerHTML = "";

  if (alertas[sesion].length === 0) {
    var opt_cat = document.createElement('option');
    opt_cat.innerText = 'sano';
    opt_cat.value = 'sanos';
    document.getElementById('categoria').appendChild(opt_cat);
  }

  var _iterator = _createForOfIteratorHelper(mensajes_disponibles),
      _step;

  try {
    for (_iterator.s(); !(_step = _iterator.n()).done;) {
      var disponible = _step.value;

      var _opt_cat = document.createElement('option');

      _opt_cat.innerText = "".concat(disponible);
      _opt_cat.value = disponible;
      document.getElementById('categoria').appendChild(_opt_cat);
    }
  } catch (err) {
    _iterator.e(err);
  } finally {
    _iterator.f();
  }
}

function fillSesiones() {
  console.log(mensajes);

  for (var sesion in alertas) {
    if (alertas.hasOwnProperty(sesion)) {
      var mensajes_length = Array.isArray(mensajes[sesion]) ? mensajes[sesion].length : Object.keys(mensajes[sesion]).length;
      var alertas_length = Array.isArray(alertas[sesion]) ? alertas[sesion].length : Object.keys(alertas[sesion]).length;
      console.log(alertas_length, mensajes_length);

      if (mensajes_length < alertas_length || alertas_length === 0) {
        var opt_sesion = document.createElement('option');
        opt_sesion.innerText = "Sesi\xF3n ".concat(sesion);
        opt_sesion.value = sesion.toString();
        if (mensajes_length < alertas_length || alertas_length === 0 && mensajes_length === 0) document.getElementById('sesion').appendChild(opt_sesion);
      }
    }
  }

  try {
    handleOnChangeSesion();
  } catch (e) {
    console.log("No hay mensajes disponibles");
    document.getElementById('mensaje-modal-button').disabled = true;
    document.getElementById('mensaje-modal-button').classList.add('disabled');
  }
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

document.addEventListener('DOMContentLoaded', function () {
  fetch(getURL_Stat()).then(function (response) {
    return response.json();
  }).then(drawAllGraphs);
  fetch(getURL_Mensajes()).then(function (response) {
    return response.json();
  }).then(function (data) {
    mensajes = data.mensajes;
    alertas = data.alertas;
    console.log(alertas);
    fillSesiones();
    document.getElementById('sesion').addEventListener('change', handleOnChangeSesion);
    document.getElementById('mensajes-form').addEventListener('submit', handleSubmit);
  });
});

/***/ }),

/***/ 4:
/*!********************************************!*\
  !*** multi ./resources/js/pacienteOnly.js ***!
  \********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/html/Trabajos/sistemacaptura/resources/js/pacienteOnly.js */"./resources/js/pacienteOnly.js");


/***/ })

/******/ });