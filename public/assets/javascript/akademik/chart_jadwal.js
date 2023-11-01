function tampilkan_chart(mahasiswa, nama) {
    const ctx = document.getElementById("myChart");
    const myChart = new Chart(ctx, {
        type: "bar",
        data: {
            labels: nama,
            datasets: [
                {
                    label: "Jumlah kelas",
                    data: mahasiswa,
                    backgroundColor: "yellow",
                    borderColor: "white",
                    borderWidth: 1,
                },
            ],
        },
        options: {
            responsive: true,
            indexAxis: "y",
            scales: {
                x: {
                    ticks: {
                        color: "white",
                    },
                    grid: {
                        color: "white",
                    },
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: "white",
                    },
                    grid: {
                        display: false,
                    },
                },
            },
            plugins: {
                legend: {
                    display: false,
                },
            },
        },
    });
}

function tampilkan_chart_pertama(label, dataset) {
    const chart_id = document.getElementById("kelas_chart");
    const kls = new Chart(chart_id, {
        type: "bar",
        data: {
            labels: label,
            datasets: [
                {
                    label: "Kelas",
                    data: dataset,
                    backgroundColor: [
                        "rgb(255, 99, 132)",
                        "rgb(255, 159, 64)",
                        "rgb(54, 162, 235)",
                        "rgb(153, 102, 255)",
                        "rgb(201, 203, 207)",
                        "rgb(255, 140, 18)",
                        "rgb(186, 2, 54)",
                    ],
                },
            ],
        },
        options: {
            responsive: true,
            indexAxis: "x",
            plugins: {
                legend: {
                    display: false,
                },
            },
            scales: {
                y: {
                    beginAtZero: true,
                    callback: function (value) {
                        if (value % 1 === 0) {
                            return value;
                        }
                    },
                },
            },
        },
    });
}

function tampilkan_chart_kedua(label, dataset) {
    const chart_id = document.getElementById("hari_chart");
    const hri = new Chart(chart_id, {
        type: "bar",
        data: {
            labels: label,
            datasets: [
                {
                    label: "Jumlah",
                    data: dataset,
                    backgroundColor: [
                        "rgb(255, 99, 132)",
                        "rgb(255, 159, 64)",
                        "rgb(54, 162, 235)",
                        "rgb(153, 102, 255)",
                        "rgb(201, 203, 207)",
                        "rgb(255, 140, 18)",
                        "rgb(186, 2, 54)",
                    ],
                },
            ],
        },
        options: {
            responsive: true,
            aspectRatio: 2,
            indexAxis: "y",
            plugins: {
                legend: {
                    display: false,
                },
            },
        },
    });
}

function tampilkan_chart_ketiga(label, dataset) {
    const chart_id = document.getElementById("jam_chart");
    const jms = new Chart(chart_id, {
        type: "pie",
        data: {
            labels: label,
            datasets: [
                {
                    label: "Jam Perkuliahan",
                    data: dataset,
                    backgroundColor: [
                        "rgb(255, 99, 71)",
                        "rgb(255, 215, 0)",
                        "rgb(0, 128, 128)",
                        "rgb(128, 0, 128)",
                        "rgb(255, 255, 0)",
                        "rgb(192, 192, 192)",
                        "rgb(128, 128, 128)",
                        "rgb(255, 165, 0)",
                        "rgb(255, 105, 180)",
                        "rgb(138, 43, 226)",
                        "rgb(0, 206, 209)",
                        "rgb(205, 92, 92)",
                        "rgb(205, 133, 63)",
                        "rgb(255, 20, 147)",
                        "rgb(176, 224, 230)",
                        "rgb(144, 238, 144)",
                        "rgb(60, 179, 113)",
                        "rgb(95, 158, 160)",
                        "rgb(100, 149, 237)",
                        "rgb(0, 191, 255)",
                        "rgb(250, 250, 210)",
                        "rgb(218, 165, 32)",
                        "rgb(210, 105, 30)",
                        "rgb(205, 201, 201)",
                        "rgb(102, 205, 170)",
                    ],
                },
            ],
        },
        options: {
            responsive: true,
            aspectRatio: 2,
            indexAxis: "y",
            plugins: {
                legend: {
                    display: true,
                },
            },
        },
    });
}
