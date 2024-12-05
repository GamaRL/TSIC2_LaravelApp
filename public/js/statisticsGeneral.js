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
/******/ 	return __webpack_require__(__webpack_require__.s = 6);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/statisticsGeneral.js":
/*!*******************************************!*\
  !*** ./resources/js/statisticsGeneral.js ***!
  \*******************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function graphLine(context, data, options) {
  new Chart(context, {
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
      aspectRatio: 1.5,
      scales: {
        yAxes: [{
          ticks: {
            max: 100,
            min: 0,
            stepSize: 10
          }
        }]
      },
      title: {
        display: true,
        text: options.title
      }
    }
  });
}

function drawGraphics() {
  fetch('/admin/estadisticas/get/general').then(function (response) {
    return response.json();
  }).then(function (data) {
    var data_diab = data.map(function (sesion) {
      return {
        'diabeticos': Math.round(10000 * sesion.diabeticos / sesion.asistentes) / 100,
        'prediabeticos': Math.round(10000 * sesion.prediabeticos / sesion.asistentes) / 100,
        'normales': Math.round(10000 * sesion.normales / sesion.asistentes) / 100
      };
    });
    var data_alertas = data.map(function (sesion) {
      var alertas = sesion.alertas;
      console.log(alertas);
      return {
        glucosa: Math.round(10000 * alertas.glucosa / sesion.asistentes) / 100,
        tension: Math.round(10000 * alertas.tension / sesion.asistentes) / 100,
        icc: Math.round(10000 * alertas.icc / sesion.asistentes) / 100,
        imc: Math.round(10000 * alertas.imc / sesion.asistentes) / 100
      };
    });
    console.log(data_alertas);
    document.getElementById('graph-diabetes').classList.remove('d-none');
    document.getElementById('graph-alertas').classList.remove('d-none');
    document.getElementById('loading').classList.add('d-none');
    document.getElementById('loading').classList.remove('d-flex');
    graphLine(document.getElementById('diabeticos'), data_diab, {
      title: "Cantidad de diabéticos",
      vars: [{
        color: "rgb(61,5,193)",
        label: "Diabéticos(%)",
        index: "diabeticos"
      }]
    });
    graphLine(document.getElementById('prediabeticos').getContext("2d"), data_diab, {
      title: "Prediabeticos",
      vars: [{
        color: "rgb(143,194,2)",
        label: "Prediabeticos (%)",
        index: "prediabeticos"
      }]
    });
    graphLine(document.getElementById('normales').getContext("2d"), data_diab, {
      title: "Normales",
      vars: [{
        color: "rgb(5,171,193)",
        label: "Normales (%)",
        index: "normales"
      }]
    });
    graphLine(document.getElementById('glucosa').getContext('2d'), data_alertas, {
      title: "Alertas de Glucosa",
      vars: [{
        color: "#815294",
        label: "(%)",
        index: "glucosa"
      }]
    });
    graphLine(document.getElementById('tension').getContext('2d'), data_alertas, {
      title: "Alertas de Tensión Arterial",
      vars: [{
        color: "#df3f3d",
        label: "(%)",
        index: "tension"
      }]
    });
    graphLine(document.getElementById('icc').getContext('2d'), data_alertas, {
      title: "Alertas de ICC",
      vars: [{
        color: "#fa9240",
        label: "(%)",
        index: "icc"
      }]
    });
    graphLine(document.getElementById('imc').getContext('2d'), data_alertas, {
      title: "Alertas de IMC",
      vars: [{
        color: "#f9c84b",
        label: "(%)",
        index: "imc"
      }]
    });
  });
}

document.addEventListener('DOMContentLoaded', function () {
  drawGraphics();
});

/***/ }),

/***/ 6:
/*!*************************************************!*\
  !*** multi ./resources/js/statisticsGeneral.js ***!
  \*************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/html/Trabajos/sistemacaptura/resources/js/statisticsGeneral.js */"./resources/js/statisticsGeneral.js");


/***/ })

/******/ });