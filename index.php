<?php 
    require 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Live Search Mahasiswa</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="bootstrap-5.3.3-dist\jquery\jquery-3.3.1.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <style>
        /* #loading { 
        display: none; 
        font-weight: bold;}*/
        .fade-in {
            opacity: 0;
            transform: translateY(10px);
            animation: fadeIn 0.4s ease-out forwards;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="p-4">
    <div class="container">
        <h2 class="mb-4">Live Search Mahasiswa (AJAX + MySQL)</h2>
        <input type="text" id="search" class="form-control mb-3" placeholder="Ketik Nama atau NIM Anda...">

        <!-- Spinner Loading -->
        <div id="loading" class="text-center mb-3" style="display: none;">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <div>Mencari Data...</div>
        </div>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>NIM</th>
                <th>Nama</th>
                <th>Jurusan</th>
            </tr>
        </thead>
        <tbody id="result"></tbody>
    </table>
    </div>

    <script>
        const searchBox = document.getElementById("search");
        const result = document.getElementById("result");
        const loading = document.getElementById("loading");
        searchBox.addEventListener("keyup", function() {
            const keyword = searchBox.value.trim();
            if(keyword.length === 0) {
                result.innerHTML = ""; 
                return;
            }

            loading.style.display = "block";
            fetch("search.php?keyword=" + encodeURIComponent(keyword))
            .then(res => res.json())
            .then(data => {
                loading.style.display = "none";
                result.innerHTML = "";

                if(data.length === 0) {
                    result.innerHTML="<tr><td colspan='3' class='text-center'>Data tidak ditemukan :(</td></tr>";
                } else {
                    data.forEach(row => {
                        const tr = document.createElement("result");
                        result.classList.add("fade-in");
                        result.innerHTML = ` <tr>
                        <td>${row.nim}</td>
                        <td>${row.nama}</td>
                        <td>${row.jurusan}</td>
                        </tr>`;

                        //const rowHTML = `<tr style="display: none;">
                        // <td>${row.nim}</td>
                        // <td>${row.nama}</td>
                        // <td>${row.jurusan}</td>
                        // </tr>`;

                        const tempRow = $(rowHTML).hide().fadeIn(1000);
                        result.appendChild(tempRow[0]);
                    });
                }
            });
        });
    </script>
</body>
</html>