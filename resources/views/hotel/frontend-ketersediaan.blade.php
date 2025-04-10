<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ketersediaan Kamar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            background: linear-gradient(270deg, #e3ffe7, #d9e7ff);
            background-size: 400% 400%;
            animation: gradientBG 10s ease infinite;
            margin: 0;
            padding: 0;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .header, .footer {
            background: linear-gradient(270deg, #34a300, #076200);
            background-size: 400% 400%;
            animation: gradientHeaderFooter 10s ease infinite;
            color: white;
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        @keyframes gradientHeaderFooter {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .header .title {
            font-size: 1.5rem;
        }

        .video-container {
            width: 50%;
            float: left;
            padding: 1rem;
        }

        .room-cards {
            width: 50%;
            float: right;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            padding: 1rem;
        }

        .room-card {
            flex: 0 0 25%;
            background: linear-gradient(270deg, #ff9a9e, #fad0c4);
            color: black;
            text-align: center;
            margin: 10px;
            padding: 10px;
            border-radius: 10px;
            animation: gradientCard 7s ease infinite;
            /* font-size: 1.5rem; */
            font-size: 12pt;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .room-card h1 {
            font-size: 20px;
        }
        .room-card h2 {
            font-size: 15px;
        }
        .room-card strong {
            font-size: 13pt;
        }

        .room-card:nth-child(1) {
            background: linear-gradient(270deg, #ff9a9e, #fad0c4);
        }

        .room-card:nth-child(2) {
            background: linear-gradient(270deg, #a1c4fd, #c2e9fb);
        }

        .room-card:nth-child(3) {
            background: linear-gradient(270deg, #fbc2eb, #a6c1ee);
        }

        .room-card:nth-child(4) {
            background: linear-gradient(270deg, #ffecd2, #fcb69f);
        }

        .room-card:nth-child(5) {
            background: linear-gradient(270deg, #d4fc79, #96e6a1);
        }

        @keyframes gradientCard {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 1.2rem;
        }

        .footer .marquee {
            overflow: hidden;
            white-space: nowrap;
            width: 100%;
            font-weight: bold;
        }

        .footer .marquee span {
            display: inline-block;
            animation: marquee 30s linear infinite;
        }

        @keyframes marquee {
            from { transform: translateX(100%); }
            to { transform: translateX(-100%); }
        }

        .text-keterangan{
            font-size: 14pt;
        }

    </style>
</head>
<body>
    <div class="header">
        <div class="title">Hotel Grand Kartika Pontianak</div>
        <div id="current-time">13 Januari 2022<br>19:54:50</div>
    </div>

    <!-- Video Section -->
    <div class="video-container">
        <div class="ratio ratio-16x9">
            <iframe src="https://20.detik.com/watch/livestreaming-trans7?autoplay=1" frameborder="0" allow="autoplay" allowfullscreen></iframe>
        </div>
        <div class="mt-2">
            <h1 class="text-keterangan">Informasi ketersediaan kamar hubungi 
                <span style="color: red;">RECEPTIONIS</span>/ 
                <span style="color:red;">082255985321</span>
            </h1>    
            <p style="font-size: 7pt;">Load data dalam (<span class="counter">15</span>)s</p>
            <p style="font-size: 12pt;">Superior <span class="stats_superior">0</span></p>
            <p style="font-size: 12pt;">Riverside <span class="stats_riverside">0</span></p>
        </div>
    </div>

    <!-- Room Availability Cards -->
    <div class="room-cards"></div>

    <div class="footer">
        <div class="marquee">
            <span>Nikmati kenyamanan Hotel Grand Kartika Pontianak. Check-out pukul 12.00 WIB, check-in pukul 14.00 WIB.</span>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let counter = 15;
        function updateTime() {
            const now = new Date();
            const day = now.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
            const time = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
            document.getElementById('current-time').innerHTML = `${day}<br>${time} WIB`;
            counter--;
            $('.counter').text(counter);
            if(counter <= 0) counter = 15;
        }

        setInterval(updateTime, 1000);
        updateTime();

        const loadData = () => {
            $.ajax({
                url: '{{route("hotel.avail")}}',
                method: 'GET',
                success: (response) => {
                    if(!response.status) return;
                    const data = response.data;
                    $(`.stats_superior`).text(data.stats.superior ?? 0);
                    $(`.stats_riverside`).text(data.stats.riverside ?? 0);
                    const roomCards = $('.room-cards')
                    roomCards.empty();
                    data.forEach((room, index) => {
                        if(room.brand == "") return;
                        const card = `
                            <div class="room-card">
                                <h1>${room.available}</h1>
                                <h2>${room.brand} (${room.total})</h2>
                            </div>
                        `;
                        roomCards.append(card);
                    });
                    
                }
            })
        }
        setInterval(loadData, 15000);
        loadData();
    </script>
</body>
</html>