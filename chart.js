var optionsPie = {
  series: [44, 55, 13, 22],
  chart: {
    width: 380,
    type: "pie",
  },
  labels: ["Done", "Pending", "On Process", "Open Ticket"],
  responsive: [
    {
      breakpoint: 480,
      options: {
        chart: {
          width: 200,
        },
        legend: {
          position: "bottom",
        },
      },
    },
  ],
};

var pieChart = new ApexCharts(document.querySelector("#pieChart"), optionsPie);
pieChart.render();

var optionsChart = {
  series: [
    {
      data: [44, 55, 41, 64, 22, 43, 21],
    },
    {
      data: [53, 32, 33, 52, 13, 44, 32],
    },
  ],
  chart: {
    type: "bar",
    height: 430,
  },
  plotOptions: {
    bar: {
      horizontal: true,
      dataLabels: {
        position: "top",
      },
    },
  },
  dataLabels: {
    enabled: true,
    offsetX: -6,
    style: {
      fontSize: "12px",
      colors: ["#fff"],
    },
  },
  stroke: {
    show: true,
    width: 1,
    colors: ["#fff"],
  },
  tooltip: {
    shared: true,
    intersect: false,
  },
  xaxis: {
    categories: [2001, 2002, 2003, 2004, 2005, 2006, 2007],
  },
};

var barChart = new ApexCharts(
  document.querySelector("#barChart"),
  optionsChart
);
barChart.render();

function nipValidation() {
  var NIPadd = document.getElementsByName("NIPadd").values;
  var msgNIP = document.getElementsByName("msgNIP");
  var NIPbox = document.getElementById("NIPbox");
  var pattern = /([E])+(\d{4})/;

  if (NIPadd.match(pattern)) {
    msgNIP.classlist.add("valid");
    msgNIP.innerHTML = "NIP Address valid.";
    NIPbox.classlist.add("validBox");
  } else {
    msgNIP.classlist.add("invalid");
    msgNIP.innerHTML = "NIP Address invalid.";
    NIPbox.classlist.add("invalidBox");
  }
}
