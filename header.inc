<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="description" content="<?php echo $page_description; ?>">
        <meta name="keywords" content="HTML5, CSS, Form, tags">
        <meta name="author" content="Group 7">
        <title><?php echo $page_title; ?></title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="index.css">
        <link rel="stylesheet" href="Styles.css">
    </head>
    <body>
        <header class="top_area">
            <a href="#" class="logo">
                <img src="images/FINTECH_LOGO.jpeg" alt="Fintech Logo" height="65rem" width="250rem">
            </a>

            <?php include 'navigation.inc'; ?>

            <div class="searchbar">
                <input type="text" placeholder="Search...">
                <button type="submit"><i class="fa fa-search"></i></button>
            </div>
        </header>