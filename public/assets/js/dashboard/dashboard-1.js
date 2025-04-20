

(function($) {
    /* "use strict" */
	
 var dzChartlist = function(){
	
	var screenWidth = $(window).width();
	//let draw = Chart.controllers.line.__super__.draw; //draw shadow
	
	var NewExperience = function(){
		var options = {
		  series: [
			{
				name: 'Net Profit',
				data: [100,300, 200, 250, 200, 240, 180,230,200, 250, 300],
				/* radius: 30,	 */
			}, 				
		],
			chart: {
			type: 'area',
			height: 40,
			//width: 400,
			toolbar: {
				show: false,
			},
			zoom: {
				enabled: false
			},
			sparkline: {
				enabled: true
			}
			
		},
		
		colors:['var(--primary)'],
		dataLabels: {
		  enabled: false,
		},

		legend: {
			show: false,
		},
		stroke: {
		  show: true,
		  width: 2,
		  curve:'straight',
		  colors:['var(--primary)'],
		},
		
		grid: {
			show:false,
			borderColor: '#eee',
			padding: {
				top: 0,
				right: 0,
				bottom: 0,
				left: -1

			}
		},
		states: {
                normal: {
                    filter: {
                        type: 'none',
                        value: 0
                    }
                },
                hover: {
                    filter: {
                        type: 'none',
                        value: 0
                    }
                },
                active: {
                    allowMultipleDataPointsSelection: false,
                    filter: {
                        type: 'none',
                        value: 0
                    }
                }
            },
		xaxis: {
			categories: ['Jan', 'feb', 'Mar', 'Apr', 'May', 'June', 'July','August', 'Sept','Oct'],
			axisBorder: {
				show: false,
			},
			axisTicks: {
				show: false
			},
			labels: {
				show: false,
				style: {
					fontSize: '12px',
				}
			},
			crosshairs: {
				show: false,
				position: 'front',
				stroke: {
					width: 1,
					dashArray: 3
				}
			},
			tooltip: {
				enabled: true,
				formatter: undefined,
				offsetY: 0,
				style: {
					fontSize: '12px',
				}
			}
		},
		yaxis: {
			show: false,
		},
		fill: {
		  opacity: 0.9,
		  colors:'var(--primary)',
		  type: 'gradient', 
		  gradient: {
			colorStops:[ 
				
				{
				  offset: 0,
				  color: 'var(--primary)',
				  opacity: .5
				},
				{
				  offset: 0.6,
				  color: 'var(--primary)',
				  opacity: .5
				},
				{
				  offset: 100,
				  color: 'white',
				  opacity: 0
				}
			  ],
			  
			}
		},
		tooltip: {
			enabled:false,
			style: {
				fontSize: '12px',
			},
			y: {
				formatter: function(val) {
					return "$" + val + " thousands"
				}
			}
		}
		};

		var chartBar1 = new ApexCharts(document.querySelector("#NewExperience"), options);
		chartBar1.render();
	 
	}
	var AllProject = function(){
		var options = {
			series: [12, 30, 20],
         chart: {
			type: 'donut',
			width: 150,
		},
       plotOptions: {
			pie: {
			  donut: {
				size: '80%',
				labels: {
					show: true,
					name: {
						show: true,
						offsetY: 12,
					},
					value: {
						show: true,
						fontSize: '22px',
						fontFamily:'Arial',
						fontWeight:'500',
						offsetY: -17,
					},
					total: {
						show: true,
						fontSize: '11px',
						fontWeight:'500',
						fontFamily:'Arial',
						label: 'Compete',
					   
						formatter: function (w) {
						  return w.globals.seriesTotals.reduce((a, b) => {
							return a + b
						  }, 0)
						}
					}
				}
			  }
			}
		},
		 legend: {
                show: false,
            },
		 colors: ['#3AC977', 'var(--primary)', 'var(--secondary)'],
			labels: ["Compete", "Pending", "Not Start"],
			dataLabels: {
				enabled: false,
			},
        };
		var chartBar1 = new ApexCharts(document.querySelector("#AllProject"), options);
		chartBar1.render();
	 
	}
	
	var overiewChart = function(){
		var options = {
		  series: [{
			name: 'Answered Calls',
			type: 'column',
			data: [120, 140, 130, 150, 110, 125, 160, 170, 155, 145, 135, 150]
		  }, {
			name: 'Missed Calls',
			type: 'area',
			data: [30, 25, 35, 20, 40, 30, 20, 15, 25, 30, 20, 10]
		  }, {
			name: 'Escalated Calls',
			type: 'line',
			data: [10, 5, 12, 8, 6, 7, 9, 11, 5, 4, 8, 6]
		  }],
		  chart: {
			height: 300,
			type: 'line',
			stacked: false,
			toolbar: {
			  show: false,
			},
		  },
		  stroke: {
			width: [0, 1, 1],
			curve: 'straight',
			dashArray: [0, 0, 5]
		  },
		  legend: {
			fontSize: '13px',
			fontFamily: 'poppins',
			labels: {
			  colors:'#888888', 
			}
		  },
		  plotOptions: {
			bar: {
			  columnWidth: '18%',
			  borderRadius: 6,
			}
		  },
		  fill: {
			type: 'gradient',
			gradient: {
			  inverseColors: false,
			  shade: 'light',
			  type: "vertical",
			  colorStops : [
				[
				  {
					offset: 0,
					color: 'var(--primary)',
					opacity: 1
				  },
				  {
					offset: 100,
					color: 'var(--primary)',
					opacity: 1
				  }
				],
				[
				  {
					offset: 0,
					color: '#FFAA00',
					opacity: 1
				  },
				  {
					offset: 0.4,
					color: '#FFAA00',
					opacity: .15
				  },
				  {
					offset: 100,
					color: '#FFAA00',
					opacity: 0
				  }
				],
				[
				  {
					offset: 0,
					color: '#FF5E5E',
					opacity: 1
				  },
				  {
					offset: 100,
					color: '#FF5E5E',
					opacity: 1
				  }
				]
			  ],
			  stops: [0, 100, 100, 100]
			}
		  },
		  colors: ["var(--primary)", "#FFAA00", "#FF5E5E"],
		  labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul',
			'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
		  markers: {
			size: 0
		  },
		  xaxis: {
			type: 'month',
			labels: {
			  style: {
				fontSize: '13px',
				colors:'#888888',
			  },
			},
		  },
		  yaxis: {
			min: 0,
			tickAmount: 4,
			labels: {
			  style: {
				fontSize: '13px',
				colors:'#888888',
			  },
			},
		  },
		  tooltip: {
			shared: true,
			intersect: false,
			y: {
			  formatter: function (y) {
				if (typeof y !== "undefined") {
				  return y.toFixed(0) + " calls";
				}
				return y;
			  }
			}
		  }
		};
	  
		var chart = new ApexCharts(document.querySelector("#overiewChart"), options);
		chart.render();
	  
		$(".mix-chart-tab .nav-link").on('click', function(){
		  var seriesType = $(this).attr('data-series');
		  var answeredData = [];
		  var missedData = [];
		  var escalatedData = [];
	  
		  switch(seriesType) {
			case "week":
			  answeredData = [32, 45, 38, 50, 30, 40, 42];
			  missedData = [6, 3, 5, 4, 8, 6, 4];
			  escalatedData = [2, 1, 3, 1, 2, 2, 1];
			  break;
			case "month":
			  answeredData = [120, 140, 130, 150, 110, 125, 160, 170, 155, 145, 135, 150];
			  missedData = [30, 25, 35, 20, 40, 30, 20, 15, 25, 30, 20, 10];
			  escalatedData = [10, 5, 12, 8, 6, 7, 9, 11, 5, 4, 8, 6];
			  break;
			case "year":
			  answeredData = [1100, 1200, 1150, 1300, 1400, 1250, 1350, 1450, 1400, 1500, 1550, 1600];
			  missedData = [100, 90, 80, 85, 95, 100, 110, 90, 80, 75, 70, 65];
			  escalatedData = [50, 40, 45, 60, 55, 50, 48, 52, 49, 55, 45, 40];
			  break;
			case "all":
			  answeredData = [500, 600, 550, 650, 620, 700, 750, 680, 710, 690, 720, 740];
			  missedData = [60, 55, 50, 48, 52, 58, 60, 57, 59, 62, 50, 55];
			  escalatedData = [20, 18, 15, 17, 19, 22, 25, 20, 18, 21, 23, 20];
			  break;
			default:
			  answeredData = [120, 140, 130, 150, 110, 125, 160, 170, 155, 145, 135, 150];
			  missedData = [30, 25, 35, 20, 40, 30, 20, 15, 25, 30, 20, 10];
			  escalatedData = [10, 5, 12, 8, 6, 7, 9, 11, 5, 4, 8, 6];
		  }
	  
		  chart.updateSeries([
			{
			  name: "Answered Calls",
			  type: 'column',
			  data: answeredData
			},{
			  name: 'Missed Calls',
			  type: 'area',
			  data: missedData
			},{
			  name: 'Escalated Calls',
			  type: 'line',
			  data: escalatedData
			}
		  ]);
		});
	  }
	  

	var chartBar = function(){
		var options = {
			  series: [
				{
					name: 'Running',
					data: [50, 90, 90],
					//radius: 12,	
				}, 
				{
				  name: 'Cycling',
				  data: [50, 60, 55]
				}, 
				
			],
				chart: {
				type: 'bar',
				height: 120,
				
				toolbar: {
					show: false,
				},
				
			},
			plotOptions: {
			  bar: {
				horizontal: false,
				columnWidth: '100%',
				endingShape: "rounded",
				borderRadius: 8,
			  },
			  
			},
			states: {
			  hover: {
				filter: 'none',
			  }
			},
			colors:['#F8B940', '#FFFFFF'],
			dataLabels: {
			  enabled: false,
			  offsetY: -30
			},
			
			legend: {
				show: false,
				fontSize: '12px',
				labels: {
					colors: '#000000',
					
					},
				markers: {
				width: 18,
				height: 18,
				strokeWidth: 8,
				strokeColor: '#fff',
				fillColors: undefined,
				radius: 12,	
				}
			},
			stroke: {
			  show: true,
			  width:14,
			  curve: 'smooth',
			  lineCap: 'round',
			  colors: ['transparent']
			},
			grid: {
				show: false,
				xaxis: {
					lines: {
						show: false,
					}
				},
				 yaxis: {
						lines: {
							show: false
						}
					},  				
			},
			xaxis: {
				categories: ['JAN', 'FEB', 'MAR', 'APR', 'MAY'],
				labels: {
					show: false,
					style: {
						colors: '#A5AAB4',
						fontSize: '14px',
						fontWeight: '500',
						fontFamily: 'poppins',
						cssClass: 'apexcharts-xaxis-label',
					},
				},
				crosshairs: {
					show: false,
				},
				axisBorder: {
					show: false,
				},
				axisTicks: {
					show: false,
				}, 			
			},
			yaxis: {
				labels: {
				show: false,
					offsetX:-16,
				   style: {
					  colors: '#000000',
					  fontSize: '13px',
					   fontFamily: 'poppins',
					  fontWeight: 100,
					  cssClass: 'apexcharts-xaxis-label',
				  },
			  },
			},
			};

			var chartBar1 = new ApexCharts(document.querySelector("#chartBar"), options);
			chartBar1.render();
	}

	var chartBarTwo = function(){
		var options = {
			  series: [
				{
					name: 'Running',
					data: [50, 90, 90],
					//radius: 12,	
				}, 
				{
				  name: 'Cycling',
				  data: [50, 60, 55]
				}, 
				
			],
				chart: {
				type: 'bar',
				height: 120,
				
				toolbar: {
					show: false,
				},
				
			},
			plotOptions: {
			  bar: {
				horizontal: false,
				columnWidth: '100%',
				endingShape: "rounded",
				borderRadius: 8,
			  },
			  
			},
			states: {
			  hover: {
				filter: 'none',
			  }
			},
			colors:['#F8B940', '#FFFFFF'],
			dataLabels: {
			  enabled: false,
			  offsetY: -30
			},
			
			legend: {
				show: false,
				fontSize: '12px',
				labels: {
					colors: '#000000',
					
					},
				markers: {
				width: 18,
				height: 18,
				strokeWidth: 8,
				strokeColor: '#fff',
				fillColors: undefined,
				radius: 12,	
				}
			},
			stroke: {
			  show: true,
			  width:14,
			  curve: 'smooth',
			  lineCap: 'round',
			  colors: ['transparent']
			},
			grid: {
				show: false,
				xaxis: {
					lines: {
						show: false,
					}
				},
				 yaxis: {
						lines: {
							show: false
						}
					},  				
			},
			xaxis: {
				categories: ['JAN', 'FEB', 'MAR', 'APR', 'MAY'],
				labels: {
					show: false,
					style: {
						colors: '#A5AAB4',
						fontSize: '14px',
						fontWeight: '500',
						fontFamily: 'poppins',
						cssClass: 'apexcharts-xaxis-label',
					},
				},
				crosshairs: {
					show: false,
				},
				axisBorder: {
					show: false,
				},
				axisTicks: {
					show: false,
				}, 			
			},
			yaxis: {
				labels: {
				show: false,
					offsetX:-16,
				   style: {
					  colors: '#000000',
					  fontSize: '13px',
					   fontFamily: 'poppins',
					  fontWeight: 100,
					  cssClass: 'apexcharts-xaxis-label',
				  },
			  },
			},
			};

			var chartBar2 = new ApexCharts(document.querySelector("#chartBar2"), options);
			chartBar2.render();
	}

	var expensesChart = function(){
		var options = {
			  series: [
				{
					name: 'Running',
					data: [40, 80, 70],
					//radius: 12,	
				}, 
				{
				  name: 'Cycling',
				  data: [60, 30, 70]
				}, 
				
			],
				chart: {
				type: 'bar',
				height: 120,
				
				toolbar: {
					show: false,
				},
				
			},
			plotOptions: {
			  bar: {
				horizontal: false,
				columnWidth: '100%',
				endingShape: "rounded",
				borderRadius: 8,
			  },
			  
			},
			states: {
			  hover: {
				filter: 'none',
			  }
			},
			colors:['#FFFFFF', '#222B40'],
			dataLabels: {
			  enabled: false,
			  offsetY: -30
			},
			
			legend: {
				show: false,
				fontSize: '12px',
				labels: {
					colors: '#000000',
					
					},
				markers: {
				width: 18,
				height: 18,
				strokeWidth: 8,
				strokeColor: '#fff',
				fillColors: undefined,
				radius: 12,	
				}
			},
			stroke: {
			  show: true,
			  width:14,
			  curve: 'smooth',
			  lineCap: 'round',
			  colors: ['transparent']
			},
			grid: {
				show: false,
				xaxis: {
					lines: {
						show: false,
					}
				},
				 yaxis: {
						lines: {
							show: false
						}
					},  				
			},
			xaxis: {
				categories: ['JAN', 'FEB', 'MAR', 'APR', 'MAY'],
				labels: {
					show: false,
					style: {
						colors: '#A5AAB4',
						fontSize: '14px',
						fontWeight: '500',
						fontFamily: 'poppins',
						cssClass: 'apexcharts-xaxis-label',
					},
				},
				crosshairs: {
					show: false,
				},
				axisBorder: {
					show: false,
				},
				axisTicks: {
					show: false,
				}, 			
			},
			yaxis: {
				labels: {
				show: false,
					offsetX:-16,
				   style: {
					  colors: '#000000',
					  fontSize: '13px',
					   fontFamily: 'poppins',
					  fontWeight: 100,
					  cssClass: 'apexcharts-xaxis-label',
				  },
			  },
			},
			};

			var chartBar1 = new ApexCharts(document.querySelector("#expensesChart"), options);
			chartBar1.render();
	}

	var expensesChartTwo = function(){
		var options = {
			  series: [
				{
					name: 'Running',
					data: [40, 80, 70],
					//radius: 12,	
				}, 
				{
				  name: 'Cycling',
				  data: [60, 30, 70]
				}, 
				
			],
				chart: {
				type: 'bar',
				height: 120,
				
				toolbar: {
					show: false,
				},
				
			},
			plotOptions: {
			  bar: {
				horizontal: false,
				columnWidth: '100%',
				endingShape: "rounded",
				borderRadius: 8,
			  },
			  
			},
			states: {
			  hover: {
				filter: 'none',
			  }
			},
			colors:['#FFFFFF', '#222B40'],
			dataLabels: {
			  enabled: false,
			  offsetY: -30
			},
			
			legend: {
				show: false,
				fontSize: '12px',
				labels: {
					colors: '#000000',
					
					},
				markers: {
				width: 18,
				height: 18,
				strokeWidth: 8,
				strokeColor: '#fff',
				fillColors: undefined,
				radius: 12,	
				}
			},
			stroke: {
			  show: true,
			  width:14,
			  curve: 'smooth',
			  lineCap: 'round',
			  colors: ['transparent']
			},
			grid: {
				show: false,
				xaxis: {
					lines: {
						show: false,
					}
				},
				 yaxis: {
						lines: {
							show: false
						}
					},  				
			},
			xaxis: {
				categories: ['JAN', 'FEB', 'MAR', 'APR', 'MAY'],
				labels: {
					show: false,
					style: {
						colors: '#A5AAB4',
						fontSize: '14px',
						fontWeight: '500',
						fontFamily: 'poppins',
						cssClass: 'apexcharts-xaxis-label',
					},
				},
				crosshairs: {
					show: false,
				},
				axisBorder: {
					show: false,
				},
				axisTicks: {
					show: false,
				}, 			
			},
			yaxis: {
				labels: {
				show: false,
					offsetX:-16,
				   style: {
					  colors: '#000000',
					  fontSize: '13px',
					   fontFamily: 'poppins',
					  fontWeight: 100,
					  cssClass: 'apexcharts-xaxis-label',
				  },
			  },
			},
			};

			var chartBar1 = new ApexCharts(document.querySelector("#expensesChart2"), options);
			chartBar1.render();
	}

	var redial = function(){
		var options = {
		series: [75],
		chart: {
		type: 'radialBar',
		offsetY: 0,
		height:160,
		sparkline: {
		  enabled: true
		}
	  },
	  plotOptions: {
		radialBar: {
		  startAngle: -180,
		  endAngle: 180,
		  track: {
			background: "#F1EAFF",
			strokeWidth: '100%',
			margin: 3,
		  },
		  
		  hollow: {
			margin: 20,
			size: '60%',
			background: 'transparent',
			image: undefined,
			imageOffsetX: 0,
			imageOffsetY: 0,
			position: 'front',
		  },
		  
		  dataLabels: {
			name: {
			  show: false
			},
			value: {
			  offsetY: 5,
			  fontSize: '24px',
			  color:'#000000',
			  fontWeight:600,
			}
		  }
		}
	  },
	  responsive: [{
		breakpoint: 1600,
		options: {
		 chart: {
			height:150
		  },
		}
	  }
	  
	  ],
	  grid: {
		padding: {
		  top: -10
		}
	  },
	  /* stroke: {
		dashArray: 4,
		colors:'#6EC51E'
	  }, */
	  fill: {
		type: 'gradient',
		colors:'#7A849B',
		gradient: {
			shade: 'black',
			shadeIntensity: 0.15,
			inverseColors: false,
			opacityFrom: 1,
			opacityTo: 1,
			stops: [64, 43, 64, 0.5]
		},
	  },
	  labels: ['Average Results'],
	  };

	  var chart = new ApexCharts(document.querySelector("#redial"), options);
	  chart.render();
  
  
  }

  var swiperreview = function() {
		
	var swiper = new Swiper('.mySwiper', {
		speed: 1500,
		parallax: true,
		slidesPerView: 4,
		spaceBetween: 20,
		autoplay: {
			delay: 1000,
		},
		navigation: {
			nextEl: ".swiper-button-next",
			prevEl: ".swiper-button-prev",
		},
		breakpoints: {
			
		  300: {
			slidesPerView: 1,
			spaceBetween: 20,
		  },
		  416: {
			slidesPerView: 2,
			spaceBetween: 20,
		  },
		   768: {
			slidesPerView: 2,
			spaceBetween: 20,
		  },
		   1280: {
			slidesPerView: 3,
			spaceBetween: 20,
		  },
		  1788: {
			slidesPerView: 3,
			spaceBetween: 20,
		  },
		},
	});
	$('#container_layout').on('change',function(){
		if($('body').attr('data-container') == "boxed" || "wide-boxed"){
			swiper.params.slidesPerView = 3
		}else{
			swiper.params.slidesPerView = 4
		}
	})
}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
 
	/* Function ============ */
		return {
			init:function(){
			},
			
			
			load:function(){
				NewExperience();
				AllProject();
				overiewChart();
				chartBar();
				chartBarTwo();
				expensesChart();
				expensesChartTwo();
				redial();
				swiperreview();
				
			},
			
			resize:function(){
			}
		}
	
	}();

	
		
	jQuery(window).on('load',function(){
		setTimeout(function(){
			dzChartlist.load();
		}, 1000); 
		
	});

     

})(jQuery);
