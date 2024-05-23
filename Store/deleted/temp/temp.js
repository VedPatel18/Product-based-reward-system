const wheel = document.getElementById("wheel");
const spinBtn = document.getElementById("spin-btn");
const finalValue = document.getElementById("final-value");

const data = [
  {
    id: 1,
    label: "Reward Points 222",
    value: 222
  },
  {
    id: 2,
    label: "Gift Premium (Days) 30",
    value: 30
  },
  {
    id: 10,
    label: "Gift Premium (Days) 30",
    value: 30
  },
  {
    id: 3,
    label: "Spin Again",
    value: 0
  },
  {
    id: 4,
    label: "Reward Points 150",
    value: 150
  },
  {
    id: 6,
    label: "Better Luck Next Time",
    value: 0
  }
];

const pieColors = ["#8b35bc", "#b163da", "#8b35bc", "#b163da", "#8b35bc"];
const pieSizes = Array(data.length).fill(360 / data.length);
const pieBackgroundColors = pieColors.slice(0, data.length);

let currentAngle = 0;
const segments = [];

pieSizes.forEach((size, index) => {
  const segment = {
    id: data[index].id,
    label: data[index].label,
    value: data[index].value,
    startAngle: currentAngle,
    endAngle: currentAngle + size,
    backgroundColor: pieBackgroundColors[index]
  };

  segments.push(segment);
  currentAngle += size;
});

const myChart = new Chart(wheel, {
  plugins: [ChartDataLabels],
  type: "pie",
  data: {
    labels: segments.map((segment) => segment.id),
    datasets: [
      {
        backgroundColor: segments.map((segment) => segment.backgroundColor),
        data: segments.map(() => 1),
      },
    ],
  },
  options: {
    responsive: true,
    animation: { duration: 0 },
    plugins: {
      tooltip: false,
      legend: {
        display: false,
      },
      datalabels: {
        color: "#ffffff",
        formatter: (_, context) => context.chart.data.labels[context.dataIndex],
        font: { size: 24 },
      },
    },
  },
});

const valueGenerator = (angleValue) => {
  for (let i of segments) {
    if (angleValue >= i.startAngle && angleValue <= i.endAngle) {
      finalValue.innerHTML = `<p>ID: ${i.id}</p><p>Label: ${i.label}</p><p>Value: ${i.value}</p>`;
      spinBtn.disabled = false;
      break;
    }
  }
};

let count = 0;
let resultValue = 101;

spinBtn.addEventListener("click", () => {
  spinBtn.disabled = true;
  finalValue.innerHTML = `<p>Good Luck!</p>`;

  let randomDegree = Math.floor(Math.random() * (355 - 0 + 1) + 0);

  let rotationInterval = window.setInterval(() => {
    myChart.options.rotation = myChart.options.rotation + resultValue;
    myChart.update();

    if (myChart.options.rotation >= 360) {
      count += 1;
      resultValue -= 5;
      myChart.options.rotation = 0;
    } else if (count > 15 && myChart.options.rotation === randomDegree) {
      valueGenerator(randomDegree);
      clearInterval(rotationInterval);
      count = 0;
      resultValue = 101;
    }
  }, 10);
});
