
function tampilkan_chart(mahasiswa, nama) {

    const ctx = document.getElementById("myChart");
    const myChart = new Chart(ctx, {
        type: "bar",
        data: {
            labels: nama,
            datasets: [
                {
                    label: "Jumlah Mata Kuliah",
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

function chart_semester(label, dataset) {
    const chart_id = document.getElementById("canvas_semester_chart");
    const x = new Chart(chart_id, {
        type: "bar",
        data: {
            labels: label,
            datasets: [
                {
                    label: "Jumlah Mata Kuliah",
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

function chart_jenis(label, dataset) {
    const chart_id = document.getElementById("canvas_jenis_chart");
    const jenis = new Chart(chart_id, {
        type: "bar",
        data: {
            labels: label,
            datasets: [
                {
                    label: 'Jumlah Matakuliah',
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

function chart_wajib(label, dataset) {
    const chart_id = document.getElementById("canvas_wajib_chart");
    const sder = new Chart(chart_id, {
        type: "pie",
        data: {
            labels: label,
            datasets: [
                {
                    label: "Jumlah",
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
