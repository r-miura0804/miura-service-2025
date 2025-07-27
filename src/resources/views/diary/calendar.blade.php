<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>日記カレンダー</title>
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/main.min.css' rel='stylesheet' />
    <style>
        body { font-family: sans-serif; margin: 20px; background-color: #f4f4f4; }
        .container {
            max-width: 900px; /* カレンダーに合わせて少し広げる */
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h1 { text-align: center; color: #333; margin-bottom: 20px; }
        #calendar {
            margin-top: 20px;
            font-size: 1.1em;
        }
        .fc-daygrid-day-number {
            cursor: pointer;
        }
        .success-message {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>
<body>
    @if (session('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
    @endif
    <div class="container">
        <h1>日記カレンダー</h1>
        <div id='calendar'></div>
    </div>

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.11/locales/ja.global.min.js'></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth', // 月表示
                locale: 'ja',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                buttonText: {
                    today: '今日',
                    month: '月',
                    week: '週',
                    day: '日'
                },
                dateClick: function(info) {
                    const clickedDate = info.dateStr;
                    // クリックされた日付の日記新規作成or編集ページへ遷移
                    window.location.href = `/diary/${clickedDate}/manage`;
                },
            });
            calendar.render();
        });
    </script>
</body>
</html>