<form action="{{ url('data/upload') }}" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}
    <input type="file" name="file" />
    <input type="submit">
</form>