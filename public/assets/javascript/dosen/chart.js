
function tampilkan_chart(mahasiswa, nama, total) {
    document.getElementById("totaldata").innerText = total;

    const ctx = document.getElementById("myChart");
    const myChart = new Chart(ctx, {
        type: "bar",
        data: {
            labels: nama,
            datasets: [
                {
                    label: "Jumlah",
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

function chart_fungsional(label, dataset) {
    const chart_id = document.getElementById("canvas_fungsional_chart");
    const x = new Chart(chart_id, {
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
            indexAxis: "x",
            plugins: {
                legend: {
                    display: false,
                },
            },
            scales: {
                y: {
                    beginAtZero: true,
                    callback: function(value) {if (value % 1 === 0) {return value;}}
                }
            }
        },
    });
}

function chart_pendidikan(label, dataset) {
    const chart_id = document.getElementById("canvas_pendidikan_chart");
    const pendidikan = new Chart(chart_id, {
        type: "bar",
        data: {
            labels: label,
            datasets: [
                {
                    label: 'Jumlah',
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

function chart_jenis_kelamin(label, dataset) {
    const chart_id = document.getElementById("canvas_kelamin_chart");
    const chart = new Chart(chart_id, {
        type: "pie",
        data: {
            labels: label,
            datasets: [
                {
                    label: "Jenis Kelamin",
                    data: dataset,
                    backgroundColor: [
                        "rgb(255, 99, 132)",
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
            indexAxis: "x",
            plugins: {
                legend: {
                    display: true,
                },
            },
        },
    });
}

function chart_golongan(label, dataset) {
    const chart_id = document.getElementById("canvas_golongan_chart");
    const chartgol = new Chart(chart_id, {
        type: "pie",
        data: {
            labels: label,
            datasets: [
                {
                    label: "Jenis Kelamin",
                    data: dataset,
                    backgroundColor: [
                        "rgb(255, 99, 132)",
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
            indexAxis: "x",
            plugins: {
                legend: {
                    display: true,
                },
            },
        },
    });
}
