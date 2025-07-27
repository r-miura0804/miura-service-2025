<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>日記作成</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        h1 { text-align: center; color: #333; }
        label { display: block; margin-bottom: 8px; font-weight: bold; }
        input[type="text"],
        input[type="datetime-local"],
        textarea {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        textarea { resize: vertical; min-height: 150px; }
        button {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover { background-color: #0056b3; }
        .error-message { color: red; margin-bottom: 10px; }
        .back-link { display: block; text-align: center; margin-top: 20px; color: #007bff; text-decoration: none; }
    </style>
</head>
<body>
    <div class="container">
        <h1>日記新規作成</h1>

        @if ($errors->any())
            <div class="error-message">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('diary.create') }}" method="POST">
            @csrf
            <label for="entry_datetime">日付</label>
            <input type="datetime-local" id="entry_datetime" name="entry_datetime" value="{{ old('entry_datetime', $entry_datetime_default ?? '') }}" required readonly>

            <label for="title">タイトル:</label>
            <input type="text" id="title" name="title" value="{{ old('title') }}" required>

            <label for="content">内容:</label>
            <textarea id="content" name="content" required>{{ old('content') }}</textarea>

            <button type="submit">日記を保存</button>
        </form>

        <a href="{{ route('diary.calendar') }}" class="back-link">カレンダーに戻る</a>
    </div>
</body>
</html>