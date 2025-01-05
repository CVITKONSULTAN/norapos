<html>
    <head>Test</head>
    <body>
        <form action="{{route('sekolah_sd.upload')}}" enctype="multipart/form-data" method="POST">
            <input name="file_data" type="file" />
            <button type="submit"> Upload</button>
        </form>
    </body>
</html>