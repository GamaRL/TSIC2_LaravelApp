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
/******/ 	return __webpack_require__(__webpack_require__.s = 5);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/statistics.js":
/*!************************************!*\
  !*** ./resources/js/statistics.js ***!
  \************************************/
/*! no static exports found */
/***/ (function(module, exports) {

var chartGlucosa;
var chartTASist;
var chartTADiast;
var chartDiabetes;

function drawGlucosa(data) {
  chartGlucosa = new Chart(document.getElementById('glucosa').getContext('2d'), {
    type: 'bar',
    data: {
      labels: data.map(function (item) {
        return item.tag;
      }),
      datasets: [{
        label: "Frecuencia",
        borderColor: 'rgb(73,68,231)',
        backgroundColor: 'rgb(73,68,231)',
        fill: false,
        data: data.map(function (item) {
          return item.size;
        })
      }]
    },
    options: {
      responsiveAnimationDuration: 500,
      aspectRatio: 1.5,
      hoverMode: 'index',
      title: {
        display: true,
        text: "Histograma de de Glucosas (Sesi\xF3n ".concat(getSesion(), ")")
      },
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: true
          }
        }]
      }
    }
  });
}

function drawTensionArterialSist(data) {
  chartTASist = new Chart(document.getElementById('ta_sist').getContext('2d'), {
    type: 'bar',
    data: {
      labels: data.map(function (item) {
        return item.tag;
      }),
      datasets: [{
        label: "Frecuencia",
        borderColor: "rgb(168,19,222)",
        backgroundColor: "rgb(168,19,222)",
        fill: false,
        data: data.map(function (item) {
          return item.size;
        })
      }]
    },
    options: {
      responsiveAnimationDuration: 500,
      hoverMode: 'index',
      aspectRatio: 1.5,
      title: {
        display: true,
        text: "Tensi\xF3n Arterial Sist\xF3lica (Sesi\xF3n ".concat(getSesion(), ")")
      },
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: true
          }
        }]
      }
    }
  });
}

function drawTensionArterialDiast(data) {
  chartTADiast = new Chart(document.getElementById('ta_diast').getContext('2d'), {
    type: 'bar',
    data: {
      labels: data.map(function (item) {
        return item.tag;
      }),
      datasets: [{
        label: "Frecuencia",
        borderColor: "rgb(19,222,158)",
        backgroundColor: "rgb(19,222,158)",
        fill: false,
        data: data.map(function (item) {
          return item.size;
        })
      }]
    },
    options: {
      responsiveAnimationDuration: 500,
      hoverMode: 'index',
      aspectRatio: 1.5,
      title: {
        display: true,
        text: "Tensi\xF3n Arterial Diast\xF3lica (Sesi\xF3n ".concat(getSesion(), ")")
      },
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: true
          }
        }]
      }
    }
  });
}

function drawDiabetes(data) {
  console.log(data);
  chartDiabetes = new Chart(document.getElementById('diabetes').getContext('2d'), {
    type: 'pie',
    data: {
      datasets: [{
        data: [data.diabeticos, data.prediabeticos, data.normales],
        backgroundColor: ['red', 'orange', 'blue']
      }],
      labels: ['Diabeticos', 'Prediabeticos', 'Otros']
    },
    options: {
      responsiveAnimationDuration: 500,
      hoverMode: 'index',
      aspectRatio: 1.5,
      title: {
        display: true,
        text: "Tensi\xF3n Arterial Diast\xF3lica (Sesi\xF3n ".concat(getSesion(), ")")
      }
    }
  });
}

function getSesion() {
  return document.getElementById("sesion").value;
}

function getData() {
  fetch("/admin/estadisticas/get/".concat(getSesion())).then(function (response) {
    return response.json();
  }).then(function (data) {
    drawGlucosa(data.glucosa);
    drawTensionArterialSist(data.ta_sist);
    drawTensionArterialDiast(data.ta_diast);
    drawDiabetes(data.diabetes);
  });
}

document.addEventListener('DOMContentLoaded', function () {
  document.getElementById("search").addEventListener("click", function () {
    if (chartGlucosa && chartTASist && chartTADiast) {
      chartTADiast.destroy();
      chartTASist.destroy();
      chartGlucosa.destroy();
      chartDiabetes.destroy();
    }

    document.getElementById('graph-container').classList.remove('d-none');
    getData();
  });
});

/***/ }),

/***/ 5:
/*!******************************************!*\
  !*** multi ./resources/js/statistics.js ***!
  \******************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/html/Trabajos/sistemacaptura/resources/js/statistics.js */"./resources/js/statistics.js");


/***/ })

/******/ });