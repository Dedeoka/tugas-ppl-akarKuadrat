<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <title>Document</title>
</head>

<body>
    <div class="text-center">
        <h1>bilangan akar kuadrat</h1>
        <form>
            <p>Masukan Bilangan Yang Ingin Di Proses</p>
            <input type="text" name="bilangan">
            <div id="bilangan-error" class="text-danger"></div>
            <button type="submit" class="btn btn-success mt-5">Submit</button>
        </form>

        <!-- Tampilkan Waktu Eksekusi -->
        <div id="execution-time">
            <!-- Waktu eksekusi akan ditampilkan di sini -->
        </div>

        <!-- Tampilkan Hasil -->
        <div id="hasil">
            <!-- Hasil akan ditampilkan di sini -->
        </div>

        <div class="container">
            <h1 class="mt-5">Data Bilangan</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Bilangan</th>
                        <th>Akar Kuadrat</th>
                        <th>Waktu Eksekusi (detik)</th>
                    </tr>
                </thead>
                <tbody id="data-table">
                    <!-- Data akan ditampilkan di sini menggunakan JavaScript -->
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        // Fungsi untuk mengambil dan menampilkan data dari API
        function fetchData() {
            axios.get('/api/test')
                .then(function(response) {
                    var data = response.data;
                    var tableBody = document.getElementById('data-table');
                    tableBody.innerHTML = ''; // Menghapus isi tabel sebelumnya

                    data.forEach(function(item) {
                        var row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${item.id}</td>
                            <td>${item.bilangan}</td>
                            <td>${item.akar_kuadrat}</td>
                            <td>${item.waktu}</td>
                        `;
                        tableBody.appendChild(row);
                    });
                })
                .catch(function(error) {
                    console.log(error);
                });
        }
    </script>
    <script>
        // Mengambil elemen form dan div waktu eksekusi
        var form = document.querySelector('form');
        var executionTimeDiv = document.getElementById('execution-time');

        // Menambahkan event listener untuk menghandle submit form
        form.addEventListener('submit', function(event) {
            event.preventDefault(); // Mencegah submit form

            // Mengambil bilangan dari input form
            var bilangan = document.querySelector('input[name="bilangan"]').value;


            // Mengirim permintaan POST ke API
            // Setelah permintaan POST berhasil, tambahkan kode berikut untuk memperbarui tabel
            axios.post('/api/test', {
                    bilangan: bilangan
                })
                .then(function(response) {
                    // Menghentikan timer
                    // Menampilkan waktu eksekusi di dalam div waktu eksekusi
                    executionTimeDiv.innerHTML = 'Waktu Eksekusi: ' + response.data.waktu_eksekusi +
                        ' milidetik';

                    // Menampilkan hasil bilangan terakhir dan hasil kuadratnya
                    var bilanganTerakhir = response.data.bilangan_terakhir;
                    var hasilKuadrat = response.data.hasil_kuadrat;
                    var hasilElement = document.getElementById('hasil');
                    hasilElement.innerHTML = '<br>Hasil Akar Kuadrat: ' + hasilKuadrat;

                    // Memperbarui tabel dengan data yang diperbarui
                    fetchData();
                })
                .catch(function(error) {
                    // Menampilkan pesan validasi error jika ada
                    if (error.response && error.response.status === 422) {
                        var errors = error.response.data;
                        if (errors.bilangan) {
                            var bilanganErrorDiv = document.getElementById('bilangan-error');
                            bilanganErrorDiv.textContent = errors.bilangan[0];
                        }
                    } else {
                        console.log(error);
                    }
                });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
</body>

</html>
