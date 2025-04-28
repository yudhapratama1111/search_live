<?php
    header('Content-Type:application/json');
    include 'db.php';
    $keyword = isset($_POST['keyword']) ?
        $koneksi->real_escape_string($_POST['keyword']):
        (isset($_GET['keyword']) ?
        $koneksi->real_escape_string($_GET['keyword']):
        '');
    if (empty($keyword)) {
        echo json_encode([]);
        exit;
    }
    
    $sql = "SELECT nim, nama, jurusan FROM mahasiswa WHERE nim LIKE '%$keyword%' OR nama LIKE '%$keyword%' LIMIT 100";
    $result = $koneksi->query($sql);
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    echo json_encode($data);
?>