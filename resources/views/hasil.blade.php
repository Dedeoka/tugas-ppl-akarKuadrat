<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <title>Document</title>
</head>

<body>
    <h1>bilangan akar kuadrat</h1>
    <form>
        @csrf
        <p>Masukan Bilangan Yang Ingin Di Proses</p>
        <input type="text" name="bilangan">
        <button type="submit" class="btn btn-success">Submit</button>
    </form>
    <p id="lastNumber">Hasil Bilangan</p>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
    <script>
        axios.get('api/test')
            .then(function(response) {
                var lastNumber = response.data.last_number;
                document.getElementById('lastNumber').textContent = lastNumber;
            })
            .catch(function(error) {
                console.log(error);
            });
    </script>
</body>

</html>
