<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
<meta name="csrf-token" content="{{ csrf_token() }}" />

<!-- Tailwind is included -->
<link rel="stylesheet" href="{{ asset('css/main.css?v=1652870200386') }}">
@vite('resources/css/app.css')

<link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png"/>
<link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png"/>
<link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png"/>
<link rel="mask-icon" href="safari-pinned-tab.svg" color="#00b4b6"/>

{!! SEO::generate() !!}

<!-- <meta name="description" content="Denpasar Menyama Bagia - Denpasar Menyama Bagia adalah program konseling dari Pemerintah Kota Denpasar yang berfokus pada kesehatan mental anak sekolah. Dapatkan dukungan psikologis untuk tumbuh kembang yang lebih baik.">

<meta property="og:url" content="{{ url('/') }}">
<meta property="og:site_name" content="Denpasar Menyama Bagia">
<meta property="og:title" content="Denpasar Menyama Bagia - Program Konseling untuk Anak Sekolah">
<meta property="og:description" content="Denpasar Menyama Bagia - Denpasar Menyama Bagia adalah program konseling dari Pemerintah Kota Denpasar yang berfokus pada kesehatan mental anak sekolah. Dapatkan dukungan psikologis untuk tumbuh kembang yang lebih baik.">
<meta property="og:image" content="{{ asset('img/logo_dmb.png') }}">
<meta property="og:image:type" content="image/png"> -->
<!-- <meta property="og:image:width" content="1920">
<meta property="og:image:height" content="960"> -->

<!-- <meta property="twitter:card" content="summary_large_image">
<meta property="twitter:title" content="Admin One HTML">
<meta property="twitter:description" content="Admin One - free Tailwind dashboard">
<meta property="twitter:image:src" content="https://justboil.me/images/one-tailwind/repository-preview-hi-res.png">
<meta property="twitter:image:width" content="1920">
<meta property="twitter:image:height" content="960"> -->