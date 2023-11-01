
function tampilkan_chart(mahasiswa, nama, total) {
    document.getElementById("totaldata").innerText = total;

    const ctx = document.getElementById("myChart");
    const myChart = new Chart(ctx, {
        type: "bar",
        data: {
            labels: nama,
            datasets: [
                {
                    label: "Jumlah Mahasiswa",
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

function tampilkan_chart_pertama(label,dataset) {
    const chart_id = document.getElementById("angkatan_chart");
    const chart_angkatan = new Chart(chart_id, {
        type: "line",
        data: {
            labels: label,
            datasets: [
                {
                    label: "Angkatan",
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

function tampilkan_chart_kedua(label,dataset) {
    const chart_id = document.getElementById("jalur_chart");
    const chart_jalurmasuk = new Chart(chart_id, {
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

function tampilkan_chart_ketiga(dataset) {
    const chart_id = document.getElementById("kelamin_chart");
    const chart = new Chart(chart_id, {
        type: "pie",
        data: {
            labels: ["Laki-laki", "Perempuan"],
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

function tampilkan_chart_keempat(dataset) {
    const chart_id = document.getElementById("ipk_chart");
    const chart_ipk = new Chart(chart_id, {
        type: "bar",
        data: {
            labels: ["0.00 - 2.00", "2.01 - 2.50", "2.51 - 3.00", "3.01 - 3.50", "3.51 - 4.00"],
            datasets: [
                {
                    label: "Jumlah Berdasarkan IPK",
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
