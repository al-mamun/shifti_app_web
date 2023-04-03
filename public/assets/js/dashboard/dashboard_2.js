// Risk factor chart
var options4 = {
  series: [70],
  chart: {
    height: 350,
    type: 'radialBar',
    offsetY: -10,
  },

  plotOptions: {
    radialBar: {
      startAngle: -135,
      endAngle: 135,
      inverseOrder: true,
      hollow: {
        margin: 5,
        size: '60%',
        image: '../assets/images/dashboard-2/radial-image.png',
        imageWidth: 140,
        imageHeight: 140,
        imageClipped: false,
      },
      track: {
        opacity: 0.4,
        colors: CubaAdminConfig.primary
      },
      dataLabels: {
        enabled: false,
        enabledOnSeries: undefined,
        formatter: function (val, opts) {
          return val + "%"
        },
        textAnchor: 'middle',
        distributed: false,
        offsetX: 0,
        offsetY: 0,

        style: {
          fontSize: '14px',
          fontFamily: 'Helvetica, Arial, sans-serif',
          fill:['#2b2b2b'],

        },
      },
    }
  },

  fill: {
    type: 'gradient',
    gradient: {
      shade: 'light',
      shadeIntensity: 0.15,
      inverseColors: false,
      opacityFrom: 1,
      opacityTo: 1,
      stops: [0, 100],
      gradientToColors: ['#a927f9'],
      type: 'horizontal'
    },
  },
  stroke: {
    dashArray: 15,
    strokecolor: ['#ffffff']
  },

  labels: ['Selling rate'],
  colors: [ CubaAdminConfig.primary ],
};
var chart4 = new ApexCharts(document.querySelector("#riskfactorchart"),
  options4
);

chart4.render();

// Monthly sale
var options1 = {
  series: [{
    name: 'series1',
    data: [280, 170, 440, 170, 270, 130]

  }, {
    name: 'series2',
    data: [150, 500, 300, 250, 420, 350]

  }, {
    name: 'series3',
    data: [450, 150, 320, 500, 280, 100]

  }],
  chart: {
    height: 150,
    type: 'area',
    toolbar: {
      show: false
    },
  },
  dataLabels: {
    enabled: false
  },
  stroke: {
    curve: 'smooth',
    width: 0
  },
  xaxis: {
    type: 'datetime',
    categories: ["2018-09-19T00:00:00.000Z", "2018-09-19T01:30:00.000Z", "2018-09-19T02:30:00.000Z", "2018-09-19T03:30:00.000Z", "2018-09-19T04:30:00.000Z", "2018-09-19T05:30:00.000Z"]

  },
  tooltip: {
    x: {
      format: 'dd/MM/yy HH:mm'
    },
  },
  legend: {
    show: false,
  },
  grid: {
    show: false,
    padding: {
      left: 0,
      right: 0,
      top: 0,
      bottom: -40,
    }
  },
  fill: {
    type: 'gradient',
    opacity: [1, 0.4, 0.25],
    gradient: {
      shade: 'light',
      type: 'horizontal',
      shadeIntensity: 1,
      gradientToColors: ['#a26cf8', '#a927f9', '#7366ff'],
      opacityFrom: [1, 0.4, 0.25],
      opacityTo: [1, 0.4, 0.25],
      stops: [30, 100],
      colorStops: []
    },
    colors: [ CubaAdminConfig.primary , CubaAdminConfig.primary , CubaAdminConfig.primary],
  },
  colors: [CubaAdminConfig.primary, CubaAdminConfig.secondary, CubaAdminConfig.secondary],
};

var chart1 = new ApexCharts(document.querySelector("#spaline-chart"),
  options1
);

chart1.render();




// total earning
var options2 = {
  series: [{
    name: 'Daily',
    data: [0.40, 0.50, 0.60, 0.70, 0.80, 0.90, 1.10, 1.15, 1.20, 1.25, 1.30, 1.35, 1.40, 1.45, 1.50,
      1.55, 1.50, 1.45, 1.40, 1.35, 1.30, 1.25, 1.20, 1.15, 1.10, 1.05, 0.90, 0.85, 0.80, 0.75, 0.70, 0.65, 0.60, 0.55, 0.50, 0.45, 0.40, 0.35
    ]
  },
  {
    name: 'Weekly',
    data: [-0.40, -0.50, -0.60, -0.70, -0.80, -0.90, -1.10, -1.15, -1.20, -1.25, -1.30, -1.35, -1.40, -1.45, -1.50,
    -1.55, -1.50, -1.45, -1.40, -1.35, -1.30, -1.25, -1.20, -1.15, -1.10, -1.05, -0.90, -0.85, -0.80, -0.75, -0.70, -0.65, -0.60, -0.55, -0.50, -0.45, -0.40, -0.35
    ]
  },
  {
    name: 'Monthly',
    data: [-1.35, -1.45, -1.55, -1.65, -1.75, -1.85, -1.95, -2.15, -2.25, -2.35, -2.45, -2.55, -2.65, -2.75, -2.85,
    -2.95, -3.00, -3.10, -3.20, -3.25, -3.10, -3.00, -2.95, -2.85, -2.75, -2.65, -2.55, -2.45, -2.35, -2.25, -2.15, -1.95, -1.85, -1.75, -1.65, -1.55, -1.45, -1.35
    ]
  },
  {
    name: 'Yearly',
    data: [1.35, 1.45, 1.55, 1.65, 1.75, 1.85, 1.95, 2.15, 2.25, 2.35, 2.45, 2.55, 2.65, 2.75, 2.85,
    2.95, 3.00, 3.10, 3.20, 3.25, 3.10, 3.00, 2.95, 2.85, 2.75, 2.65, 2.55, 2.45, 2.35, 2.25, 2.15, 1.95, 1.85, 1.75, 1.65, 1.55, 1.45, 1.35
    ]
  }
  ],
  chart: {
    type: 'bar',
    height: 320,
    stacked: true,
    toolbar: {
      show: false
    },
  },
 colors: [ CubaAdminConfig.primary , CubaAdminConfig.primary , CubaAdminConfig.primary , CubaAdminConfig.primary ],
  plotOptions: {
    bar: {
      vertical: true,
      columnWidth: '40%',
      barHeight: '80%',
      startingShape: 'rounded',
      endingShape: 'rounded'
    },
  },
  dataLabels: {
    enabled: false
  },
  stroke: {
    width: 0

  },
  legend: {
    show: false,
  },
  grid: {
    xaxis: {
      lines: {
        show: false
      }
    },
    yaxis: {
      lines: {
        show: false
      }
    },
  },
  yaxis: {
    min: -5,
    max: 5,
    show: false,
    axisBorder: {
      show: false
    },
    axisTicks: {
      show: false,
    },

  },
  tooltip: {
    shared: true,
    x: {
      formatter: function (val) {
        return val
      }
    },
    y: {
      formatter: function (val) {
        return Math.abs(val) + "%"
      }
    }
  },
  xaxis: {
    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'July', 'Aug',
      'Sep', 'Oct', 'Nov', 'Dec'
    ],
    labels: {
      show: true
    },
    axisBorder: {
      show: false
    },
    axisTicks: {
      show: false
    }

  },

  fill: {
    // type: 'solid',
    opacity: [0.8, 0.8, 0.2, 0.2],
    colors: [function({ value, seriesIndex, w }) {
      if(value < 0.75) {
          return "#a26cf8"
      } else {
          return CubaAdminConfig.primary
      }
    }]
  }
};

var chart2 = new ApexCharts(document.querySelector("#negative-chart"),
  options2
);

chart2.render();


// month total
var options3 = {
  series: [{
        name: 'Tokyo',
        data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4,
            194.1, 95.6, 54.4]

    }, {
        name: 'New York',
        data: [83.6, 78.8, 98.5, 93.4, 106.0, 84.5, 105.0, 104.3, 91.2, 83.5,
            106.6, 92.3]

    }, {
        name: 'London',
        data: [48.9, 38.8, 39.3, 41.4, 47.0, 48.3, 59.0, 59.6, 52.4, 65.2, 59.3,
            51.2]

    }, {
        name: 'Berlin',
        data: [42.4, 33.2, 34.5, 39.7, 52.6, 75.5, 57.4, 60.4, 47.6, 39.1, 46.8,
            51.1]

    }],
  chart: {
    height: 250,
    type: 'bar',
    stacked: true,
    toolbar: {
      show: false
    },
  },
  plotOptions: {
    bar: {
      dataLabels: {
        position: 'top', // top, center, bottom
      },

      columnWidth: '20%',
      startingShape: 'rounded',
      endingShape: 'rounded'
    }
  },
  dataLabels: {
    enabled: false,

    formatter: function (val) {
      return val + "%";
    },
    offsetY: -10,
    style: {
      fontSize: '12px',
      colors: [ CubaAdminConfig.primary ]
    }
  },

    xAxis: {
        categories: [
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'May',
            'Jun',
            'Jul',
            'Aug',
            'Sep',
            'Oct',
            'Nov',
            'Dec'
        ],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Rainfall (mm)'
        }
    },
  grid: {
    show: false,
    padding: {
      top: -35,
      right: -45,
      bottom: -20,
      left: -10
    },
  },
  colors: [ CubaAdminConfig.primary ],

};

var chart3 = new ApexCharts(document.querySelector("#column-chart"),
  options3
);

chart3.render();






