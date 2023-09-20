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
            <button type="submit" class="btn btn-success">Submit</button>
        </form>

        <!-- Tampilkan Waktu Eksekusi -->
        <div id="execution-time">
            <!-- Waktu eksekusi akan ditampilkan di sini -->
        </div>

        <!-- Tampilkan Hasil -->
        <div id="hasil">
            <!-- Hasil akan ditampilkan di sini -->
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        // Mengambil elemen form dan div waktu eksekusi
        var form = document.querySelector('form');
        var executionTimeDiv = document.getElementById('execution-time');

        // Menambahkan event listener untuk menghandle submit form
        form.addEventListener('submit', function(event) {
            event.preventDefault(); // Mencegah submit form

            // Mengambil bilangan dari input form
            var bilangan = document.querySelector('input[name="bilangan"]').value;

            // Memulai timer
            var startTime = performance.now();

            // Mengirim permintaan POST ke API
            axios.post('/api/test', {
                    bilangan: bilangan
                })
                .then(function(response) {
                    // Menghentikan timer
                    var endTime = performance.now();
                    var executionTime = endTime - startTime;

                    // Menampilkan waktu eksekusi di dalam div waktu eksekusi
                    executionTimeDiv.innerHTML = 'Waktu Eksekusi: ' + executionTime.toFixed(2) + ' milidetik';

                    // Menampilkan hasil bilangan terakhir dan hasil kuadratnya
                    var bilanganTerakhir = response.data.bilangan_terakhir;
                    var hasilKuadrat = response.data.hasil_kuadrat;
                    var hasilElement = document.getElementById('hasil');
                    hasilElement.innerHTML = '<br>Hasil Akar Kuadrat: ' +
                        hasilKuadrat;
                })
                .catch(function(error) {
                    console.log(error);
                });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
</body>

</html>
