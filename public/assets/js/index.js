$(function() {
    "use strict";

	
// chart 1

	 
// chart 2



// worl map




// chart 3

var ctx = document.getElementById('chart3').getContext('2d');

var gradientStroke1 = ctx.createLinearGradient(0, 0, 0, 300);
gradientStroke1.addColorStop(0, '#00b09b');
gradientStroke1.addColorStop(1, '#96c93d');

var labels = JSON.parse(ctx.canvas.getAttribute('data-labels'));
var counts = JSON.parse(ctx.canvas.getAttribute('data-counts'));

var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: 'Jumlah Peminjaman',
            data: counts,
            backgroundColor: gradientStroke1,
            fill: {
                target: 'origin',
                above: 'rgb(21 202 32 / 15%)',
            },
            tension: 0.4,
            borderColor: gradientStroke1,
            borderWidth: 3
        }]
    },
    options: {
        maintainAspectRatio: false,
        plugins: {
            tooltip: {
                callbacks: {
                    title: function(context) {
                        return context[0].label;
                    }
                }
            },
            legend: {
                display: false,
            }
        },
        scales: {
            x: {
                ticks: {
                    callback: function(value, index, values) {
                        let label = this.getLabelForValue(value);
                        return label.length > 5 ? label.slice(0, 5) + '...' : label;
                    }
                }
            },
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 10, // Kelipatan 5
                }
            }
        }
    }
});





// chart 4

var ctx = document.getElementById("chart4").getContext('2d');

var gradientStroke1 = ctx.createLinearGradient(0, 0, 0, 300);
gradientStroke1.addColorStop(0, '#ee0979');
gradientStroke1.addColorStop(1, '#ff6a00');

var gradientStroke2 = ctx.createLinearGradient(0, 0, 0, 300);
gradientStroke2.addColorStop(0, '#283c86');
gradientStroke2.addColorStop(1, '#39bd3c');

var gradientStroke3 = ctx.createLinearGradient(0, 0, 0, 300);
gradientStroke3.addColorStop(0, '#7f00ff');
gradientStroke3.addColorStop(1, '#e100ff');

var labels = JSON.parse(ctx.canvas.getAttribute('data-labels'));
var counts = JSON.parse(ctx.canvas.getAttribute('data-counts'));

var myChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: labels.map(label => label.length > 10 ? label.slice(0, 10) + '...' : label),
        datasets: [{
            backgroundColor: [gradientStroke1, gradientStroke2, gradientStroke3],
            hoverBackgroundColor: [gradientStroke1, gradientStroke2, gradientStroke3],
            data: counts,
            borderWidth: [1, 1, 1]
        }]
    },
    options: {
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false,
            },
            tooltip: {
                callbacks: {
                    title: function(context) {
                        // Menampilkan judul lengkap saat hover
                        return labels[context[0].dataIndex];
                    }
                }
            }
        },
        cutout: 75,
    }
});


	  



  // chart 5

    // var ctx = document.getElementById("chart5").getContext('2d');
   
    //   var gradientStroke1 = ctx.createLinearGradient(0, 0, 0, 300);
    //   gradientStroke1.addColorStop(0, '#f54ea2');
    //   gradientStroke1.addColorStop(1, '#ff7676');

    //   var gradientStroke2 = ctx.createLinearGradient(0, 0, 0, 300);
    //   gradientStroke2.addColorStop(0, '#42e695');
    //   gradientStroke2.addColorStop(1, '#3bb2b8');

    //   var myChart = new Chart(ctx, {
    //     type: 'bar',
    //     data: {
    //       labels: [1, 2, 3, 4, 5],
    //       datasets: [{
    //         label: 'Clothing',
    //         data: [40, 30, 60, 35, 60],
    //         borderColor: gradientStroke1,
    //         backgroundColor: gradientStroke1,
    //         hoverBackgroundColor: gradientStroke1,
    //         pointRadius: 0,
    //         fill: false,
    //         borderWidth: 1
    //       }, {
    //         label: 'Electronic',
    //         data: [50, 60, 40, 70, 35],
    //         borderColor: gradientStroke2,
    //         backgroundColor: gradientStroke2,
    //         hoverBackgroundColor: gradientStroke2,
    //         pointRadius: 0,
    //         fill: false,
    //         borderWidth: 1
    //       }]
    //     },
    //     options: {
		// 		  maintainAspectRatio: false,
    //       barPercentage: 0.5,
    //       categoryPercentage: 0.8,
		// 		  plugins: {
		// 			  legend: {
		// 				  display: false,
		// 			  }
		// 		  },
		// 		  scales: {
		// 			  y: {
		// 				  beginAtZero: true
		// 			  }
		// 		  }
		// 	  }
    //   });




   });	 
   