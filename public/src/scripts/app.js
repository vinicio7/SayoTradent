;(function() {
	"use strict";

	angular.module("app", [
		/* Angular modules */
		"ngRoute",
		"ngAnimate",
		"ngSanitize",
		"ngAria",
		"ngMaterial",

		/* 3rd party modules */
		"oc.lazyLoad",
		"ui.bootstrap",
		"angular-loading-bar",
		"FBAngular",
	
		/* custom modules */
		"app.ctrls",
		"app.directives",
		"app.ui.ctrls",
		"app.ui.directives",
		"app.form.ctrls",
		"app.table.ctrls",
		"app.email.ctrls",
		"app.todo"
		
	])


	// disable spinner in loading-bar
	.config(['cfpLoadingBarProvider', function(cfpLoadingBarProvider) {
	    cfpLoadingBarProvider.includeSpinner = false;
	     cfpLoadingBarProvider.latencyThreshold = 500;
	}])

	// lazy loading scripts refernces of angular modules only
	.config(["$ocLazyLoadProvider", function($oc) {
		$oc.config({
			debug: true,
			event: false,
			modules: [{
				name: "angularBootstrapNavTree",
				files: ["scripts/lazyload/abn_tree_directive.js", "styles/lazyload/abn_tree.css"]
			},
			{
				name: "ui.calendar",
				serie: true,	// load files in series
				files: [
					"scripts/lazyload/moment.min.js", 
					"scripts/lazyload/fullcalendar.min.js",  
					"styles/lazyload/fullcalendar.css",  
					"scripts/lazyload/calendar.js"
				]
			},
			{
				name: "ui.select",
				files: ["scripts/lazyload/select.min.js", "styles/lazyload/select.css"]
			},
			{
				name: "ngTagsInput",
				files: ["scripts/lazyload/ng-tags-input.min.js", "styles/lazyload/ng-tags-input.css"]
			},
			{
				name: "colorpicker.module",
				files: ["scripts/lazyload/bootstrap-colorpicker-module.min.js", "styles/lazyload/colorpicker.css"]
			},
			{
				name: "ui.slider",
				serie: true,
				files: ["scripts/lazyload/bootstrap-slider.min.js", "scripts/lazyload/directives/bootstrap-slider.directive.js", "styles/lazyload/bootstrap-slider.css"]
			},
			{
				name: "textAngular",
				serie: true,
				files: ["scripts/lazyload/textAngular-rangy.min.js",  "scripts/lazyload/textAngular.min.js", "scripts/lazyload/textAngularSetup.js", "styles/lazyload/textAngular.css"]
			},
			{
				name: "flow",
				files: ["scripts/lazyload/ng-flow-standalone.min.js"]
			},
			{
				name: "ngImgCrop",
				files: ["scripts/lazyload/ng-img-crop.js", "styles/lazyload/ng-img-crop.css"]
			},
			{
				name: "ngMask",
				files: ["scripts/lazyload/ngMask.min.js"]
			},
			{
				name: "angular-c3",
				files: ["scripts/lazyload/directives/c3.directive.js"]
			},
			{
				name: "easypiechart",
				files: ["scripts/lazyload/angular.easypiechart.min.js"]
			},
			{
				name: "ngMap",
				files: ["scripts/lazyload/ng-map.min.js"]
			},
			{
                    name: "app.service.usuarios",
                    files: ["scripts/lazyload/services/usuarios.js"]
			},
			{
				name: "app.service.planilla",
				files: ["scripts/lazyload/services/planilla.js"]
			},
			{
				name: "app.service.proveedores",
				files: ["scripts/lazyload/services/proveedores.js"]
			},
			{
				name: "app.service.clientes",
				files: ["scripts/lazyload/services/clientes.js"]
			},
			{
				name: "app.service.compras",
				files: ["scripts/lazyload/services/compras.js"]
			},
			{
				name: "app.service.movimientos",
				files: ["scripts/lazyload/services/movimientos.js"]
			},
			{
				name: "app.service.ordenes",
				files: ["scripts/lazyload/services/ordenes.js"]
			},
			{
				name: "app.service.tenido",
				files: ["scripts/lazyload/services/tenido.js"]
			},
			{
				name: "app.service.secado",
				files: ["scripts/lazyload/services/secado.js"]
			},
			{
				name: "app.service.enconado",
				files: ["scripts/lazyload/services/enconado.js"]
			},
			{
				name: "app.service.devanado",
				files: ["scripts/lazyload/services/devanado.js"]
			},
			{
				name: "app.service.maseo",
				files: ["scripts/lazyload/services/maseo.js"]
			},
			{
				name: "app.service.colorante",
				files: ["scripts/lazyload/services/colorante.js"]
			},
			{
				name: "app.service.hilo",
				files: ["scripts/lazyload/services/hilo.js"]
			},

			{
				name: "app.service.calibres",
				files: ["scripts/lazyload/services/calibres.js"]
			},
			{
				name: "app.service.metraje",
				files: ["scripts/lazyload/services/metraje.js"]
			},
			{
				name: "app.service.estilo",
				files: ["scripts/lazyload/services/estilo.js"]
			},
			{
				name: "app.service.color",
				files: ["scripts/lazyload/services/color.js"]
			},

	        {
	        	name: "app.service.cuentas",
				files: ["scripts/lazyload/services/cuentas.js"]
	      	},
	      	{
	        	name: "app.service.reportes",
				files: ["scripts/lazyload/services/reportes.js"]
			  },
			  {
	        	name: "app.service.control",
				files: ["scripts/lazyload/services/control.js"]
	      	},
	      	{
	        	name: "app.service.facturar",
				files: ["scripts/lazyload/services/facturar.js"]
	      	},
			]
		})
	}])
	

	// jquery/javascript and css for plugins via lazy load
	.constant("JQ_LOAD", {
		fullcalendar: [],
		moment: ["scripts/lazyload/moment.min.js"],
		sparkline: ["scripts/lazyload/jquery.sparkline.min.js"],
		c3: ["scripts/lazyload/d3.min.js", "scripts/lazyload/c3.min.js", "styles/lazyload/c3.css"],
		gmaps: ["https://maps.google.com/maps/api/js"]
	})

	// route provider
	.config(["$routeProvider", "$locationProvider", "JQ_LOAD", function($routeProvider, $locationProvider, jqload) {

		

		var routes = [
			"ui/buttons", "ui/typography", "ui/grids", "ui/panels", "ui/tabs", "ui/modals", "ui/progress-bars", "ui/extras",
			"icons/font-awesome", "icons/ionicons", 
			"forms/wizard", 
			"tables/tables",
			"pages/signin", "pages/signup", "pages/404", "pages/forget-pass", "pages/lock-screen", "pages/invoice", "pages/search", "pages/timeline"
		];

		function setRoutes(route) {
			var url = '/' + route,
				config = {
					templateUrl: "views/" + route + ".html"
				};

			$routeProvider.when(url, config);
			return $routeProvider;
		}

		routes.forEach(function(route) {
			setRoutes(route);
		});

		$routeProvider
			.when("/", {redirectTo: "/registro"})
			.when("/404", {templateUrl: "views/pages/404.html"})
			.otherwise({redirectTo: "/404"});



		$routeProvider.when("/dashboard", {
			templateUrl: "views/dashboard.html",
			resolve: {
				deps: ["$ocLazyLoad", function(a) {
					return a.load([jqload.c3, jqload.sparkline])
					.then(function() {
						return a.load({
							name: "app.directives",
							files: ["scripts/lazyload/directives/sparkline.directive.js"]
						})
					})
					.then(function() {
						return a.load("angular-c3");
					})
					.then(function() {
						return a.load("easypiechart");
					})

				}]
			}
		});

		// text angular loaded in email/inbox
		$routeProvider.when("/email/inbox", {
			templateUrl: "views/email/inbox.html",
			resolve: {
				deps: ["$ocLazyLoad", function(a) {
					return a.load("textAngular");
				}]
			}
		});


		// calendar plugin
		// "scripts/lazyload/apps/calendarDemo.js"
		$routeProvider.when("/calendar", {
			templateUrl: "views/calendar.html",
			controller: "CalendarDemoCtrl",
			resolve: {
				deps: ["$ocLazyLoad", function(a) {
					return a.load("ui.calendar")
					.then(function() {
						return a.load({
							name: "app.ctrls",
							files: ["scripts/lazyload/controllers/calendarCtrl.js"]
						})
					});
				}]
			}
		});


		// Material Controller (For demo)
		$routeProvider.when("/material", {
			templateUrl: "views/material.html",
			resolve: {
				deps: ["$ocLazyLoad", function(a) {
					return a.load({
						name: "app.ctrls",
						files: ["scripts/lazyload/controllers/materialCtrl.js"]
					})
				}]
			}
		});

		// tree view plugin
		$routeProvider.when("/ui/treeview", {
			templateUrl: "views/ui/treeview.html",
			resolve: {
				deps: ["$ocLazyLoad", function(a) {
					return a.load("angularBootstrapNavTree")
					.then(function() {
						return a.load({
							name: "app.ctrls",
							files: ["scripts/lazyload/controllers/treeviewCtrl.js"]
						})
					})
				}]
			}
		});

		// load ui-select when notification page load.
		$routeProvider.when("/ui/notifications", {
			templateUrl: "views/ui/notifications.html",
			resolve: {
				deps: ["$ocLazyLoad", function(a) {
					return a.load("ui.select");
				}]
			}
		});

		// load ui-select in form-elements
		$routeProvider.when("/forms/elements", {
			templateUrl: "views/forms/elements.html",
			resolve: {
				deps: ["$ocLazyLoad", function(a) {
					return a.load(["ui.select", "ngTagsInput", "colorpicker.module", "ui.slider"])
					.then(function() {
						return a.load({
							name: "app.ctrls",
							files: ["scripts/lazyload/controllers/selectCtrl.js", "scripts/lazyload/controllers/tagsInputCtrl.js"]
						})
					})
					.then(function() {
						return a.load("textAngular");
					})

				}]
			}
		});


		// file uploader in form-elements
		$routeProvider.when("/forms/uploader", {
			templateUrl: "views/forms/uploader.html",
			resolve: {
				deps: ["$ocLazyLoad", function(a) {
					return a.load("flow");
				}]
			}
		});

		// Image Crop in form-elements
		$routeProvider.when("/forms/imagecrop", {
			templateUrl: "views/forms/imagecrop.html",
			resolve: {
				deps: ["$ocLazyLoad", function(a) {
					return a.load("ngImgCrop")
					.then(function() {
						return a.load({
							name: "app.ctrls",
							files: ["scripts/lazyload/controllers/imageCropCtrl.js"]
						})
					})
				}]
			}
		});

		// Form validation
		$routeProvider.when("/forms/validation", {
			templateUrl: "views/forms/validation.html",
			resolve: {
				deps: ["$ocLazyLoad", function(a) {
					return a.load("ngMask");
				}]
			}
		});

		/// charts - sparklines
		$routeProvider.when("/charts/sparklines", {
			templateUrl: "views/charts/sparklines.html",
			resolve: {
				deps: ["$ocLazyLoad", function(a) {
					return a.load(jqload.sparkline)
					.then(function() {
						return a.load({
							name: "app.directives",
							files: ["scripts/lazyload/directives/sparkline.directive.js"]
						})
					})
				}]
			}
		});

		/// charts - c3
		$routeProvider.when("/charts/c3", {
			templateUrl: "views/charts/c3.html", 
			resolve: {
				deps: ["$ocLazyLoad", "$rootScope", "$timeout", function(a, $rootScope, $timeout) {
					return a.load(jqload.c3)
					.then(function() {
						return a.load("angular-c3");
					})
					.then(function() {
						return a.load({
							name: "app.ctrls",
							files: ["scripts/lazyload/controllers/c3ChartCtrl.js"]
						})
					})
					.then(function() {
						return a.load("easypiechart");
					})
					.then(function() {
						$timeout(function() {
							$rootScope.$broadcast("c3.resize");
						}, 100);
					})

				}]
			}
		});


		/// Google Map
		$routeProvider.when("/maps/google-map", {
			templateUrl: "views/maps/google-map.html",
			resolve: {
				deps: ["$ocLazyLoad", function(a) {
					return a.load("ngMap");
				
				}]
			}
		});


		// registro
		$routeProvider.when("/registro", {
			templateUrl: "views/registro/registro.html",
			controller: "OrdenesController",
			resolve: {
				 deps: ["$ocLazyLoad", function(a) {
                    return a.load({
                        name: 'app.ordenes',
                        files: ['scripts/lazyload/controllers/ordenes.js']
                    })
                }]
			}
		});

		$routeProvider.when("/facturar", {
			templateUrl: "views/registro/facturar.html",
			controller: "FacturarController",
			resolve: {
				 deps: ["$ocLazyLoad", function(a) {
                    return a.load({
                        name: 'app.facturar',
                        files: ['scripts/lazyload/controllers/facturar.js']
                    })
                }]
			}
		});
		// fin

		// Planilla
		$routeProvider.when("/teñido", {
			templateUrl: "views/bodega/teñido.html",
			controller: "TenidoController",
			resolve: {
				 deps: ["$ocLazyLoad", function(a) {
                    return a.load({
                        name: 'app.tenido',
                        files: ['scripts/lazyload/controllers/tenido.js']
                    })
                }]
			}
		});

		$routeProvider.when("/secado", {
			templateUrl: "views/bodega/secado.html",
			controller: "SecadoController",
			resolve: {
				 deps: ["$ocLazyLoad", function(a) {
                    return a.load({
                        name: 'app.secado',
                        files: ['scripts/lazyload/controllers/secado.js']
                    })
                }]
			}
		});

		$routeProvider.when("/enconado", {
			templateUrl: "views/bodega/enconado.html",
			controller: "EnconadoController",
			resolve: {
				 deps: ["$ocLazyLoad", function(a) {
                    return a.load({
                        name: 'app.enconado',
                        files: ['scripts/lazyload/controllers/enconado.js']
                    })
                }]
			}
		});

		$routeProvider.when("/devanado", {
			templateUrl: "views/bodega/devanado.html",
			controller: "DevanadoController",
			resolve: {
				 deps: ["$ocLazyLoad", function(a) {
                    return a.load({
                        name: 'app.devanado',
                        files: ['scripts/lazyload/controllers/devanado.js']
                    })
                }]
			}
		});

		$routeProvider.when("/maseo", {
			templateUrl: "views/bodega/maseo.html",
			controller: "MaseoController",
			resolve: {
				 deps: ["$ocLazyLoad", function(a) {
                    return a.load({
                        name: 'app.maseo',
                        files: ['scripts/lazyload/controllers/maseo.js']
                    })
                }]
			}
		});

		$routeProvider.when("/colorante", {
			templateUrl: "views/inventario/inventarioColorante.html",
			controller: "ColoranteController",
			resolve: {
				 deps: ["$ocLazyLoad", function(a) {
                    return a.load({
                        name: 'app.colorante',
                        files: ['scripts/lazyload/controllers/colorante.js']
                    })
                }]
			}
		});

		$routeProvider.when("/hilo", {
			templateUrl: "views/inventario/inventarioHilos.html",
			controller: "HiloController",
			resolve: {
				 deps: ["$ocLazyLoad", function(a) {
                    return a.load({
                        name: 'app.hilo',
                        files: ['scripts/lazyload/controllers/hilo.js']
                    })
                }]
			}
		});

		$routeProvider.when("/administracion/planilla", {
			templateUrl: "views/administracion/planilla.html",
			controller: "PlanillaController",
			resolve: {
				 deps: ["$ocLazyLoad", function(a) {
                    return a.load({
                        name: 'app.planilla',
                        files: ['scripts/lazyload/controllers/planilla.js']
                    })
                }]
			}
		});
		// fin

		// #/administracion/proveedores

		$routeProvider.when("/administracion/proveedores", {
			templateUrl: "views/administracion/proveedores.html",
			controller: "ProveedoresController",
			resolve: {
				 deps: ["$ocLazyLoad", function(a) {
                    return a.load({
                        name: 'app.proveedores',
                        files: ['scripts/lazyload/controllers/proveedores.js']
                    })
                }]
			}
		});

		$routeProvider.when("/administracion/movimientos", {
			templateUrl: "views/administracion/movimientos.html",
			controller: "MovimientosController",
			resolve: {
				 deps: ["$ocLazyLoad", function(a) {
                    return a.load({
                        name: 'app.proveedores',
                        files: ['scripts/lazyload/controllers/movimientos.js']
                    })
                }]
			}
		});

		// fin #/administracion/proveedores

		// #/administracion/clientes

		$routeProvider.when("/administracion/clientes", {
			templateUrl: "views/administracion/clientes.html",
			controller: "ClientesController",
			resolve: {
				 deps: ["$ocLazyLoad", function(a) {
                    return a.load({
                        name: 'app.clientes',
                        files: ['scripts/lazyload/controllers/clientes.js']
                    })
                }]
			}
		});

		$routeProvider.when("/administracion/cuentas", {
			templateUrl: "views/administracion/cuentas.html",
			controller: "CuentasController",
			resolve: {
				 deps: ["$ocLazyLoad", function(a) {
                    return a.load({
                        name: 'app.cuentas',
                        files: ['scripts/lazyload/controllers/cuentas.js']
                    })
                }]
			}
		});
		// fin #/administracion/clientes

		//#/administracion/movimientos

		$routeProvider.when("/administracion/movimientos", {
			templateUrl: "views/administracion/movimientos.html",
			controller: "MovimientosController",
			resolve: {
				 deps: ["$ocLazyLoad", function(a) {
                    return a.load({
                        name: 'app.movimientos',
                        files: ['scripts/lazyload/controllers/movimientos.js']
                    })
                }]
			}
		});

		// fin#/administracion/movimientos

		// bodegas
		$routeProvider.when("/bodega", {
			templateUrl: "views/bodega/bodega.html",
			controller: "BodegaController",
			resolve: {
				 deps: ["$ocLazyLoad", function(a) {
                    return a.load({
                        name: 'app.bodega',
                        files: ['scripts/lazyload/controllers/bodega.js']
                    })
                }]
			}
		});
		// fin

		// compras
		$routeProvider.when("/compras", {
			templateUrl: "views/compras/compras.html",
			controller: "ComprasController",
			resolve: {
				 deps: ["$ocLazyLoad", function(a) {
                    return a.load({
                        name: 'app.compras',
                        files: ['scripts/lazyload/controllers/compras.js']
                    })
                }]
			}
		});
		// fin

		// ventas
		$routeProvider.when("/ventas", {
			templateUrl: "views/ventas/ventas.html",
			// controller: "ContactosController",
			resolve: {
				 deps: ["$ocLazyLoad", function(a) {
                    return a.load({
                        // name: 'app.registro',
                        // files: ['scripts/lazyload/controllers/registro.js']
                    })
                }]
			}
		});
		// fin

		// control de calidad
		$routeProvider.when("/control_de_calidad", {
			templateUrl: "views/control_calidad/control_calidad.html",
			controller: "ControlController",
			resolve: {
				 deps: ["$ocLazyLoad", function(a) {
                    return a.load({
                        name: 'app.registro',
                        files: ['scripts/lazyload/controllers/control.js']
                    })
                }]
			}
		});
		// fin

		// usuarios
		$routeProvider.when("/usuarios", {
			templateUrl: "views/usuarios/usuarios.html",
			controller: "UsuariosController",
			resolve: {
				 deps: ["$ocLazyLoad", function(a) {
                    return a.load({
						name: 'app.usuarios',
						files: ['scripts/lazyload/controllers/usuarios.js']
                    })
                }]
			}
		});


		$routeProvider.when("/mantenimientos/calibre", {
			templateUrl: "views/mantenimientos/calibre.html",
			controller: "CalibresController",
			resolve: {
				 deps: ["$ocLazyLoad", function(a) {
                    return a.load({
						name: 'app.calibres',
						files: ['scripts/lazyload/controllers/calibres.js']
 })
                }]
			}
		});
		//reportes

		// registro
		$routeProvider.when("/reportes/despacho", {
			templateUrl: "views/reportes/reporteDespachos.html",
			controller: "ReportesDespachosController",
			resolve: {
				 deps: ["$ocLazyLoad", function(a) {
                    return a.load({
                        name: 'app.reportesDespachos',
                        files: ['scripts/lazyload/controllers/reportes/reporteDespachos.js']

                    })
                }]
			}
		});

		$routeProvider.when("/reportes/facturascafta", {
			templateUrl: "views/registro/facturar2.html",
			controller: "FacturarController",
			resolve: {
				 deps: ["$ocLazyLoad", function(a) {
                    return a.load({
                        name: 'app.facturar',
                        files: ['scripts/lazyload/controllers/facturar.js']
                    })
                }]
			}
		});


		$routeProvider.when("/mantenimientos/metraje", {
			templateUrl: "views/mantenimientos/metrajes.html",
			controller: "MetrajeController",
			resolve: {
				 deps: ["$ocLazyLoad", function(a) {
                    return a.load({
						name: 'app.metraje',
						files: ['scripts/lazyload/controllers/metraje.js']
 })
                }]
			}
		});
		$routeProvider.when("/reportes/muestra", {
			templateUrl: "views/reportes/reporteMuestras.html",
			controller: "ReportesMuestrasController",
			resolve: {
				 deps: ["$ocLazyLoad", function(a) {
                    return a.load({
                        name: 'app.reportesMuestras',
                        files: ['scripts/lazyload/controllers/reportes/reporteMuestras.js']

                    })
                }]
			}
		});


		$routeProvider.when("/mantenimientos/estilo", {
			templateUrl: "views/mantenimientos/estilos.html",
			controller: "EstiloController",
			resolve: {
				 deps: ["$ocLazyLoad", function(a) {
                    return a.load({
						name: 'app.estilo',
						files: ['scripts/lazyload/controllers/estilo.js']
 })
                }]
			}
		});
		$routeProvider.when("/reportes/dia", {
			templateUrl: "views/reportes/reporteOrdenesPorDia.html",
			controller: "ReportesOrdenesPorDiaController",
			resolve: {
				 deps: ["$ocLazyLoad", function(a) {
                    return a.load({
                        name: 'app.reportesOrdenesPorDia',
                        files: ['scripts/lazyload/controllers/reportes/reporteOrdenesPorDia.js']

                    })
                }]
			}
		});

		$routeProvider.when("/mantenimientos/color", {
			templateUrl: "views/mantenimientos/colores.html",
			controller: "ColorController",
			resolve: {
				 deps: ["$ocLazyLoad", function(a) {
                    return a.load({
						name: 'app.color',
						files: ['scripts/lazyload/controllers/color.js']
 })
                }]
			}
		});
		$routeProvider.when("/reportes/despachosdiarios", {
			templateUrl: "views/reportes/reporteDespachosDiarios.html",
			controller: "ReportesDespachosDiariosController",
			resolve: {
				 deps: ["$ocLazyLoad", function(a) {
                    return a.load({
                        name: 'app.reportesDespachosDiarios',
                        files: ['scripts/lazyload/controllers/reportes/reporteDespachosDiarios.js']

                    })
                }]
			}
		});

		$routeProvider.when("/reportes/cafta", {
			templateUrl: "views/reportes/reporteControlOrdenCafta.html",
			controller: "ReportesControlOrdenCaftaController",
			resolve: {
				 deps: ["$ocLazyLoad", function(a) {
                    return a.load({
                        name: 'app.reportesControlOrdenCafta',
                        files: ['scripts/lazyload/controllers/reportes/reporteControlOrdenCafta.js']
                    })
                }]
			}
		});
		$routeProvider.when("/reportes/estados", {
			templateUrl: "views/reportes/reporteEstadoCuentaOrden.html",
			controller: "ReportesEstadoCuentaOrdenController",
			resolve: {
				 deps: ["$ocLazyLoad", function(a) {
                    return a.load({
                        name: 'app.reportesEstadoCuentaOrden',
                        files: ['scripts/lazyload/controllers/reportes/reporteEstadoCuentaOrden.js']
                    })
                }]
			}
		});
		$routeProvider.when("/reportes/consumo", {
			templateUrl: "views/reportes/reporteEstadoCuentaConsumo.html",
			controller: "ReportesEstadoCuentaConsumoController",
			resolve: {
				 deps: ["$ocLazyLoad", function(a) {
                    return a.load({
                        name: 'app.reportesEstadoCuentaConsumo',
                        files: ['scripts/lazyload/controllers/reportes/reporteEstadoCuentaConsumo.js']
                    })
                }]
			}
		});
		$routeProvider.when("/reportes/clientes", {
			templateUrl: "views/reportes/reporteClientes.html",
			controller: "ReportesClientesController",
			resolve: {
				 deps: ["$ocLazyLoad", function(a) {
                    return a.load({
                        name: 'app.reportesClientes',
                        files: ['scripts/lazyload/controllers/reportes/reporteClientes.js']
                    })
                }]
			}
		});


		// $routeProvider.when("/contactos", {
		// 	templateUrl: "views/contactos/principal.html",
		// 	resolve: {
		// 		 deps: ["$ocLazyLoad", function(a) {
        //             return a.load({
        //                 name: 'app.contactos',
        //                 files: ['scripts/lazyload/controllers/contactos.js']
        //             })
        //         }]
		// 	}
		// });


		// fin


	}])


	

}())


