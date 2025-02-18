<?php
session_start();

function isLoggedIn()
{
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

if (!isLoggedIn()) {
    echo "<script>alert('Anda harus login terlebih dahulu!');</script>";
    echo "<script>window.location.href = 'login.php';</script>";    
}



?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard UKM</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <div class="min-h-screen flex flex-col">
        <header class="bg-[#003092] text-white p-4 fixed top-0 left-0 right-0 z-10">
            <div class="w-full flex flex-row items-center justify-between px-4 sm:px-8 md:px-12 lg:px-16">
                <div class="flex flex-row items-center gap-4">
                    <img  src="./static/images/amikom.png" alt="Logo UKM" class="w-8 h-8 min-w-8 min-h-8"/>
                    <h1 class="text-xl font-semibold">Dashboard UKM</h1>
                </div>
                <div class="flex flex-row items-center gap-8 font-medium">
                    <a href="dashboard.php" class="text-white">Dashboard</a>
                    <a href="ukm.php" class="text-white">Kelola UKM</a>
                    <a href="logout.php" class="bg-[#FF8000] text-white py-2 px-4 rounded-md">Logout</a>
                </div>
            </div>
        </header>
        <main class="flex-1 p-4 pt-28">