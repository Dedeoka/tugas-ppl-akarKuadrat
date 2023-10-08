<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <title>Perhitungan Akar Kuadrat</title>
</head>

<body>
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 11">
        <div id="toast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true"
            data-delay="3000">
            <div class="toast-header">
                <strong class="me-auto">Pemberitahuan</strong>
            </div>
            <div class="toast-body" id="toast-message">
                <!-- Pesan toast akan ditampilkan di sini -->
            </div>
        </div>
    </div>

    <div class="text-center border border-secondary">
        <h1 class="pt-5">Kalkulator Akar Kuadrat</h1>
        <form>
            <p>Masukan Bilangan Yang Ingin Di Akar Kuadratkan</p>
            <div class="d-flex justify-content-center">
                <input type="text" name="bilangan" class="rounded" placeholder="Masukan Bilangan...">
                &nbsp;&nbsp;&nbsp;
                <button type="submit" class="btn btn-success ml-5">Submit</button>
            </div>
            <div id="bilangan-error" class="text-danger pb-5"></div>
        </form>

        <div class="w-25 justify-content-center" style="margin: 0 auto;" id="container">
            <!-- Tampilkan Hasil -->
            <div id="hasil" class="pb-3 fw-bold">
                <!-- Hasil akan ditampilkan di sini -->
            </div>
            <!-- Tampilkan Waktu Eksekusi -->
            <div id="execution-time" class="pb-3 fw-bold">
                <!-- Waktu eksekusi akan ditampilkan di sini -->
            </div>
        </div>

        <div class="container pb-5">
            <h1 class="mt-5 mb-5 border-bottom"">Data Hasil Akar Kuadrat</h1>
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
        function showToast(message) {
            var toast = new bootstrap.Toast(document.getElementById('toast'));
            document.getElementById('toast-message').innerText = message;
            toast.show();

            // Menyembunyikan toast setelah beberapa detik (sesuai dengan data-delay)
            setTimeout(function() {
                toast.hide();
            }, 3000); // Waktu dalam milidetik (3000 ms = 3 detik)
        }
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
                    const container = document.getElementById('container');
                    container.style.border = '1px solid';
                    executionTimeDiv.innerHTML = 'Waktu Eksekusi: ' + response.data.waktu_eksekusi +
                        ' detik';

                    // Menampilkan hasil bilangan terakhir dan hasil kuadratnya
                    var bilanganTerakhir = response.data.bilangan_terakhir;
                    var hasilKuadrat = response.data.hasil_kuadrat;
                    var hasilElement = document.getElementById('hasil');
                    hasilElement.innerHTML = '<br>Hasil Perhitungan: ' + hasilKuadrat;
                    showToast('Perhitungan berhasil!');
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
                        showToast('Terjadi kesalahan. Silakan coba lagi nanti.');
                    } else {
                        console.log(error);
                    }
                });
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1o5c/6RK5QnrF6H3Rdf5cl" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
</body>

</html>
